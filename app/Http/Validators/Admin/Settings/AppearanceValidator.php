<?php

namespace App\Http\Validators\Admin\Settings;

use Illuminate\Support\Facades\Validator;

class AppearanceValidator
{
    
    /**
     * Validate form
     *
     * @param object $request
     * @return void
     */
    static function validate($request)
    {
        try {

            // Set rules
            $rules    = [
                'home_image'               => 'nullable|image|mimes:jpg,png,jpeg',
                'badge_short_text'         => 'nullable|max:20',
                'badge_long_text'          => 'nullable|max:60',
                'badge_link'               => 'nullable|max:160',
                'primary_link_text'        => 'nullable|max:60',
                'primary_link_target'      => 'nullable|max:160',
                'secondary_link_text'      => 'nullable|max:60',
                'secondary_link_target'    => 'nullable|max:160',
                'show_featured_categories' => 'boolean',
                'show_bestsellers'         => 'boolean',
            ];

            // Set errors messages
            $messages = [
                'home_image.image'                 => __('messages.t_validator_image'),
                'home_image.mimes'                 => __('messages.t_validator_mimes'),
                'badge_short_text.max'             => __('messages.t_validator_max', ['max' => 20]),
                'badge_long_text.max'              => __('messages.t_validator_max', ['max' => 60]),
                'badge_link.max'                   => __('messages.t_validator_max', ['max' => 160]),
                'primary_link_text.max'            => __('messages.t_validator_max', ['max' => 60]),
                'primary_link_target.max'          => __('messages.t_validator_max', ['max' => 160]),
                'secondary_link_text.max'          => __('messages.t_validator_max', ['max' => 60]),
                'secondary_link_target.max'        => __('messages.t_validator_max', ['max' => 160]),
                'show_featured_categories.boolean' => __('messages.t_validator_boolean'),
                'show_bestsellers.boolean'         => __('messages.t_validator_boolean'),
            ];

            // Set data to validate
            $data     = [
                'home_image'               => $request->home_image,
                'badge_short_text'         => $request->badge_short_text,
                'badge_long_text'          => $request->badge_long_text,
                'badge_link'               => $request->badge_link,
                'primary_link_text'        => $request->primary_link_text,
                'primary_link_target'      => $request->primary_link_target,
                'secondary_link_text'      => $request->secondary_link_text,
                'secondary_link_target'    => $request->secondary_link_target,
                'show_featured_categories' => $request->show_featured_categories,
                'show_bestsellers'         => $request->show_bestsellers
            ];

            // Validate data
            Validator::make($data, $rules, $messages)->validate();

            // Reset validation
            $request->resetValidation();

        } catch (\Throwable $th) {
            throw $th;
        }
    }

}
