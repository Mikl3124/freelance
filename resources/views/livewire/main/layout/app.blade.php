<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ config()->get('direction') }}">
    
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- Generate seo tags --}}
        {!! SEO::generate() !!}
        {!! JsonLd::generate() !!}

        {{-- Favicon --}}
        <link rel="icon" type="image/png" href="{{ src( settings('general')->favicon ) }}"/>

        {{-- Fonts --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        
        <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@6.9.96/css/materialdesignicons.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700;900&display=swap" rel="stylesheet">

        {{-- This font only for RTL --}}
        @if (config()->get('direction') === 'rtl')
            <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@100;200;300;400;500;600;700;800&display=swap" rel="stylesheet">
        @endif

        {{-- Livewire styles --}}
        @livewireStyles

        {{-- Styles --}}
        <link href="{{ asset('public/css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('public/css/style.css') }}" rel="stylesheet">

        {{-- Toastr Plugin --}}
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

        {{-- Select2 --}}
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" type="text/css">

        {{-- Rating Plugin --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">

        {{-- Custom css --}}
        @stack('styles')

        {{-- RTL variable --}}
        <script>
            __var_rtl = @js(config()->get('direction') === 'ltr' ? false : true)
        </script>

        {{-- Ads header code --}}
        @if (advertisements('header_code'))
            {!! advertisements('header_code') !!}
        @endif

    </head>

    <body class="antialiased bg-gray-50 text-gray-600 min-h-full flex flex-col application application-ltr overflow-x-hidden overflow-y-hidden {{ app()->getLocale() === 'ar' ? 'application-ar' : '' }}">

        {{-- Loading page --}}
        <div class="bg-gray-100 fixed h-full w-full z-[999] flex items-center justify-center" id="screen-loader">
            <div class="text-center">
                <div role="status">
                    <svg class="inline w-16 h-16 text-gray-200 animate-spin fill-gray-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                    </svg>
                    <span class="sr-only">Loading...</span>
                </div>
            </div>         
        </div>

        {{-- Add to cart dialog --}}
        <div 
            x-data="window.WgRqLnTxHBZBRzq" 
            x-show="open" 
            aria-live="assertive" 
            class="hidden fixed inset-0 items-end px-4 py-6 pointer-events-none sm:p-6 sm:items-start z-[999]" id="gig-added-to-cart"
            x-transition:enter="transform ease-out duration-300 transition"
            x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
            x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0">
            <div class="w-full flex flex-col items-center space-y-4 sm:items-end">
                <div class="max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5">
                    <div class="p-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 pt-0.5">
                                <button type="button" class="text-gray-600 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-0 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center mr-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"> <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"/></svg>
                                </button>
                            </div>
                            <div class="ltr:ml-3 rtl:mr-3 w-0 flex-1">
                                <p class="text-sm font-medium text-gray-900">{{ __('messages.t_product_added_to_cart') }}</p>
                                <p class="mt-1 text-xs text-gray-500" x-text="title"></p>
                                <div class="mt-4 flex">

                                    {{-- Go to cart --}}
                                    <a href="{{ url('cart') }}" class="inline-flex items-center px-3 py-2 border border-transparent shadow-sm text-sm leading-4 font-medium rounded text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">{{ __('messages.t_view_cart') }}</a>

                                    {{-- Close this message --}}
                                    <button x-on:click="close" type="button" class="ltr:ml-3 rtl:mr-3 inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">{{ __('messages.t_continue_shopping') }}</button>

                                </div>
                            </div>
                            <div class="ltr:ml-4 rtl:mr-4 flex-shrink-0 flex">
                                <button x-on:click="close()" class="bg-white rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <span class="sr-only">Close</span>
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Header --}}
        @livewire('main.includes.header')

        {{-- Content --}}
        <main class="flex-grow"> 

            {{-- Section hero --}}
            @if (request()->is('/'))
                @guest
                    @if (settings('appearance')->custom_hero_section_html)
                       {!! settings('appearance')->custom_hero_section_html !!}
                    @else
                        <div class="relative overflow-hidden h-[600px]">

                            {{-- Image --}}
                            @if (settings('appearance')->homeImage)
                                <div class="absolute inset-0">
                                    <img src="{{ src(settings('appearance')->homeImage) }}" alt="{{ config('app.name') }}" class="w-full h-full object-cover">
                                </div>
                            @endif

                            <div aria-hidden="true" class="relative w-full h-[600px] lg:hidden"></div>
                            <div class="absolute inset-x-0 bottom-0 top-0 bg-gray-200 bg-opacity-80 p-6 backdrop-filter backdrop-blur sm:flex sm:items-center sm:justify-between lg:inset-y-0 lg:inset-x-auto lg:w-full lg:flex-col lg:items-center">
                                <section class="w-full flex items-center h-full max-w-6xl">
                                    <div class="pb-8 mx-auto text-center lg:pb-6">

                                        {{-- Badge --}}
                                        @if (settings('appearance')->badge_short_text && settings('appearance')->badge_long_text && settings('appearance')->badge_link)
                                            <a href="{{ settings('appearance')->badge_link }}" target="_blank" class="inline-flex justify-between items-center py-1 px-1 ltr:pr-4 rtl:pl-4 mb-7 text-sm text-gray-700 bg-gray-100 rounded-full">

                                                <span class="text-xs bg-indigo-600 rounded-full text-white px-4 py-1.5 mr-3">
                                                    {{ settings('appearance')->badge_short_text }} 
                                                </span> 
                                                <span class="text-sm font-medium">
                                                    {{ settings('appearance')->badge_long_text }}    
                                                </span> 

                                                {{-- LTR --}}
                                                <svg class="ml-2 w-5 h-5 hidden ltr:inline" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>

                                                {{-- RTL --}}
                                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 w-5 h-5 hidden rtl:inline" viewBox="0 0 20 20" fill="currentColor"> <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>

                                            </a>
                                        @endif
                        
                                        <h1 class="mb-4 text-2xl font-extrabold tracking-wide leading-none text-gray-900 md:text-3xl lg:text-4xl">
                                            {{ __('messages.t_get_ur_work_done_easy_safe') }}
                                        </h1>
                        
                                        <p class="mb-8 text-sm font-light text-gray-600 lg:text-xl sm:px-16 xl:px-48 dark:text-gray-400">
                                            {{ __('messages.t_register_subtitle', ['app_name' => config('app.name')]) }}
                                        </p>
                        
                                        <div class="flex flex-col mb-8 lg:mb-6 space-y-4 sm:flex-row sm:justify-center sm:space-y-0 sm:space-x-4 sm:space-x-reverse">
                        
                                            
                                            {{-- Primary button --}}
                                            @if (settings('appearance')->primary_link_text)
                                                <a href="{{ settings('appearance')->primary_link_target }}" target="_blank" class="inline-flex justify-center items-center py-3 px-8 text-base font-medium text-center text-white rounded-md bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300">
                                                    {{ settings('appearance')->primary_link_text }}
                                                </a>
                                            @endif
                    
                                            {{-- Secondary button --}}
                                            @if (settings('appearance')->secondary_link_text)
                                                <a href="{{ settings('appearance')->secondary_link_target }}" target="_blank" class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-gray-900 rounded-md border border-gray-100 hover:bg-gray-50 focus:ring-4 focus:ring-gray-100 bg-gray-100">
                                                    {{ settings('appearance')->secondary_link_text }}
                                                </a>  
                                            @endif 
                        
                                        </div>
                        
                                    </div>
                                </section>
                            </div>
                        </div> 
                    @endif
                @endguest
            @endif

            <div class="container !max-w-full py-12 px-10 lg:px-24 pt-16 pb-24 space-y-8 min-h-screen">
                @yield('content')
            </div>
        </main>

        {{-- Footer --}}
        @livewire('main.includes.footer')

        {{-- Livewire scripts --}}
        @livewireScripts

        <!-- Alpine Plugins -->
        <script defer src="https://unpkg.com/@alpinejs/mask@3.x.x/dist/cdn.min.js"></script>
        <script src="https://unpkg.com/@victoryoalli/alpinejs-screen@1.0.0/dist/screen.min.js" defer></script>

        {{-- AlpineJS Core --}}
        <script src="//unpkg.com/alpinejs" defer></script>

        {{-- jQuery --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

        {{-- Select2 --}}
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        {{-- Pharaonic select2 --}}
        <x:pharaonic-select2::scripts />

        {{-- Flowbite --}}
        <script src="https://unpkg.com/flowbite@1.4.7/dist/flowbite.js"></script>

        {{-- Toastr Plugin --}}
        <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

        {{-- Helpers --}}
        <script src="{{ url('public/js/utils.js') }}"></script>
        <script src="{{ url('public/js/components.js') }}"></script>

        {{-- Rating Plugin --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>

        {{-- JavaScript Codes --}}
        <script>

            // Check when page loaded
            document.addEventListener('DOMContentLoaded', () => {
                $('#screen-loader').addClass('hidden')
                $('body').removeClass('overflow-y-hidden')
            });

            // Toastr notification
            window.addEventListener('alert', ({detail:{type = 'success',message}}) => {
                window.toast(message, type);
            });

            // Refresh
            window.addEventListener('refresh',() => {
                location.reload();
            });

            // Scroll to specific div
            window.addEventListener('scrollTo', (event) => {

                // Get id to scroll
                const id = event.detail;

                // Scroll
                $('html, body').animate({
                    scrollTop: $("#" + id).offset().top
                }, 500);

            });

            // Scroll to up page
            window.addEventListener('scrollUp', () => {

                // Scroll
                $('html, body').animate({
                    scrollTop: $("body").offset().top
                }, 500);

            });

            // Scroll up on page change
            $(document).on('click', '.page-link-scroll-to-top', function (e) {
                $("html, body").animate({ scrollTop: 0 }, "slow");
                return false;
            });

            // Shopping cart dialog
            function WgRqLnTxHBZBRzq() {
                return {

                    title: null,
                    open: false,

                    close() {

                        // Close
                        this.open  = false;

                        // Reset title
                        this.title = null;
                    },

                    init() {

                        document.addEventListener('item-added-to-cart', (e) => {
                            const _this = this;

                            this.title  = e.detail.gig.title;

                            this.open   = true;

                            // // Hide this box after 10 secs
                            setTimeout(() => {
                                _this.open  = false;
                                _this.title = null;
                            }, 10000);

                        });

                        if(document.readyState === 'ready' || document.readyState === 'complete') {
                            $('#gig-added-to-cart').removeClass('hidden');
                        } else {
                            document.onreadystatechange = function () {
                                if (document.readyState == "complete") {
                                    $('#gig-added-to-cart').removeClass('hidden');
                                }
                            }
                        }

                    }

                }
            }
            window.WgRqLnTxHBZBRzq = WgRqLnTxHBZBRzq();

        </script>

        {{-- Gigs rating plugin --}}
        <script>
            window.rating({ target: "gig-card-rating-container", fill: "#ff9f31", background: "#eadeaf" });
        </script>

        {{-- Custom scripts --}}
        @stack('scripts')

    </body>

</html>