<header class="flex-none relative text-sm leading-6 font-medium  bg-white shadow-sm" x-data="window.UYwkZuiDzKZiCKp"
    x-init="init()">

    {{-- Announce --}}
    @if (settings('general')->header_announce_text && !Cookie::get('header_announce_closed'))
        <div class="bg-indigo-600" x-show="is_announce">
            <div class="py-3 px-4 md:px-6 lg:px-16">
            <div class="flex items-center justify-between flex-wrap">
                <div class="w-0 flex-1 flex items-center">
                    <span class="flex p-2 rounded-lg bg-indigo-800">
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path> </svg>
                    </span>
                    <p class="ltr:ml-3 rtl:mr-3 font-medium text-white truncate">
                        {{ settings('general')->header_announce_text }}
                    </p>
                </div>

                @if (settings('general')->header_announce_link)
                    <div class="order-3 mt-2 flex-shrink-0 w-full sm:order-2 sm:mt-0 sm:w-auto hidden sm:block">
                        <a href="{{ settings('general')->header_announce_link }}" target="_blank" class="flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-indigo-600 bg-white hover:bg-indigo-50">
                            {{ __('messages.t_learn_more') }}
                        </a>
                    </div>
                @endif

                {{-- Close button --}}
                <div class="order-2 flex-shrink-0 sm:order-3 sm:ltr:ml-3 sm:rtl:mr-3">
                    <button type="button" class="ltr:-mr-1 rtl:-ml-1 flex p-2 rounded-md hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-white ltr:sm:-mr-2 rtl:sm:-ml-2" @click="closeAnnounce()">
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path> </svg>
                    </button>
                  </div>

            </div>
            </div>
        </div>
    @endif

    {{-- Top navbar --}}
    <div class="bg-white border-b border-gray-100">
        <div class="mx-auto h-10 px-4 flex items-center justify-between md:px-6 lg:px-16" x-data="{ open: false }">

            {{-- Help & Languages --}}
            <div class="flex items-center space-x-3 sm:space-x-6 rtl:space-x-reverse">

                {{-- Languages --}}
                @livewire('main.partials.languages')

                <span class="h-4 w-px bg-gray-300" aria-hidden="true"></span>

                {{-- Help --}}
                <a href="{{ url('help/contact') }}" class="text-[13px] font-normal text-gray-600 hover:text-gray-900">{{ __('messages.t_help') }}</a>

            </div>

            {{-- Authentication --}}
            @guest
                <div class="flex items-center space-x-6 rtl:space-x-reverse">

                    {{-- Login --}}
                    <a href="{{ url('auth/login') }}" class="text-[13px] font-normal text-gray-600 hover:text-gray-900">{{ __('messages.t_sign_in') }}</a>

                    <span class="h-4 w-px bg-gray-300" aria-hidden="true"></span>

                    {{-- Register --}}
                    <a href="{{ url('auth/register') }}"
                        class="text-[13px] font-normal text-gray-600 hover:text-gray-900">{{ __('messages.t_join_us') }}</a>

                </div>
            @endguest

            {{-- Welcome back --}}
            @auth
                <div class="flex items-center">

                    {{-- Received orders --}}
                    @if (auth()->user()->account_type === 'seller')
                        <a href="{{ url('seller/orders') }}" class="relative inline-flex ltr:mr-4 rtl:ml-4">
                            <i class="mdi mdi-shopping text-gray-400 hover:text-gray-700 text-[18px]"></i>
                            @if (auth()->user()->sales->where('status', 'pending')->count())
                                <span class="flex absolute h-2 w-2 top-0 right-0 mt-0 -mr-1">
                                    <span
                                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                                </span>
                            @endif
                        </a>
                    @endif

                    {{-- Notifications --}}
                    <div x-data="Components.menu({ open: false })" x-init="init()" @keydown.escape.stop="open = false; focusButton()" @click.away="onClickAway($event)" class="relative inline-flex ltr:mr-4 rtl:ml-4 cursor-pointer">

                        <i class="mdi mdi-bell text-gray-400 hover:text-gray-700 text-[18px]" x-ref="button" @click="onButtonClick()" @keyup.space.prevent="onButtonEnter()" @keydown.enter.prevent="onButtonEnter()" aria-expanded="false" aria-haspopup="true" x-bind:aria-expanded="open.toString()" @keydown.arrow-up.prevent="onArrowUp()" @keydown.arrow-down.prevent="onArrowDown()"></i>
                        @if ($notifications && count($notifications))
                            <span class="flex absolute h-2 w-2 top-0 right-0 mt-0 -mr-1">
                                <span
                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                            </span>
                        @endif
          
                        
                          <div x-show="open" 
                          x-transition:enter="transition ease-out duration-100" 
                          x-transition:enter-start="transform opacity-0 scale-95" 
                          x-transition:enter-end="transform opacity-100 scale-100" 
                          x-transition:leave="transition ease-in duration-75" 
                          x-transition:leave-start="transform opacity-100 scale-100" 
                          x-transition:leave-end="transform opacity-0 scale-95" 
                          class="ltr:origin-top-right rtl:origin-top-left absolute z-30 ltr:right-0 rtl:left-0 mt-6 rounded-md shadow-sm bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" 
                          @keydown.arrow-up.prevent="onArrowUp()" 
                          @keydown.arrow-down.prevent="onArrowDown()" 
                          @keydown.tab="open = false" @keydown.enter.prevent="open = false; focusButton()" 
                          @keyup.space.prevent="open = false; focusButton()" 
                          style="display: none;">
                            <ul class="relative z-0 divide-y divide-gray-200 border-b border-gray-200 lg:min-w-[480px]" role="list">
                              
                                @forelse ($notifications as $n)
                                    <li class="relative ltr:pl-4 rtl:pr-4 ltr:pr-6 rtl:pl-6 py-5 hover:bg-gray-50 sm:py-6 sm:ltr:pl-6 sm:rtl:pr-6 lg:ltr:pl-8 lg:rtl:pr-8 xl:ltr:pl-6 xl:rtl:pr-6 first:rounded-t-md last:rounded-b-md" wire:key="header-notifications-{{ $n->uid }}">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 bg-gray-100 rounded-full h-8 w-8 flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-gray-500"> <path fill-rule="evenodd" d="M10 2a6 6 0 00-6 6c0 1.887-.454 3.665-1.257 5.234a.75.75 0 00.515 1.076 32.91 32.91 0 003.256.508 3.5 3.5 0 006.972 0 32.903 32.903 0 003.256-.508.75.75 0 00.515-1.076A11.448 11.448 0 0116 8a6 6 0 00-6-6zM8.05 14.943a33.54 33.54 0 003.9 0 2 2 0 01-3.9 0z" clip-rule="evenodd"/></svg>
                                            </div>
                                            <div class="ltr:ml-3 rtl:mr-3 w-0 flex-1 pt-0.5">
                                                <a href="{{ $n->action }}" class="text-sm font-medium text-gray-900">
                                                    @if ($n->params)
                                                        {!! __('messages.' . $n->text, $n->params) !!}
                                                    @else
                                                        {!! __('messages.' . $n->text) !!}
                                                    @endif
                                                </a>
                                                <div class="mt-3 flex space-x-7 rtl:space-x-reverse">

                                                    {{-- View --}}
                                                    <a href="{{ $n->action }}" class="bg-transparent rounded-md text-xs font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none">
                                                        {{ __('messages.t_view') }}
                                                    </a>

                                                    {{-- Mark as read --}}
                                                    <button wire:click="readNotification('{{ $n->uid }}')" wire:loading.attr="disabled" wire:target="read('{{ $n->uid }}')" type="button" class="bg-transparent rounded-md text-xs font-medium text-gray-700 hover:text-gray-500 focus:outline-none">
                                                        {{-- Loading indicator --}}
                                                        <div wire:loading wire:target="readNotification('{{ $n->uid }}')">
                                                            <svg role="status" class="inline w-4 h-4 text-gray-700 animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                                                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                                                            </svg>
                                                        </div>

                                                        {{-- Button text --}}
                                                        <div wire:loading.remove wire:target="readNotification('{{ $n->uid }}')">
                                                            {{ __('messages.t_mark_as_read') }}
                                                        </div>
                                                    </button>

                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @empty
                                    <div class="p-9 flex items-center justify-center text-xs font-medium text-gray-500">
                                        {{ __('messages.t_no_notification_right_now') }}
                                    </div>
                                @endforelse

                            </ul>
                          </div>
                        
                    </div>

                    {{-- Messages --}}
                    <a href="{{ url('messages') }}" class="relative inline-flex ltr:mr-4 rtl:ml-4">
                        <i class="mdi mdi-email text-gray-400 hover:text-gray-700 text-[18px]"></i>
                        @if ($new_messages)
                            <span class="flex absolute h-2 w-2 top-0 right-0 mt-0 -mr-1">
                                <span
                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                            </span>
                        @endif
                    </a>

                    {{-- My account --}}
                    <div class="flex items-center relative">
                        <div class="group inline-flex justify-center items-center cursor-pointer"
                            x-on:click="account_menu_open = !account_menu_open" @click.away="account_menu_open = false"
                            @keydown.escape="account_menu_open = false">
                            <img src="{{ src(auth()->user()->avatar) }}" alt="{{ auth()->user()->username }}" class="h-5 w-5 rounded-full ltr:mr-2 rtl:ml-2 object-cover">
                            <span class="text-xs font-bold tracking-wide text-gray-600 hover:text-gray-800 hidden sm:block">{{ auth()->user()->username }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="-mt-px ltr:ml-[4px] rtl:mr-[4px] h-3 w-3 text-gray-400 hidden sm:block" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <div x-cloak x-show="account_menu_open"
                            class="absolute top-full ltr:right-0 rtl:left-0 w-60 mt-3 -mr-0.5 sm:-mr-3.5 bg-white rounded-lg shadow-md ring-1 ring-gray-900 ring-opacity-5 font-normal text-sm text-gray-900 divide-y divide-gray-100 z-40">
                            <p class="py-3 px-3.5 truncate">
                                <span
                                    class="block mb-0.5 text-xs text-gray-500">{{ __('messages.t_logged_in_as_username', ['username' => auth()->user()->username]) }}</span>
                                <span class="font-semibold">@money(auth()->user()->balance_available, settings('currency')->code, true)</span>
                            </p>

                            {{-- Seller --}}
                            <div class="py-1.5 px-3.5">

                                {{-- Buyer --}}
                                @if (auth()->user()->account_type === 'buyer')
                                    {{-- Become a seller --}}
                                    <a href="{{ url('become/seller') }}"
                                        class="group flex items-center py-1.5 group-hover:text-indigo-500">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="flex-none ltr:mr-3 rtl:ml-3 text-gray-400 group-hover:text-indigo-500 h-5 w-5"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                        </svg>
                                        <span
                                            class="font-semibold text-xs text-gray-700 hover:text-indigo-500">{{ __('messages.t_become_a_seller') }}</span>
                                    </a>
                                @endif

                                {{-- Buyer --}}
                                @if (auth()->user()->account_type === 'seller')
                                    {{-- Seller dashboard --}}
                                    <a href="{{ url('seller/home') }}"
                                        class="group flex items-center py-1.5 group-hover:text-indigo-500">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="flex-none ltr:mr-3 rtl:ml-3 text-gray-400 group-hover:text-indigo-500 h-5 w-5"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                                        </svg>
                                        <span
                                            class="font-semibold text-xs text-gray-700 hover:text-indigo-500">{{ __('messages.t_seller_dashboard') }}</span>
                                    </a>
                                @endif

                            </div>

                            {{-- Account --}}
                            <div class="py-1.5 px-3.5">

                                {{-- Profile --}}
                                <a href="{{ url('profile', auth()->user()->username) }}"
                                    class="group flex items-center py-1.5 group-hover:text-indigo-500">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="flex-none ltr:mr-3 rtl:ml-3 text-gray-400 group-hover:text-indigo-500 h-5 w-5"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span
                                        class="font-semibold text-xs text-gray-700 hover:text-indigo-500">{{ __('messages.t_view_profile') }}</span>
                                </a>

                                {{-- Profile --}}
                                <a href="{{ url('account/profile') }}"
                                    class="group flex items-center py-1.5 group-hover:text-indigo-500">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="flex-none ltr:mr-3 rtl:ml-3 text-gray-400 group-hover:text-indigo-500 h-5 w-5"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    <span
                                        class="font-semibold text-xs text-gray-700 hover:text-indigo-500">{{ __('messages.t_edit_profile') }}</span>
                                </a>

                                {{-- Account settings --}}
                                <a href="{{ url('account/settings') }}"
                                    class="group flex items-center py-1.5 group-hover:text-indigo-500">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="flex-none ltr:mr-3 rtl:ml-3 text-gray-400 group-hover:text-indigo-500 h-5 w-5"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span
                                        class="font-semibold text-xs text-gray-700 hover:text-indigo-500">{{ __('messages.t_account_settings') }}</span>
                                </a>

                                {{-- Update password --}}
                                <a href="{{ url('account/password') }}"
                                    class="group flex items-center py-1.5 group-hover:text-indigo-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="flex-none ltr:mr-3 rtl:ml-3 text-gray-400 group-hover:text-indigo-500 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"> <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                    <span class="font-semibold text-xs text-gray-700 hover:text-indigo-500">{{ __('messages.t_update_password') }}</span>
                                </a>

                            </div>

                            {{-- Content --}}
                            <div class="py-1.5 px-3.5">

                                {{-- My orders --}}
                                <a href="{{ url('account/orders') }}"
                                    class="group flex items-center py-1.5 group-hover:text-indigo-500">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="flex-none ltr:mr-3 rtl:ml-3 text-gray-400 group-hover:text-indigo-500 h-5 w-5"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                    <span
                                        class="font-semibold text-xs text-gray-700 hover:text-indigo-500">{{ __('messages.t_my_orders') }}</span>
                                </a>

                                {{-- Messages --}}
                                <a href="{{ url('messages') }}"
                                    class="group flex items-center py-1.5 group-hover:text-indigo-500">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="flex-none ltr:mr-3 rtl:ml-3 text-gray-400 group-hover:text-indigo-500 h-5 w-5"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <span
                                        class="font-semibold text-xs text-gray-700 hover:text-indigo-500">{{ __('messages.t_messages') }}</span>
                                </a>

                                {{-- Reviews --}}
                                <a href="{{ url('account/reviews') }}" class="group flex items-center py-1.5 group-hover:text-indigo-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="flex-none ltr:mr-3 rtl:ml-3 text-gray-400 group-hover:text-indigo-500 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"> <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                                    <span class="font-semibold text-xs text-gray-700 hover:text-indigo-500">{{ __('messages.t_reviews') }}</span>
                                </a>

                                {{-- Refunds --}}
                                <a href="{{ url('account/refunds') }}" class="group flex items-center py-1.5 group-hover:text-indigo-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="flex-none ltr:mr-3 rtl:ml-3 text-gray-400 group-hover:text-indigo-500 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"> <path stroke-linecap="round" stroke-linejoin="round" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z"/></svg>
                                    <span class="font-semibold text-xs text-gray-700 hover:text-indigo-500">{{ __('messages.t_refunds') }}</span>
                                </a>

                            </div>

                            {{-- Security --}}
                            <div class="py-1.5 px-3.5">

                                {{-- Verification center --}}
                                @if (auth()->user()->status !== 'verified')
                                    <a href="{{ url('account/verification') }}"
                                        class="group flex items-center py-1.5 group-hover:text-indigo-500">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="flex-none ltr:mr-3 rtl:ml-3 text-gray-400 group-hover:text-indigo-500 h-5 w-5"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                        <span
                                            class="font-semibold text-xs text-gray-700 hover:text-indigo-500">{{ __('messages.t_verification_center') }}</span>
                                    </a>
                                @endif

                                {{-- Logout --}}
                                <a href="{{ url('auth/logout') }}"
                                    class="group flex items-center py-1.5 group-hover:text-indigo-500">
                                    <svg aria-hidden="true" width="20" height="20" fill="none"
                                        class="flex-none ltr:mr-3 rtl:ml-3 text-gray-400 group-hover:text-indigo-500 h-5 w-5">
                                        <path
                                            d="M10.25 3.75H9A6.25 6.25 0 002.75 10v0A6.25 6.25 0 009 16.25h1.25M10.75 10h6.5M14.75 12.25l2.5-2.25-2.5-2.25"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                    <span
                                        class="font-semibold text-xs text-gray-700 hover:text-indigo-500">{{ __('messages.t_logout') }}</span>
                                </a>

                            </div>

                        </div>
                    </div>

                </div>

            @endauth

        </div>
    </div>

    {{-- Mobile sidebar --}}
    <div x-show="open" class="fixed inset-0 flex z-40 lg:hidden" x-ref="dialog">

        {{-- Backdrop --}}
        <div x-show="open" x-transition:enter="ease-in-out duration-500" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in-out duration-500"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="open = false"
            aria-hidden="true">
        </div>

        {{-- Menu --}}
        <div x-show="open" x-transition:enter="transition ease-in-out duration-300 transform"
            x-transition:enter-start="ltr:-translate-x-full rtl:translate-x-full"
            x-transition:enter-end="ltr:translate-x-0 rtl:translate-x-0"
            x-transition:leave="transition ease-in-out duration-300 transform"
            x-transition:leave-start="ltr:translate-x-0 rtl:translate-x-0"
            x-transition:leave-end="ltr:-translate-x-full rtl:translate-x-full"
            class="relative max-w-xs w-full bg-white shadow-xl pb-12 flex flex-col overflow-y-auto">

            {{-- Authenticated user --}}
            @auth

                {{-- User link --}}
                <div class="py-5 px-4">
                    <x-main.account.sidebar />
                </div>

            @endauth

            {{-- Categories --}}
            <nav class="flex flex-col mt-6 space-y-1 @auth border-t border-gray-100 @endauth">
                              
                @foreach ($categories as $category)
                    <details class="group" wire:key="header-categories-{{ $category->uid }}">

                        {{-- Parent category --}}
                        <summary class="flex items-center px-4 py-2 text-gray-500 rounded-lg cursor-pointer hover:bg-gray-100 hover:text-gray-700 group-open:bg-gray-100">

                            {{-- Category icon --}}
                            <img src="{{ src($category->icon) }}" alt="{{ $category->name }}" class="h-6 w-6">
                
                            {{-- Category name --}}
                            <span class="ltr:ml-3 rtl:mr-3 text-sm font-medium"> {{ $category->name }} </span>
                
                            {{-- Arrow --}}
                            <span class="ltr:ml-auto rtl:mr-auto transition duration-300 shrink-0 group-open:-rotate-180">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor"> <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path> </svg>
                            </span>

                        </summary>
            
                        {{-- Subcategories --}}
                        <nav class="mt-1.5 ltr:ml-8 rtl:mr-8 flex flex-col">

                            {{-- Open parent category --}}
                            <a href="{{ url('categories/' . $category->slug) }}" class="flex items-center px-4 py-2 text-gray-800 rounded-lg hover:bg-gray-100 hover:text-gray-700">
                                <span class="ltr:ml-3 rtl:mr-3 text-sm font-medium"> {{ __('messages.t_browse_parent_category', ['category' => $category->name]) }} </span>
                            </a>

                            {{-- List of subcategories --}}
                            @foreach ($category->subcategories as $sub)
                                <a href="{{ url('categories/' . $category->slug . '/' . $sub->slug) }}" class="flex items-center px-4 py-2 text-gray-500 rounded-lg hover:bg-gray-100 hover:text-gray-700">
                                    <span class="ltr:ml-3 rtl:mr-3 text-xs font-medium"> {{ $sub->name }} </span>
                                </a>
                            @endforeach

                        </nav>

                    </details>
                @endforeach
                
            </nav>
            
        </div>

    </div>

    {{-- Main header --}}
    <nav class="mx-auto px-4 sm:px-6 lg:px-16">
        <div class="">
            <div class="h-20 flex items-center justify-between">

                {{-- Logo --}}
                <div class="flex items-center h-full">

                    {{-- Mobile menu --}}
                    <button type="button" class="bg-white py-2 rtl:pl-4 ltr:pr-4 rounded-md text-gray-400 lg:hidden"
                        @click="open = true">
                        <span class="sr-only">Open menu</span>
                        <svg class="h-6 w-6" x-description="Heroicon name: outline/menu"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    {{-- Logo --}}
                    <div class="flex h-full">
                        <a href="{{ url('/') }}" class="h-full">
                            <img src="{{ src(settings('general')->logo) }}" alt="{{ settings('general')->title }}"
                                class="py-7 h-full">
                        </a>
                    </div>

                </div>

                {{-- Categories && Search --}}
                <div class="w-1/2 relative hidden md:block" x-data="{ open: false }">

                    {{-- Search --}}
                    <div class="flex relative">
                        
                        {{-- Categories button --}}
                        <button data-dropdown-toggle="home-categories-dropdown" data-dropdown-placement="{{ config()->get('direction') === 'ltr' ? 'bottom-start' : 'left-bottom' }}" class="justify-center bg-gray-50 px-4 py-3 inline-flex items-center ltr:rounded-l-md rtl:rounded-r-md border ltr:border-r-0 rtl:border-l-0 border-gray-200 focus:outline-none h-12">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor"> <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/></svg>
                            <span class="text-[13px] font-medium text-gray-600 ltr:ml-2 rtl:mr-2">{{ __('messages.t_categories') }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 ltr:ml-1 rtl:mr-1" viewBox="0 0 20 20" fill="currentColor"> <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                        </button>

                        {{-- Search input --}}
                        <div class="relative h-12 w-full">

                            {{-- Search icon --}}
                            <div class="flex absolute inset-y-0 ltr:right-0 rtl:left-0 items-center ltr:pr-3 rtl:pl-3 pointer-events-none" wire:loading.remove wire:target="q">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>

                            {{-- Loading indicator --}}
                            <div class="absolute inset-y-0 ltr:right-0 rtl:left-0 items-center ltr:pr-3 rtl:pl-3 pointer-events-none" wire:loading wire:target="q" wire:loading.class="!flex">
                                <svg class="w-5 h-5 text-gray-200 animate-spin fill-indigo-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                                </svg>
                            </div>

                            {{-- Input --}}
                            <input wire:model.debounce.500ms="q" wire:keydown.enter="enter" x-ref="search" @click="open = true" type="text" class="rounded-none ltr:rounded-r-lg rtl:rounded-l-lg border border-gray-200 text-gray-900 focus:outline-none focus:border-gray-200 block flex-1 min-w-full w-full text-sm  pr-8 focus:ring-0 h-full placeholder-gray-400" placeholder="{{ __('messages.t_what_service_are_u_looking_for_today') }}">

                        </div>

                        {{-- Results --}}
                        @if (count($gigs) || count($sellers) || count($tags) || $q)
                            <div class="absolute top-16 w-full bg-white rounded-lg border border-gray-100 shadow-md max-w-full" @keydown.window.escape="opne = false" x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click.away="open = false">
                                {{-- Results --}}
                                @if (count($gigs) || count($sellers) || count($tags))
                                    <ul class="max-h-80 scroll-py-10 scroll-pb-2 space-y-4 overflow-y-auto p-4 pb-2" id="options" role="listbox">

                                        {{-- Gigs --}}
                                        @if ($gigs && count($gigs))
                                            <li>
                                                <h2 class="text-xs font-semibold text-gray-900">{{ __('messages.t_gigs') }}</h2>
                                                <ul class="-mx-4 mt-2 text-sm text-gray-700">

                                                    {{-- List of gigs --}}
                                                    @foreach ($gigs as $gig)
                                                        <li class="group flex cursor-default select-none items-center px-4 py-2">
                                                            <a href="{{ url('service', $gig->slug) }}" class="flex items-center">
                                                                <svg class="h-6 w-6 flex-none text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/> </svg>
                                                                <span class="ltr:ml-3 rtl:mr-3 flex-auto ext-ellipsis overflow-hidden">{{ $gig->title }}</span>
                                                            </a>
                                                        </li>
                                                    @endforeach

                                                </ul>
                                            </li>
                                        @endif
                                    
                                        {{-- Sellers --}}
                                        @if ($sellers && count($sellers))
                                            <li>
                                                <h2 class="text-xs font-semibold text-gray-900">{{ __('messages.t_sellers') }}</h2>

                                                {{-- List of sellers --}}
                                                <ul class="-mx-4 mt-2 text-sm text-gray-700">
                                                    @foreach ($sellers as $seller)
                                                        <li class="group flex cursor-default select-none items-center px-4 py-2">
                                                            <a href="{{ url('profile', $seller->username) }}" class="flex items-center">
                                                                <img src="{{ src($seller->avatar) }}" alt="{{ $seller->username }}" class="h-6 w-6 flex-none rounded-full object-cover">
                                                                <span class="ltr:ml-3 rtl:mr-3 flex-auto truncate">{{ $seller->username }}</span>
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @endif

                                        {{-- Tags --}}
                                        @if ($tags && count($tags))
                                            <li>
                                                <h2 class="text-xs font-semibold text-gray-900">{{ __('messages.t_tags') }}</h2>
                                                <ul class="-mx-4 mt-2 text-sm text-gray-700">

                                                    {{-- List of tags --}}
                                                    @foreach ($tags as $tag)
                                                        <li class="group flex cursor-default select-none items-center px-4 py-2">
                                                            <a href="{{ url('gigs', $tag->slug) }}" class="flex items-center">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-none text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"> <path stroke-linecap="round" stroke-linejoin="round" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/></svg>
                                                                <span class="ml-3 flex-auto truncate">{{ $tag->name }}</span>
                                                            </a>
                                                        </li>
                                                    @endforeach

                                                </ul>
                                            </li>
                                        @endif

                                    </ul>
                                @endif
                        
                                {{-- No results --}}
                                @if (count($gigs) === 0 && count($sellers) === 0 && count($tags) === 0 && $q)
                                    <div class="py-14 px-6 text-center text-sm sm:px-14">
                                        <svg class="mx-auto h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/> </svg>
                                        <p class="mt-4 font-semibold text-gray-900">{{ __('messages.no_results_found') }}</p>
                                        <p class="mt-2 text-gray-500">{{ __('messages.t_we_couldnt_find_anthing_search_term') }}</p>
                                    </div>
                                @endif
                        
                                {{-- Footer --}}
                                <div class="flex flex-wrap items-center bg-gray-50 py-2.5 px-4 text-xs text-gray-700">
                                    {!! __('messages.t_press_enter_to_search_deeply') !!}
                                </div>
                            </div>
                        @endif

                        {{-- Categories menu --}}
                        <div id="home-categories-dropdown" class="hidden z-10 w-72 bg-white rounded-md shadow-md shadow-gray-200 rtl:!right-0 rtl:!top-[50px]">
                            <ul class="text-sm text-gray-700">
                                @foreach ($categories as $category)
                                    <li class="first:rounded-t-md last:rounded-b-md">

                                        {{-- Category item --}}
                                        <button data-dropdown-toggle="category-subcategories-drop-down-{{ $category->uid }}" data-dropdown-placement="{{ config()->get('direction') === 'rtl' ? 'left-start' : 'right-start' }}" type="button" class="flex justify-between items-center py-2 px-4 w-full hover:bg-gray-50 group focus:outline-none">

                                            {{-- Category name --}}
                                            <div class="flex items-center">
                                                <div class="w-8 h-8 border border-gray-100 bg-gray-50 group-hover:bg-gray-100 rounded-full flex items-center justify-center">
                                                    <img src="{{ src($category->icon) }}" alt="{{ $category->name }}" class="h-4 w-4">
                                                </div>
                                                <span class="ltr:ml-3 rtl:mr-3 text-[13px] font-normal text-gray-500 group-hover:text-gray-700"> {{ $category->name }} </span>
                                            </div>

                                            {{-- Arrow right --}}
                                            <svg aria-hidden="true" class="w-4 h-4 text-gray-400 hidden ltr:inline" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path> </svg>

                                            {{-- Arrow Left --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 hidden rtl:inline" viewBox="0 0 20 20" fill="currentColor"> <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>

                                        </button>

                                        {{-- Subcategories --}}
                                        <div id="category-subcategories-drop-down-{{ $category->uid }}" class="hidden z-10 w-64 bg-white rounded-md shadow-md shadow-gray-200" data-popper-reference-hidden="" data-popper-escaped="" data-popper-placement="right-start" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate3d(10.4px, 456.8px, 0px);">
                                            <ul class="text-sm text-gray-700">

                                                {{-- Browser parent category --}}
                                                <li>
                                                    <a href="{{ url('categories/' . $category->slug) }}" class="flex items-center px-4 py-3 text-gray-800 hover:text-black">
                                                        <span class="text-sm font-medium"> {{ __('messages.t_browse_parent_category', ['category' => $category->name]) }} </span>
                                                    </a>
                                                </li>

                                                {{-- List of subcategories --}}
                                                @foreach ($category->subcategories as $subcategory)
                                                    <li>
                                                        <a href="{{ url('categories/' . $category->slug . '/' . $subcategory->slug) }}" class="block py-3 px-4 hover:bg-gray-100 font-normal text-gray-500 hover:text-gray-700 text-[13px]">{{ $subcategory->name }}</a>
                                                    </li>
                                                @endforeach
                                                
                                            </ul>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                    </div>

                    
                    

                </div>

                {{-- Nav icons --}}
                <div class="flex items-center">
                    <div class="flex items-center lg:ltr:ml-8 lg:rtl:mr-8">
                        <div class="flex space-x-8 rtl:space-x-reverse">

                            {{-- Search --}}
                            <div class="flex md:hidden">
                                @livewire('main.partials.search')
                            </div>

                        </div>
                        <span class="mx-4 h-6 w-px bg-gray-200 lg:mx-6 block md:hidden" aria-hidden="true"></span>
                        <div class="flow-root">
                            @livewire('main.partials.cart')
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </nav>

</header>

@push('scripts')
    {{-- AlpineJs --}}
    <script>
        function UYwkZuiDzKZiCKp() {
            return {

                dialogs: {
                    languages: false
                },
                drawers: {
                    sidebar: false,
                    cart: false,
                },
                open             : false,
                account_menu_open: false,
                cart_open        : false,
                is_announce      : true,

                init() {

                },

                // Close announce
                closeAnnounce() {
                    this.is_announce = false
                    @this.closeAnnounce();
                }

            }
        }
        window.UYwkZuiDzKZiCKp = UYwkZuiDzKZiCKp();
    </script>
@endpush
