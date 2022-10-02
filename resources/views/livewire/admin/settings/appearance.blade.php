<div class="w-full bg-white shadow rounded-lg">

    <div class="divide-y divide-gray-200 lg:col-span-9">
        <div class="py-10 px-12">

            {{-- Section header --}}
            <div class="mb-14">
                <h2 class="text-sm leading-6 font-bold text-gray-900">{{ __('messages.t_appearance_settings') }}</h2>
                <p class="mt-1 text-xs text-gray-500">{{ __('messages.t_appreance_settings_subtitle') }}</p>
            </div>
            
            {{-- Section content --}}
            <div class="grid grid-cols-12 md:gap-x-8 gap-y-8 mb-6">

                {{-- Hero section image --}}
                <div class="col-span-12">
                    <x-forms.file-input :label="__('messages.t_home_hero_section_image')" model="home_image" accept="image/jpg,image/jpeg,image/png"  />
                    {{-- Preview image --}}
                    @if (settings('appearance')->homeImage)
                        <div class="mt-3">
                            <img src="{{ src( settings('appearance')->homeImage ) }}" class="h-32 rounded-lg intense cursor-pointer object-cover">
                        </div>
                    @endif
                </div>


                {{-- Hero section badge short text --}}
                <div class="col-span-12 md:col-span-6 lg:col-span-4">
                    <x-forms.text-input
                        :label="__('messages.t_hero_section_badge_short_text')"
                        :placeholder="__('messages.t_enter_text_here')"
                        model="badge_short_text"
                        icon="text" />
                </div>

                {{-- Hero section badge long text --}}
                <div class="col-span-12 md:col-span-6 lg:col-span-4">
                    <x-forms.text-input
                        :label="__('messages.t_hero_section_badge_long_text')"
                        :placeholder="__('messages.t_enter_text_here')"
                        model="badge_long_text"
                        icon="text" />
                </div>

                {{-- Hero section badge link --}}
                <div class="col-span-12 md:col-span-6 lg:col-span-4">
                    <x-forms.text-input
                        :label="__('messages.t_hero_section_badge_link')"
                        :placeholder="__('messages.t_enter_link')"
                        model="badge_link"
                        icon="link-variant" />
                </div>

                {{-- Primary button text --}}
                <div class="col-span-12 md:col-span-6">
                    <x-forms.text-input
                        :label="__('messages.t_primary_button_text')"
                        :placeholder="__('messages.t_enter_text_here')"
                        model="primary_link_text"
                        icon="button-pointer" />
                </div>

                {{-- Primary button link --}}
                <div class="col-span-12 md:col-span-6">
                    <x-forms.text-input
                        :label="__('messages.t_primary_button_link')"
                        :placeholder="__('messages.t_enter_link')"
                        model="primary_link_target"
                        icon="button-pointer" />
                </div>

                {{-- Secondary button text --}}
                <div class="col-span-12 md:col-span-6">
                    <x-forms.text-input
                        :label="__('messages.t_secondary_button_text')"
                        :placeholder="__('messages.t_enter_text_here')"
                        model="secondary_link_text"
                        icon="button-cursor" />
                </div>

                {{-- Secondary button link --}}
                <div class="col-span-12 md:col-span-6">
                    <x-forms.text-input
                        :label="__('messages.t_secondary_button_link')"
                        :placeholder="__('messages.t_enter_link')"
                        model="primary_link_target"
                        icon="button-cursor" />
                </div>

                {{-- Site subtitle --}}
                <div class="col-span-12">
                    <x-forms.textarea
                        :label="__('messages.t_custom_hero_section_code')"
                        :placeholder="__('messages.t_use_ur_own_html_hero_section_code')"
                        model="custom_hero_section_html"
                        icon="xml"
                        :rows="18" />
                </div>

                {{-- Show featured categories --}}
                <div class="col-span-12 md:col-span-6 lg:col-span-6">
                    <div class="w-full" wire:ignore>
                        <x-forms.select2
                            :label="__('messages.t_featured_categories')"
                            :placeholder="__('messages.t_show_featured_categories')"
                            model="show_featured_categories"
                            :options="[ ['text' => __('messages.t_enabled'), 'value' => 1], ['text' => __('messages.t_disabled'), 'value' => 0] ]"
                            :isDefer="true"
                            :isAssociative="false"
                            :componentId="$this->id"
                            value="value"
                            text="text" />
                    </div>
                </div>

                {{-- Show best sellers --}}
                <div class="col-span-12 md:col-span-6 lg:col-span-6">
                    <div class="w-full" wire:ignore>
                        <x-forms.select2
                            :label="__('messages.t_best_sellers')"
                            :placeholder="__('messages.t_show_best_sellers')"
                            model="show_bestsellers"
                            :options="[ ['text' => __('messages.t_enabled'), 'value' => 1], ['text' => __('messages.t_disabled'), 'value' => 0] ]"
                            :isDefer="true"
                            :isAssociative="false"
                            :componentId="$this->id"
                            value="value"
                            text="text" />
                    </div>
                </div>

            </div>

        </div>

        {{-- Actions --}}
        <div class="py-4 px-4 flex justify-end sm:px-12 bg-gray-50 rounded-bl-lg rounded-br-lg">
            <x-forms.button action="update" text="{{ __('messages.t_update') }}" :block="false"  />
        </div>                    

    </div>

</div>    