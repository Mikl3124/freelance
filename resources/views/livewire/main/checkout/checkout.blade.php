<div class="relative w-full mx-auto" x-data="window.LjqGJmYrwJSjIHT">
    <div class="grid grid-cols-12 md:gap-x-10 gap-y-10">

        {{-- Invoice details --}}
        <div class="col-span-12 lg:col-span-7">
            <div class="mb-6 bg-white shadow-sm rounded-lg border border-gray-200">

                {{-- Section title --}}
                <div class="bg-gray-50 px-8 py-4 rounded-t-lg">
                    <div class="-ml-4 -mt-4 flex justify-between items-center flex-wrap sm:flex-nowrap">
                        <div class="ltr:ml-4 rtl:mr-4 mt-4">
                            <h3 class="text-sm leading-6 font-black tracking-wide text-gray-800">{{ __('messages.t_invoice') }}</h3>
                            <p class="text-sm font-normal text-gray-400">{{ __('messages.t_enter_ur_billing_infor_below') }}</p>
                        </div>
                        <div class="ltr:ml-4 rtl:mr-4 mt-4 flex-shrink-0">
                            <a href="{{ url('cart') }}" target="_blank" class="inline-flex items-center py-2 px-3 border border-transparent rounded-full bg-transparent hover:bg-transparent focus:outline-none focus:ring-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-500 hover:text-indigo-600 ltr:mr-2 rtl:ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"> <path stroke-linecap="round" stroke-linejoin="round" d="M11 17l-5-5m0 0l5-5m-5 5h12"/></svg>
                                <span class="text-xs font-medium text-indigo-500 hover:text-indigo-600"> 
                                    {{ __('messages.t_back_to_shopping_cart') }}
                                </span>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Section content --}}
                <div class="grid grid-cols-12 md:gap-x-6 gap-y-6 px-8 pt-6 pb-10">

                    {{-- Firstname --}}
                    <div class="col-span-12 md:col-span-6">
                        <x-forms.text-input 
                            :label="__('messages.t_firstname')"
                            :placeholder="__('messages.t_enter_firstname')"
                            model="firstname"
                            icon="account" />
                    </div>

                    {{-- Lastname --}}
                    <div class="col-span-12 md:col-span-6">
                        <x-forms.text-input 
                            :label="__('messages.t_lastname')"
                            :placeholder="__('messages.t_enter_lastname')"
                            model="lastname"
                            icon="account" />
                    </div>

                    {{-- Email address --}}
                    <div class="col-span-12">
                        <x-forms.text-input 
                            :label="__('messages.t_email_address')"
                            :placeholder="__('messages.t_enter_email_address')"
                            model="email"
                            type="email"
                            icon="at" />
                    </div>

                    {{-- Company --}}
                    <div class="col-span-12">
                        <x-forms.text-input 
                            :label="__('messages.t_company')"
                            :placeholder="__('messages.t_enter_company_optional')"
                            model="company"
                            icon="domain" />
                    </div>

                    {{-- Address --}}
                    <div class="col-span-12">
                        <x-forms.text-input 
                            :label="__('messages.t_address')"
                            :placeholder="__('messages.t_enter_address')"
                            model="address"
                            icon="map-marker" />
                    </div>

                </div>

            </div>
        </div>

        {{-- Payment --}}
        <div class="col-span-12 lg:col-span-5">

            {{-- Form --}}
            <div class="mb-6 bg-white shadow-sm rounded-lg border border-gray-200">

                {{-- Section title --}}
                <div class="bg-gray-50 px-8 py-4 rounded-t-lg">
                    <div class="ltr:-ml-4 rtl:-mr-4 -mt-4 flex justify-between items-center flex-wrap sm:flex-nowrap">
                        <div class="ltr:ml-4 rtl:mr-4 mt-4">
                            <h3 class="text-sm leading-6 font-black tracking-wide text-gray-800">{{ __('messages.t_payment') }}</h3>
                            <p class="text-sm font-normal text-gray-400">{{ __('messages.t_choose_ur_prefered_payment_method') }}</p>
                        </div>
                        <div class="ltr:ml-4 rtl:mr-4 mt-4 flex-shrink-0">
                            <button wire:key="add-upgrade-btn" id="modal-add-service-upgrade-button" class="inline-flex items-center py-2 px-3 border border-transparent rounded-full bg-transparent hover:bg-transparent focus:outline-none focus:ring-0">
                                <span class="text-xs font-medium text-gray-500 hover:text-gray-600"> 
                                    @money($this->total() + $this->taxes(), settings('currency')->code, true)
                                </span>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Section content --}}
                <div class="grid grid-cols-12 md:gap-x-6 gap-y-6 px-8 py-6">

                    {{-- Choose payment method --}}
                    <div class="col-span-12 mb-6">
                        <fieldset class="mt-4">
                            <legend class="sr-only">Payment type</legend>
                            <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-6 rtl:space-x-reverse">

                                {{-- Credit cart --}}
                                <label class="flex items-center cursor-pointer" for="checkout-payment-method-credit-card">
                                    <input id="checkout-payment-method-credit-card" name="payment_method" type="radio" wire:model.defer="payment_method" x-model="payment_method" value="credit_card" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                    <label for="checkout-payment-method-credit-card" class="ltr:ml-3 rtl:mr-4 block text-sm font-medium text-gray-700 cursor-pointer">
                                        {{ __('messages.t_credit_card') }}
                                    </label>
                                </label>

                                {{-- Paypal --}}
                                @if (settings('gateways')->is_paypal)
                                    <label class="flex items-center cursor-pointer" for="checkout-payment-method-paypal">
                                        <input id="checkout-payment-method-paypal" name="payment_method" type="radio" wire:model.defer="payment_method" x-model="payment_method" value="paypal" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                        <label for="checkout-payment-method-paypal" class="ltr:ml-3 rtl:mr-4 block text-sm font-medium text-gray-700 cursor-pointer">
                                            {{ __('messages.t_paypal') }}
                                        </label>
                                    </label>
                                @endif

                                {{-- Available balance --}}
                                @if (auth()->user()->balance_available >= $this->total() + $this->taxes())
                                    <label class="flex items-center cursor-pointer" for="checkout-payment-method-balance">
                                        <input id="checkout-payment-method-balance" name="payment_method" type="radio" wire:model.defer="payment_method" x-model="payment_method" value="balance" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                        <label for="checkout-payment-method-balance" class="ltr:ml-3 rtl:mr-4 block text-sm font-medium text-gray-700 cursor-pointer">
                                            {{ __('messages.t_balance') }}
                                        </label>
                                    </label>
                                @endif

                                {{-- Offline payment --}}
                                @if (settings('offline_payment')->is_enabled)
                                    <label class="flex items-center cursor-pointer" for="checkout-payment-method-offline">
                                        <input id="checkout-payment-method-offline" name="payment_method" type="radio" wire:model.defer="payment_method" x-model="payment_method" value="offline" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                        <label for="checkout-payment-method-offline" class="ltr:ml-3 rtl:mr-4 block text-sm font-medium text-gray-700 cursor-pointer">
                                            {{ settings('offline_payment')->name }}
                                        </label>
                                    </label>
                                @endif
                                
                            </div>
                        </fieldset>
                    </div>

                    {{-- Credit card form --}}
                    <div class="col-span-12" x-show="payment_method === 'credit_card'">
                        <div class="grid grid-cols-12 gap-y-3 md:gap-x-6" id="cc-form">
    
                            {{-- Name on card --}}
                            <div class="col-span-12">
                                <x-forms.text-input 
                                    :label="__('messages.t_name_on_card')"
                                    :placeholder="__('messages.t_enter_name_credit_card')"
                                    model="card_name"
                                    icon="account"
                                    data-cc="name" />
                            </div>
    
                            {{-- Card number --}}
                            <div class="col-span-12">
                                <x-forms.text-input 
                                    :label="__('messages.t_card_number')"
                                    :placeholder="__('messages.t_card_number_placeholder')"
                                    model="card_number"
                                    icon="numeric"
                                    x-mask="9999 9999 9999 9999"
                                    data-cc="number" />
                            </div>
    
                            {{-- Card expiry date --}}
                            <div class="col-span-12 md:col-span-8">
                                <x-forms.text-input 
                                    :label="__('messages.t_expiration_date')"
                                    :placeholder="__('messages.t_mm_yyyy')"
                                    model="card_expiry"
                                    icon="calendar-clock"
                                    x-mask="99 / 9999"
                                    data-cc="expiry" />
                            </div>
    
                            {{-- CC cvc --}}
                            <div class="col-span-12 md:col-span-4">
                                <x-forms.text-input 
                                    :label="__('messages.t_cc_cvc')"
                                    :placeholder="__('messages.t_cc_cvc_placeholder')"
                                    model="card_cvc"
                                    icon="key"
                                    x-mask="9999"
                                    data-cc="cvc" />
                            </div>
    
                        </div>
                    </div>

                    {{-- Credit card preview --}}
                    <div class="col-span-12" x-show="payment_method === 'credit_card'" wire:ignore>
                        <div class="flex justify-center">
                            <div class='card-wrapper' dir="ltr"></div>
                        </div>
                    </div>

                    {{-- Paypal --}}
                    @if (settings('gateways')->is_paypal)
                        <div class="col-span-12" x-show="payment_method === 'paypal'" wire:ignore>
                            <div id="paypal-button-container"></div>
                        </div>
                    @endif

                    {{-- Available balance --}}
                    @if (auth()->user()->balance_available >= $this->total() + $this->taxes())
                        <div class="col-span-12" x-show="payment_method === 'balance'">
                            <div class="flex items-center justify-center text-4xl text-gray-900 font-black font-[Lato]">
                                @money(auth()->user()->balance_available, settings('currency')->code, true)
                            </div>
                            <div class="text-center text-xs mt-2 tracking-wide text-gray-500">
                                {{ __('messages.t_available_balance') }}
                            </div>
                        </div>
                    @endif

                    {{-- Offline payment --}}
                    @if (settings('offline_payment')->is_enabled)
                        <div class="col-span-12" x-show="payment_method === 'offline'">
                            <div class="text-sm font-normal mt-2 tracking-wide text-gray-500">
                                {!! nl2br(settings('offline_payment')->details) !!}
                            </div>
                        </div>
                    @endif

                </div>

            </div>

            {{-- Actions --}}
            <div class="mb-2">
                <button 
                    wire:click="place"
                    wire:loading.class="bg-gray-200 hover:bg-gray-300 text-gray cursor-not-allowed"
                    wire:loading.class.remove="bg-indigo-600 hover:bg-indigo-700 text-white cursor-pointer"
                    wire:loading.attr="disabled"
                    class="w-full text-sm font-medium flex justify-center bg-indigo-600 hover:bg-indigo-700 text-white py-5 px-8 rounded tracking-wide focus:outline-none focus:shadow-outline cursor-pointer"
                    >

                    {{-- Loading indicator --}}
                    <div wire:loading wire:target="place">
                        <svg role="status" class="inline w-4 h-4 text-gray-700 animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                        </svg>
                    </div>

                    {{-- Button text --}}
                    <div wire:loading.remove wire:target="place">
                        {{ __('messages.t_place_order')    }}
                    </div>
                </button>
            </div>

            {{-- Secure payment --}}
            <div class="mt-4 flex text-sm justify-center">
                <div class="group inline-flex items-center text-gray-500 hover:text-gray-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 group-hover:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"> <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    <span class="ltr:ml-2 rtl:mr-2"> {{ __('messages.t_ur_transaction_is_secure') }} </span>
                </div>
            </div>

        </div>

    </div>
</div>

@push('scripts')

    {{-- Card Preview Plugin --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/card/2.5.4/card.min.js"></script>
    <script>
        var card = new Card({
            form: '#cc-form',
            
            container: '.card-wrapper',

            formSelectors: {
                nameInput  : 'input[data-cc="name"]',
                numberInput: 'input[data-cc="number"]',
                expiryInput: 'input[data-cc="expiry"]',
                cvcInput   : 'input[data-cc="cvc"]'
            },
        });
    </script>

    {{-- Check if paypal enabled --}}
    @if (settings('gateways')->is_paypal)

        {{-- Get paypal client id --}}
        @php
            $client_id = config('paypal.mode') === 'sandbox' ? config('paypal.sandbox.client_id') : config('paypal.live.client_id')
        @endphp

        {{-- PayPal SDK --}}
        <script src="https://www.paypal.com/sdk/js?client-id={{ $client_id }}&currency={{ settings('currency')->code }}"></script>

    @endif

    {{-- AlpineJs --}}
    <script>
        function LjqGJmYrwJSjIHT() {
            return {

                payment_method     : 'credit_card',

                init() {

                    {{-- This code will run only when paypal is enabled --}}
                    @if (settings('gateways')->is_paypal)

                        // Render the PayPal button into #paypal-button-container
                        paypal.Buttons({

                            // Set up the transaction
                            createOrder: function(data, actions) {
                                return actions.order.create({
                                    purchase_units: [{
                                        amount: {
                                            value: '{{ $this->total() + $this->taxes() }}'
                                        }
                                    }]
                                });
                            },

                            // Finalize the transaction
                            onApprove: function(data, actions) {

                                // Set order id
                                @this.set('paypal_order_id', data.orderID);
                                
                                // Show success message
                                window.toast("{{ __('messages.t_paypal_payment_success_click_place') }}", 'success');
                            }

                        }).render('#paypal-button-container');

                    @endif

                    window.addEventListener('cart-updated', () => {
                        Livewire.emit('cart-updated')
                    });

                }

            }
        }
        window.LjqGJmYrwJSjIHT = LjqGJmYrwJSjIHT();
    </script>

@endpush