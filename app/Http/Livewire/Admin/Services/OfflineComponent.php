<?php

namespace App\Http\Livewire\Admin\Services;

use App\Http\Validators\Admin\Services\OfflineValidator;
use App\Models\OfflinePaymentSettings;
use Livewire\Component;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;

class OfflineComponent extends Component
{
    use SEOToolsTrait;
    
    public $is_enabled;
    public $name;
    public $details;

    /**
     * Initialize component
     *
     * @return void
     */
    public function mount()
    {
        // Get offline payment details
        $settings = settings('offline_payment');

        // Fill default settings
        $this->fill([
            'is_enabled' => $settings->is_enabled,
            'name'       => $settings->name,
            'details'    => $settings->details,
        ]);
    }


    /**
     * Render component
     *
     * @return Illuminate\View\View
     */
    public function render()
    {
        // Seo
        $this->seo()->setTitle( setSeoTitle(__('messages.t_offline_payment_settings'), true) );
        $this->seo()->setDescription( settings('seo')->description );

        return view('livewire.admin.services.offline')->extends('livewire.admin.layout.app')->section('content');
    }


    /**
     * Update settings
     *
     * @return void
     */
    public function update()
    {
        try {

            // Validate form
            OfflineValidator::validate($this);

            // Save settings
            OfflinePaymentSettings::where('id', 1)->update([
                'is_enabled' => $this->is_enabled,
                'name'       => $this->name,
                'details'    => $this->details
            ]);

            // Update cache
            settings('offline_payment', true);

            // Success
            $this->dispatchBrowserEvent('alert',[
                "message" => __('messages.t_toast_operation_success'),
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {

            // Validation error
            $this->dispatchBrowserEvent('alert',[
                "message" => __('messages.t_toast_form_validation_error'),
                "type"    => "error"
            ]);

            throw $e;

        } catch (\Throwable $th) {

            // Error
            $this->dispatchBrowserEvent('alert',[
                "message" => __('messages.t_toast_something_went_wrong'),
                "type"    => "error"
            ]);

            throw $th;

        }
    }
    
}
