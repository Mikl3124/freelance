<?php

namespace App\Http\Validators\Admin\Services;

use Illuminate\Support\Facades\Validator;

class OfflineValidator
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
                'is_enabled' => 'boolean',
                'name'       => 'nullable|max:60',
                'details'    => 'nullable|max:1500'
            ];

            // Set errors messages
            $messages = [
                'is_enabled.required' => __('messages.t_validator_boolean'),
                'name.max'            => __('messages.t_validator_max', ['max' => 60]),
                'details.max'         => __('messages.t_validator_max', ['max' => 1500])
            ];

            // Set data to validate
            $data     = [
                'is_enabled' => $request->is_enabled,
                'name'       => $request->name,
                'details'    => $request->details
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
