<main class="w-full">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="divide-y divide-gray-200 lg:grid lg:grid-cols-12 lg:divide-y-0 lg:divide-x rtl:divide-x-reverse">

                {{-- Sidebar --}}
                <aside class="lg:col-span-3 py-6" wire:ignore>
                    <x-main.account.sidebar />
                </aside>

                {{-- Section content --}}
                <div class="divide-y divide-gray-200 lg:col-span-9">

                    {{-- Form --}}
                    <div class="py-6 px-4 sm:p-6 lg:pb-8 h-[calc(100%-80px)]">

                        {{-- Section header --}}
                        <div class="mb-14">
                            <h2 class="text-base leading-6 font-bold text-gray-900">{{ __('messages.t_billing_information') }}</h2>
                            <p class="mt-1 text-sm text-gray-500">{{ __('messages.t_billing_information_subtitle') }}</p>
                        </div>
                        
                        {{-- Section content --}}
                        <div class="grid grid-cols-12 md:gap-x-8 gap-y-8 mb-6">

                            {{-- Firstname --}}
                            <div class="col-span-12 md:col-span-6">
                                <x-forms.text-input 
                                    label="{{ __('messages.t_firstname') }}" 
                                    placeholder="{{ __('messages.t_enter_firstname') }}" 
                                    model="firstname"
                                    icon="account" />
                            </div>

                            {{-- Lastname --}}
                            <div class="col-span-12 md:col-span-6">
                                <x-forms.text-input 
                                    label="{{ __('messages.t_lastname') }}" 
                                    placeholder="{{ __('messages.t_enter_lastname') }}" 
                                    model="lastname"
                                    icon="account" />
                            </div>

                            {{-- Company --}}
                            <div class="col-span-12">
                                <x-forms.text-input 
                                    label="{{ __('messages.t_company') }}" 
                                    placeholder="{{ __('messages.t_enter_company_optional') }}" 
                                    model="company"
                                    icon="domain" />
                            </div>

                            {{-- City --}}
                            <div class="col-span-12 md:col-span-6">
                                <x-forms.text-input 
                                    label="{{ __('messages.t_city') }}" 
                                    placeholder="{{ __('messages.t_enter_city') }}" 
                                    model="city"
                                    icon="city" />
                            </div>

                            {{-- Zip --}}
                            <div class="col-span-12 md:col-span-6">
                                <x-forms.text-input 
                                    label="{{ __('messages.t_zip') }}" 
                                    placeholder="{{ __('messages.t_enter_zip') }}" 
                                    model="zip"
                                    icon="mailbox" />
                            </div>

                            {{-- Country --}}
                            <div class="col-span-12">
                                <div class="w-full" wire:ignore>
                                    <x-forms.select2
                                        :label="__('messages.t_country')"
                                        :placeholder="__('messages.t_choose_country')"
                                        model="country"
                                        :options="$countries"
                                        :isDefer="true"
                                        :isAssociative="false"
                                        :componentId="$this->id"
                                        value="id"
                                        text="name" />
                                </div>
                            </div>

                            {{-- Address --}}
                            <div class="col-span-12">
                                <x-forms.textarea 
                                    label="{{ __('messages.t_address') }}" 
                                    placeholder="{{ __('messages.t_enter_address') }}" 
                                    model="address"
                                    rows="8"
                                    icon="map-marker" />
                            </div>

                            {{-- VAT number --}}
                            <div class="col-span-12">
                                <x-forms.text-input 
                                    label="{{ __('messages.t_vat_number') }}" 
                                    placeholder="{{ __('messages.t_enter_vat_number_optional') }}" 
                                    model="vat_number"
                                    icon="percent" />
                            </div>

                        </div>

                    </div>

                    {{-- Actions --}}
                    <div class="py-4 px-4 flex justify-end sm:px-6 bg-gray-50 h-20">
                        <x-forms.button action="update" text="{{ __('messages.t_update') }}"  />
                    </div>                    

                </div>

            </div>
        </div>
    </div>
</main>