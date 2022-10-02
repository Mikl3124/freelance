<?php

namespace App\Http\Livewire\Admin\Settings;

use App\Http\Validators\Admin\Settings\AppearanceValidator;
use App\Http\Validators\Admin\Settings\GeneralValidator;
use App\Models\SettingsAppearance;
use App\Models\SettingsGeneral;
use App\Utils\Uploader\ImageUploader;
use Livewire\Component;
use Livewire\WithFileUploads;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;
use Illuminate\Support\Facades\Config;

class AppearanceComponent extends Component
{
    use WithFileUploads, SEOToolsTrait;

    public $home_image;
    public $badge_short_text;
    public $badge_long_text;
    public $badge_link;
    public $primary_link_text;
    public $primary_link_target;
    public $secondary_link_text;
    public $secondary_link_target;
    public $custom_hero_section_html;
    public $show_featured_categories;
    public $show_bestsellers;

    /**
     * Initialize component
     *
     * @return void
     */
    public function mount()
    {
        // Get settings
        $settings = settings('appearance');

        // Fill default settings
        $this->fill([
            'badge_short_text'         => $settings->badge_short_text,
            'badge_long_text'          => $settings->badge_long_text,
            'badge_link'               => $settings->badge_link,
            'primary_link_text'        => $settings->primary_link_text,
            'primary_link_target'      => $settings->primary_link_target,
            'secondary_link_text'      => $settings->secondary_link_text,
            'secondary_link_target'    => $settings->secondary_link_target,
            'custom_hero_section_html' => $settings->custom_hero_section_html,
            'show_featured_categories' => $settings->show_featured_categories,
            'show_bestsellers'         => $settings->show_bestsellers,
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
        $this->seo()->setTitle( setSeoTitle(__('messages.t_appearance_settings'), true) );
        $this->seo()->setDescription( settings('seo')->description );

        return view('livewire.admin.settings.appearance')->extends('livewire.admin.layout.app')->section('content');
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
            AppearanceValidator::validate($this);

            // Get old settings
            $settings = settings('appearance');

            // Check if request has home image
            if ($this->home_image) {
                $home_image_id = ImageUploader::make($this->home_image)
                                                ->folder('site/appearance')
                                                ->deleteById($settings->home_image_id)
                                                ->handle();
            } else {
                $home_image_id = $settings->home_image_id;
            }
            
            // Update settings
            SettingsAppearance::where('id', 1)->update([
                'home_image_id'            => $home_image_id,
                'badge_short_text'         => $this->badge_short_text,
                'badge_long_text'          => $this->badge_long_text,
                'badge_link'               => $this->badge_link,
                'primary_link_text'        => $this->primary_link_text,
                'primary_link_target'      => $this->primary_link_target,
                'secondary_link_text'      => $this->secondary_link_text,
                'secondary_link_target'    => $this->secondary_link_target,
                'custom_hero_section_html' => $this->custom_hero_section_html,
                'show_featured_categories' => $this->show_featured_categories,
                'show_bestsellers'         => $this->show_bestsellers
            ]);

            // Refresh data from cache
            settings('appearance', true);

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
