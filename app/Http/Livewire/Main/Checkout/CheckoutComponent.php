<?php

namespace App\Http\Livewire\Main\Checkout;

use App\Http\Validators\Main\Checkout\PlaceValidator;
use App\Models\Admin;
use Cartalyst\Stripe\Stripe;
use App\Models\Gig;
use App\Models\GigUpgrade;
use App\Models\Order;
use App\Models\OrderInvoice;
use App\Models\OrderItem;
use App\Models\OrderItemUpgrade;
use App\Models\UserBilling;
use App\Notifications\Admin\PendingOfflinePayment;
use App\Notifications\User\Buyer\OrderPlaced;
use App\Notifications\User\Seller\PendingOrder;
use Livewire\Component;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;

class CheckoutComponent extends Component
{
    use SEOToolsTrait;
    
    public $cart;

    public $payment_method = "credit_card";

    public $paypal_order_id;

    // Billing
    public $firstname;
    public $lastname;
    public $email;
    public $company;
    public $address;

    // CC
    public $card_name;
    public $card_number;
    public $card_expiry;
    public $card_cvc;

    protected $listeners = ['cart-updated' => 'cartUpdated'];

    /**
     * Init component
     *
     * @return void
     */
    public function mount()
    {
        // We have to validate the cart
        // How? For example if user is not logged in, he may be able to add his own gigs to cart and the login to checkout
        // So we need to remove his own gigs from cart after login
        $this->validateCart();

        // Get cart
        $cart = session('cart', []);

        // Check if cart has items
        if (is_array($cart) && count($cart)) {
            
            // Set cart
            $this->cart            = $cart;

            // Set paypal order id if user already made a purchase
            $this->paypal_order_id = session('paypal_order_id', null);

            // Get user billing
            $billing               = UserBilling::firstOrCreate(['user_id' => auth()->id()]);
            
            // Set billing info
            $this->firstname       = $billing->firstname;
            $this->lastname        = $billing->lastname;
            $this->email           = auth()->user()->email;
            $this->company         = $billing->company;
            $this->address         = $billing->address;

        } else {

            // Cart has no items
            return redirect('cart');

        }
    }


    /**
     * Render component
     *
     * @return Illuminate\View\View
     */
    public function render()
    {
        // SEO
        $separator   = settings('general')->separator;
        $title       = __('messages.t_checkout') . " $separator " . settings('general')->title;
        $description = settings('seo')->description;
        $ogimage     = src( settings('seo')->ogimage );

        $this->seo()->setTitle( $title );
        $this->seo()->setDescription( $description );
        $this->seo()->setCanonical( url()->current() );
        $this->seo()->opengraph()->setTitle( $title );
        $this->seo()->opengraph()->setDescription( $description );
        $this->seo()->opengraph()->setUrl( url()->current() );
        $this->seo()->opengraph()->setType('website');
        $this->seo()->opengraph()->addImage( $ogimage );
        $this->seo()->twitter()->setImage( $ogimage );
        $this->seo()->twitter()->setUrl( url()->current() );
        $this->seo()->twitter()->setSite( "@" . settings('seo')->twitter_username );
        $this->seo()->twitter()->addValue('card', 'summary_large_image');
        $this->seo()->metatags()->addMeta('fb:page_id', settings('seo')->facebook_page_id, 'property');
        $this->seo()->metatags()->addMeta('fb:app_id', settings('seo')->facebook_app_id, 'property');
        $this->seo()->metatags()->addMeta('robots', 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1', 'name');
        $this->seo()->jsonLd()->setTitle( $title );
        $this->seo()->jsonLd()->setDescription( $description );
        $this->seo()->jsonLd()->setUrl( url()->current() );
        $this->seo()->jsonLd()->setType('WebSite');

        return view('livewire.main.checkout.checkout')->extends('livewire.main.layout.app')->section('content');
    }

    /**
     * Count total price of an item in cart
     *
     * @param string $id
     * @return integer
     */
    public function itemTotalPrice($id)
    {
        // Set empty var total price
        $total = 0;

        // Loop throug items in cart
        foreach ($this->cart as $key => $item) {
            
            // Check if item exists
            if ($item['id'] === $id) {
                
                // Get quantity
                $quantity = (int) $item['quantity'];

                // Sum upgrades total price
                if (is_array($item['upgrades']) && count($item['upgrades'])) {
                    
                    $total_upgrades_price = array_reduce($item['upgrades'], function($i, $obj)
                    {
                        // Calculate only selected upgrades
                        if ($obj['checked'] == true) {
                            return $i += $obj['price'];
                        } else {
                            return $i;
                        }

                    });

                } else {

                    // No upgrades selected
                    $total_upgrades_price = 0;

                }

                // Set new total
                $total = ($quantity * $item['gig']['price']) + ($total_upgrades_price * $quantity);

            }

        }

        // Return total price
        return $total;

    }


    /**
     * Calculate subtotal price
     *
     * @return integer
     */
    public function subtotal()
    {
        // Calculate subtotal
        $subtotal = $this->total();

        // Return subtotal
        return $subtotal;
    }


    /**
     * Calculate taxes
     *
     * @return integer
     */
    public function taxes()
    {
        // Get commission settings
        $settings = settings('commission');

        // Check if taxes enabled
        if ($settings->enable_taxes) {
            
            // Check if type of taxes percentage
            if ($settings->tax_type === 'percentage') {
                
                // Get tax amount
                $tax = bcmul($this->total(), $settings->tax_value) / 100;

                // Return tax amount
                return $tax;

            } else {
                
                // Fixed price
                $tax = $this->total() - $settings->tax_value;

                // Return tax
                return $tax;

            }

        } else {

            // Taxes not enabled
            return 0;

        }
    }


    /**
     * Calculate total price
     *
     * @return integer
     */
    public function total()
    {
        // Set total empty variable
        $total = 0;

        // Loop through items in cart
        foreach ($this->cart as $key => $item) {
            
            // Update total price
            $total += $this->itemTotalPrice($item['id']);

        }

        // Return total price
        return $total;
    }


    /**
     * Calculate commission
     *
     * @param string $price
     * @return integer
     */
    public function commission($price)
    {
        // Get settings
        $settings = settings('commission');

        // Commission percentage
        if ($settings->commission_type === 'percentage') {
            
            // Calculate commission
            $commission = $settings->commission_value * $price / 100;

        } else {

            // Fixed amount
            $commission = $settings->commission_value;

        }

        // Return commission
        return $commission;
    }


    /**
     * Update paypal order id
     *
     * @param string $orderId
     * @return void
     */
    public function updatedPaypalOrderId($orderId)
    {
        // Delete old value
        session()->forget('paypal_order_id');

        // Set new value
        session()->put('paypal_order_id', $orderId);
    }


    /**
     * Place order now
     *
     * @return void
     */
    public function place()
    {
        try {

            // Check payment method
            if (!in_array($this->payment_method, ['paypal', 'credit_card', 'balance', 'offline'])) {
               
                // Error
                $this->dispatchBrowserEvent('alert',[
                    "message" => __('messages.t_please_choose_a_payment_method'),
                    "type"    => "error"
                ]);

                // Return
                return;

            }

            // Validate billing info
            PlaceValidator::validate($this);

            // Get payment gateways settings
            $gateways              = settings('gateways');

            // Get commission settings
            $settings              = settings('commission');

            // Set unique id for this order
            $uid                   = uid();

            // Get buyer id
            $buyer_id              = auth()->id();

            // Count taxes amount
            $taxes                 = $this->taxes();

            // Count subtotal amount
            $subtotal              = $this->subtotal();

            // Count total amount
            $total                 = $this->total() + $taxes;

            // Check if paypal payment selected
            if ($gateways->is_paypal && $this->payment_method === 'paypal') {
                
                // Set paypal provider and config
                $paypal_provider = new PayPalClient();
    
                // Get paypal access token
                $paypal_provider->getAccessToken();
    
                // Capture this order
                $paypal_order    = $paypal_provider->capturePaymentOrder($this->paypal_order_id);

                // Let's see if payment suuceeded
                if ( is_array($paypal_order) && $paypal_order['status'] === 'COMPLETED' ) {
                    
                    // Payment succeeded, but we need to verify that total price is same from paypal request
                    if ($total != $paypal_order['purchase_units'][0]['payments']['captures'][0]['amount']['value']) {
                        
                        // Payment amount not correct
                        $this->dispatchBrowserEvent('alert',[
                            "message" => __('messages.t_amount_from_paypal_not_correct_as_cart'),
                            "type"    => "error"
                        ]);
    
                        // Return
                        return;

                    }

                    // Set payment id
                    $payment_id     = $paypal_order['id'];

                    // Set payment method
                    $payment_method = 'paypal';

                } else {

                    // Paypal not completed
                    $this->dispatchBrowserEvent('alert',[
                        "message" => __('messages.t_sorry_we_couldnt_handle_ur_paypal_payment'),
                        "type"    => "error"
                    ]);

                    // Return
                    return;

                }

            } else if ($gateways->is_stripe && $this->payment_method === 'credit_card') {
                
                // Stripe credit card payment selected
                $stripe = new Stripe( config('services.stripe.secret') );

                try {

                    // Explode expiry date from view
                    $expiry_date = explode(' / ', $this->card_expiry);

                    // Get token from stripe
                    $token       = $stripe->tokens()->create([
                        'card' => [
                            'number'    => str_replace(' ', '', $this->card_number),
                            'exp_month' => $expiry_date[0],
                            'exp_year'  => $expiry_date[1],
                            'cvc'       => $this->card_cvc
                        ],
                    ]);

                    // Check if cc is correct
                    if (!isset($token['id'])) {
                        
                        // Invalid credit card
                        $this->dispatchBrowserEvent('alert',[
                            "message" => __('messages.t_pls_enter_valid_cc_data'),
                            "type"    => "error"
                        ]);
    
                        // Return
                        return;

                    }

                    // Card is valid, let's charge the buyer
                    $charge = $stripe->charges()->create([
                        'card'        => $token['id'],
                        'currency'    => settings('currency')->code,
                        'amount'      => $total,
                        'description' => 'wallet',
                    ]);
            
                    // Payment succeeded
                    if($charge['status'] == 'succeeded') {
                        
                        // Set payment id
                        $payment_id     = $charge['id'];

                        // Set payment method
                        $payment_method = 'stripe';

                    } else {
                        
                        // Failed payment
                        $this->dispatchBrowserEvent('alert',[
                            "message" => __('messages.t_payment_cc_failed_try_again'),
                            "type"    => "error"
                        ]);
    
                        // Return
                        return;

                    }

                } catch (\Throwable $th) {
                    
                    // Error
                    $this->dispatchBrowserEvent('alert',[
                        "message" => $th->getMessage(),
                        "type"    => "error"
                    ]);

                    // Return
                    return;

                } catch(\Cartalyst\Stripe\Exception\CardErrorException $e) {

                    // Error
                    $this->dispatchBrowserEvent('alert',[
                        "message" => $e->getMessage(),
                        "type"    => "error"
                    ]);

                    // Return
                    return;

                } catch(\Cartalyst\Stripe\Exception\MissingParameterException $e) {

                    // Error
                    $this->dispatchBrowserEvent('alert',[
                        "message" => $e->getMessage(),
                        "type"    => "error"
                    ]);

                    // Return
                    return;

                }

            } else if ($this->payment_method === 'balance') {
                
                // Check if user has enough money
                if (auth()->user()->balance_available < $total) {
                    
                    // You don't have enough money
                    $this->dispatchBrowserEvent('alert',[
                        "message" => __('messages.t_u_dont_have_enough_money_to_checkout'),
                        "type"    => "error"
                    ]);

                    // Return
                    return;

                }

                // Set payment id
                $payment_id     = uid();

                // Set payment method
                $payment_method = 'balance';

            } else if ($this->payment_method === 'offline') {

                // Check if offline payment enabled
                if (!settings('offline_payment')->is_enabled) {
                    
                    // Not enabled
                    $this->dispatchBrowserEvent('alert',[
                        "message" => __('messages.t_payment_method_not_enabled'),
                        "type"    => "error"
                    ]);

                    // Return
                    return;

                }

                // Set payment id
                $payment_id     = uid();

                // Set payment method
                $payment_method = 'offline';

            }

            // Save order
            $order                 = new Order();
            $order->uid            = $uid;
            $order->buyer_id       = $buyer_id;
            $order->total_value    = $total;
            $order->subtotal_value = $subtotal;
            $order->taxes_value    = $taxes;
            $order->save();

            // Now let's loop through items in this cart and save them
            foreach ($this->cart as $key => $item) {
                
                // Get gig
                $gig = Gig::where('uid', $item['id'])->active()->first();

                // Check if gig exists
                if ($gig) {
                    
                    // Get item total price
                    $item_total_price                   = $this->itemTotalPrice($item['id']);

                    // Calculate commission first
                    $commisssion                        = $settings->commission_from === 'orders' ? $this->commission($item_total_price) : 0;

                    // Save order item
                    $order_item                         = new OrderItem();
                    $order_item->uid                    = uid();
                    $order_item->order_id               = $order->id;
                    $order_item->gig_id                 = $gig->id;
                    $order_item->owner_id               = $gig->user_id;
                    $order_item->quantity               = (int) $item['quantity'];
                    $order_item->has_upgrades           = is_array($item['upgrades']) && count($item['upgrades']) ? true : false;
                    $order_item->total_value            = $item_total_price;
                    $order_item->profit_value           = $item_total_price - $commisssion;
                    $order_item->commission_value       = $commisssion;
                    $order_item->save();

                    // Check if this item has upgrades
                    if ( is_array($item['upgrades']) && count($item['upgrades']) ) {
                        
                        // Loop through upgrades
                        foreach ($item['upgrades'] as $index => $upg) {
                            
                            // Get upgrade
                            $upgrade = GigUpgrade::where('uid', $upg['id'])->where('gig_id', $gig->id)->first();

                            // Check if upgrade exists
                            if ($upgrade) {
                                
                                // Save item upgrade
                                $order_item_upgrade             = new OrderItemUpgrade();
                                $order_item_upgrade->item_id    = $order_item->id;
                                $order_item_upgrade->title      = $upgrade->title;
                                $order_item_upgrade->price      = $upgrade->price;
                                $order_item_upgrade->extra_days = $upgrade->extra_days;
                                $order_item_upgrade->save();

                            }
                            
                        }

                    }

                    // Only if not offline payment
                    if ($this->payment_method !== 'offline') {
                        
                        // Update seller pending balance
                        $gig->owner()->update([
                            'balance_pending' => $gig->owner->balance_pending + $order_item->profit_value
                        ]);

                        // Increment orders in queue
                        $gig->increment('orders_in_queue');

                        // Order item placed successfully
                        // Let's notify the seller about new order
                        $gig->owner->notify( (new PendingOrder($order_item))->locale(config('app.locale')) );

                        // Send notification
                        notification([
                            'text'    => 't_u_received_new_order_seller',
                            'action'  => url('seller/orders/details', $order_item->uid),
                            'user_id' => $order_item->owner_id
                        ]);

                    }

                }

            }

            // Save invoice
            $invoice                 = new OrderInvoice();
            $invoice->order_id       = $order->id;
            $invoice->payment_method = $payment_method;
            $invoice->payment_id     = $payment_id;
            $invoice->firstname      = clean($this->firstname);
            $invoice->lastname       = clean($this->lastname);
            $invoice->email          = clean($this->email);
            $invoice->company        = $this->company ? clean($this->company) : null;
            $invoice->address        = clean($this->address);
            $invoice->status         = $this->payment_method === 'offline' ? 'pending' : 'paid';
            $invoice->save();

            // If invoice not paid yet
            if ($invoice->status === 'pending') {
                
                // Send notification to admin
                Admin::first()->notify(new PendingOfflinePayment($order, $invoice));

            } else {

                // Update user balance
                if ($this->payment_method === 'credit_card' || $this->payment_method === 'paypal') {
                    auth()->user()->update([
                        'balance_purchases' => $total
                    ]);
                } else if ($this->payment_method === 'balance') {
                    auth()->user()->update([
                        'balance_purchases' => $total,
                        'balance_available' => auth()->user()->balance_available - $total
                    ]);
                }

                // Now let's forget the paypal order id that we used to capture the payment
                session()->forget('paypal_order_id');

            }

            // Now everything succeeded
            // Let's empty the cart
            session()->forget('cart');

            // Now let's notify the buyer that his order has been placed
            auth()->user()->notify( (new OrderPlaced($order, $total))->locale(config('app.locale')) );

            // After that the buyer has to send the seller the required form to start
            if ($this->payment_method === 'offline') {
                
                // Waiting for payment
                return redirect('account/orders')->with('message', __('messages.t_order_placed_waiting_offline_payment'));

            } else {
                
                // Submit required files
                return redirect('account/orders')->with('message', __('messages.t_u_have_send_reqs_asap_to_seller'));

            }
            
        } catch (\Illuminate\Validation\ValidationException $e) {

            // Validation error
            $this->dispatchBrowserEvent('alert',[
                "message" => __('messages.t_toast_form_validation_error'),
                "type"    => "error"
            ]);

            throw $e;

        } catch (\Throwable $th) {
            
            // Validation error
            $this->dispatchBrowserEvent('alert',[
                "message" => $th->getMessage(),
                "type"    => "error"
            ]);

        }
    }


    /**
     * Check if cart has items
     *
     * @return void
     */
    public function cartUpdated()
    {
        // Get current cart
        $cart = session('cart', []);

        // Check if cart has items
        if (count($cart) === 0) {
            return redirect('cart');
        }
    }


    /**
     * Validate cart
     *
     * @return void
     */
    protected function validateCart()
    {
        // Get items in cart
        $items = session('cart', []);

        // Check if cart has items
        if (is_array($items) && count($items)) {
            
            // Loop through items
            foreach ($items as $key => $item) {
                
                // Get gig id
                $id      = $item['id'];

                // Get current user id
                $user_id = auth()->id();

                // Get gig
                $gig     = Gig::where('uid', $id)->active()->where('user_id', '!=', $user_id)->first();

                // Check if gig does not exists
                if (!$gig) {
                    
                    // Remove this item from cart
                    unset($items[$key]);

                }

            }

            // Refresh items
            array_values($items);

        }

        // Forget old session
        session()->forget('cart');

        // Set new cart
        session()->put('cart', $items);
    }
    
}
