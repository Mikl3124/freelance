<div class="w-full">

    {{-- Section title --}}
    <div class="px-4 md:px-3 py-4 md:py-5 bg-white border !border-b-0 dark:bg-gray-700 rounded-tl-lg rounded-tr-lg">
        <div class="sm:flex items-center justify-between">
            <p class="text-sm font-bold leading-wide text-gray-800">
                {{ __('messages.t_invoices') }}
            </p>
        </div>
    </div>

    {{-- Section content --}}
    <div class="bg-white dark:bg-gray-800 overflow-y-auto border !border-t-0 !border-b-0">
        <table class="w-full whitespace-nowrap">
            <thead class="bg-gray-200">
                <tr tabindex="0" class="focus:outline-none h-16 w-full text-sm leading-none text-gray-800 dark:text-white ">
                    <th class="font-bold text-[10px] text-slate-500 uppercase tracking-wider ltr:text-left ltr:pl-4 rtl:text-right rtl:pr-4">{{ __('messages.t_buyer') }}</th>
                    <th class="font-bold text-[10px] text-slate-500 uppercase tracking-wider ltr:text-left ltr:pl-4 rtl:text-right rtl:pr-4">{{ __('messages.t_payment') }}</th>
                    <th class="font-bold text-[10px] text-slate-500 uppercase tracking-wider text-center">{{ __('messages.t_total_amount') }}</th>
                    <th class="font-bold text-[10px] text-slate-500 uppercase tracking-wider text-center">{{ __('messages.t_status') }}</th>
                    <th class="font-bold text-[10px] text-slate-500 uppercase tracking-wider text-center">{{ __('messages.t_date') }}</th>
                    <th class="font-bold text-[10px] text-slate-500 uppercase tracking-wider text-center">{{ __('messages.t_options') }}</th>
                </tr>
            </thead>
            <tbody class="w-full">

                @foreach ($invoices as $invoice)
                    <tr class="focus:outline-none h-20 text-sm leading-none text-gray-800 bg-white hover:bg-gray-100 border-b border-t border-gray-100" wire:key="invoices-{{ $invoice->id }}">

                        {{-- Buyer --}}
                        <td class="ltr:pl-4 rtl:pr-4">
                            <div class="flex items-center">
                                <div class="w-8 h-8">
                                    <img class="w-full h-full rounded object-cover" src="{{ src($invoice->order->buyer->avatar) }}" alt="{{ $invoice->order->buyer->username }}" />
                                </div>
                                <div class="ltr:pl-4 rtl:pr-4">
                                    <a href="{{ admin_url('users/details/' . $invoice->order->buyer->uid) }}" target="_blank" class="font-medium text-xs hover:text-indigo-600 truncate pb-1.5 block max-w-xs">{{ $invoice->order->buyer->username }}</a>
                                    <div class="flex items-center text-[11px] font-normal text-gray-400">
                                        {{ $invoice->firstname }} {{ $invoice->lastname }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        {{-- Payment --}}
                        <td class="ltr:pl-4 rtl:pr-4">
                            <div class="flex items-center">
                                <div class="w-8 h-8">
                                    @switch($invoice->payment_method)

                                        {{-- Stripe --}}
                                        @case('stripe')
                                            <div class="bg-gray-50 rounded-md h-8 w-8 p-1">
                                                <svg viewBox="0 -149 512 512" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid"> <g> <path d="M35.9822222,83.4844444 C35.9822222,77.9377778 40.5333333,75.8044444 48.0711111,75.8044444 C58.88,75.8044444 72.5333333,79.0755556 83.3422222,84.9066667 L83.3422222,51.4844444 C71.5377778,46.7911111 59.8755556,44.9422222 48.0711111,44.9422222 C19.2,44.9422222 0,60.0177778 0,85.1911111 C0,124.444444 54.0444444,118.186667 54.0444444,135.111111 C54.0444444,141.653333 48.3555556,143.786667 40.3911111,143.786667 C28.5866667,143.786667 13.5111111,138.951111 1.56444444,132.408889 L1.56444444,166.257778 C14.7911111,171.946667 28.16,174.364444 40.3911111,174.364444 C69.9733333,174.364444 90.3111111,159.715556 90.3111111,134.257778 C90.1688889,91.8755556 35.9822222,99.4133333 35.9822222,83.4844444 Z M132.124444,16.4977778 L97.4222222,23.8933333 L97.28,137.813333 C97.28,158.862222 113.066667,174.364444 134.115556,174.364444 C145.777778,174.364444 154.311111,172.231111 159.004444,169.671111 L159.004444,140.8 C154.453333,142.648889 131.982222,149.191111 131.982222,128.142222 L131.982222,77.6533333 L159.004444,77.6533333 L159.004444,47.36 L131.982222,47.36 L132.124444,16.4977778 Z M203.235556,57.8844444 L200.96,47.36 L170.24,47.36 L170.24,171.804444 L205.795556,171.804444 L205.795556,87.4666667 C214.186667,76.5155556 228.408889,78.5066667 232.817778,80.0711111 L232.817778,47.36 C228.266667,45.6533333 211.626667,42.5244444 203.235556,57.8844444 Z M241.493333,47.36 L277.191111,47.36 L277.191111,171.804444 L241.493333,171.804444 L241.493333,47.36 Z M241.493333,36.5511111 L277.191111,28.8711111 L277.191111,0 L241.493333,7.53777778 L241.493333,36.5511111 Z M351.431111,44.9422222 C337.493333,44.9422222 328.533333,51.4844444 323.555556,56.0355556 L321.706667,47.2177778 L290.417778,47.2177778 L290.417778,213.048889 L325.973333,205.511111 L326.115556,165.262222 C331.235556,168.96 338.773333,174.222222 351.288889,174.222222 C376.746667,174.222222 399.928889,153.742222 399.928889,108.657778 C399.786667,67.4133333 376.32,44.9422222 351.431111,44.9422222 Z M342.897778,142.933333 C334.506667,142.933333 329.528889,139.946667 326.115556,136.248889 L325.973333,83.4844444 C329.671111,79.36 334.791111,76.5155556 342.897778,76.5155556 C355.84,76.5155556 364.8,91.0222222 364.8,109.653333 C364.8,128.711111 355.982222,142.933333 342.897778,142.933333 Z M512,110.08 C512,73.6711111 494.364444,44.9422222 460.657778,44.9422222 C426.808889,44.9422222 406.328889,73.6711111 406.328889,109.795556 C406.328889,152.604444 430.506667,174.222222 465.208889,174.222222 C482.133333,174.222222 494.933333,170.382222 504.604444,164.977778 L504.604444,136.533333 C494.933333,141.368889 483.84,144.355556 469.76,144.355556 C455.964444,144.355556 443.733333,139.52 442.168889,122.737778 L511.715556,122.737778 C511.715556,120.888889 512,113.493333 512,110.08 Z M441.742222,96.5688889 C441.742222,80.4977778 451.555556,73.8133333 460.515556,73.8133333 C469.191111,73.8133333 478.435556,80.4977778 478.435556,96.5688889 L441.742222,96.5688889 L441.742222,96.5688889 Z" fill="#6772E5"></path> </g></svg>
                                            </div>
                                            @break

                                        {{-- Paypal --}}
                                        @case('paypal')
                                            <div class="bg-gray-50 rounded-md h-8 w-8 p-1">
                                                <svg xmlns="http://www.w3.org/2000/svg"aria-label="PayPal" role="img"viewBox="0 0 512 512"><rectwidth="512" height="512"rx="15%"fill="#fff"/><path fill="#002c8a" d="M377 184.8L180.7 399h-72c-5 0-9-5-8-10l48-304c1-7 7-12 14-12h122c84 3 107 46 92 112z"/><path fill="#009be1" d="M380.2 165c30 16 37 46 27 86-13 59-52 84-109 85l-16 1c-6 0-10 4-11 10l-13 79c-1 7-7 12-14 12h-60c-5 0-9-5-8-10l22-143c1-5 182-120 182-120z"/><path fill="#001f6b" d="M197 292l20-127a14 14 0 0 1 13-11h96c23 0 40 4 54 11-5 44-26 115-128 117h-44c-5 0-10 4-11 10z"/></svg>
                                            </div>
                                            @break

                                        {{-- Balance --}}
                                        @case('balance')
                                            <div class="bg-gray-50 rounded-md h-8 w-8 p-1.5">
                                                <svg class="fill-gray-500" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 486.3 486.3" style="enable-background:new 0 0 486.3 486.3;" xml:space="preserve"><g><g><g><path d="M0,41.25h486.3v128.1c0,44.4-36,80.3-80.3,80.3v-128.8H80.3v128.8c-44.3,0-80.3-36-80.3-80.3C0,169.35,0,41.25,0,41.25z M220.9,349.35c0,12.4,10.1,22.5,22.5,22.5c12.4,0,22.5-10.1,22.5-22.5s-10.1-22.5-22.5-22.5S220.9,336.95,220.9,349.35z M110.8,150.35v257.7c0,20.4,16.6,37,37,37h190.5c20.4,0,37-16.6,37-37v-257.7h-31.6v219.7c-2.2-0.4-4.5-0.6-6.9-0.6c-20.7,0-37.5,16.8-37.5,37.5c0,2.2,0.2,4.4,0.6,6.6H186.2c0.4-2.1,0.6-4.3,0.6-6.6c0-20.7-16.8-37.5-37.5-37.5c-2.4,0-4.7,0.2-6.9,0.6v-219.7H110.8z M243.1,312.35c-44.7,0-81-36.3-81-81s36.3-81,81-81s81,36.3,81,81S287.8,312.35,243.1,312.35z M284.5,213.45l-15.7-15.8l-36.2,36l-15.1-15.2l-15.8,15.7l15.1,15.2l15.7,15.8l15.8-15.7L284.5,213.45z"/></g></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
                                            </div>
                                            @break

                                        {{-- Offline --}}
                                        @case('offline')
                                            <div class="bg-gray-50 rounded-md h-8 w-8 p-1.5">
                                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"><path style="fill:#E7ECED;" d="M256,69.385c11.803,0,21.46,9.657,21.46,21.46s-9.657,21.46-21.46,21.46c-11.803,0-21.46-9.657-21.46-21.46S244.197,69.385,256,69.385z"/><rect x="218.443" y="326.902" style="fill:#AFB6BB;" width="75.11" height="37.555"/><rect x="218.443" y="364.457" style="fill:#7C8287;" width="75.11" height="69.745"/><polygon style="fill:#E7ECED;" points="186.255,219.606 186.255,187.416 325.745,187.416 325.745,219.606 341.841,219.606 341.841,262.526 170.16,262.526 170.16,219.606 "/><polygon style="fill:#C7CAC7;" points="325.745,402.017 325.745,434.207 293.555,434.207 293.555,364.462 293.555,326.906 218.445,326.906 218.445,364.462 218.445,434.207 186.255,434.207 186.255,402.017 170.16,402.017 170.16,262.526 341.841,262.526 341.841,402.017 "/><polygon style="fill:#8A9095;" points="443.776,434.207 443.776,466.397 68.224,466.397 68.224,434.207 78.954,434.207 186.255,434.207 218.445,434.207 293.555,434.207 325.745,434.207 433.046,434.207 "/><path style="fill:#AFB6BB;" d="M470.601,477.127v26.825H41.399v-26.825c0-5.902,4.829-10.73,10.73-10.73h16.095h375.552h16.095C465.773,466.397,470.601,471.226,470.601,477.127z"/><g><rect x="325.743" y="402.013" style="fill:#E7ECED;" width="107.301" height="32.19"/><polygon style="fill:#E7ECED;" points="186.255,402.017 186.255,434.207 78.954,434.207 78.954,402.017 95.049,402.017 170.16,402.017 "/><polygon style="fill:#E7ECED;" points="341.841,219.606 325.745,219.606 325.745,187.416 433.046,187.416 433.046,219.606 416.951,219.606 "/><polygon style="fill:#E7ECED;" points="78.954,187.416 186.255,187.416 186.255,219.606 170.16,219.606 95.049,219.606 78.954,219.606 "/></g><g><polygon style="fill:#A4A9AB;" points="416.951,219.606 416.951,402.017 341.841,402.017 341.841,262.526 341.841,219.606 "/><polygon style="fill:#A4A9AB;" points="170.16,219.606 170.16,262.526 170.16,402.017 95.049,402.017 95.049,219.606 "/><path style="fill:#A4A9AB;" d="M470.601,160.59v26.825h-37.555H325.745H186.255H78.954H41.399V160.59c0-5.902,4.829-10.73,10.73-10.73h32.19h343.362h32.19C465.773,149.86,470.601,154.689,470.601,160.59z"/></g><path style="fill:#E7ECED;" d="M427.681,149.86H84.319L256,10.37L427.681,149.86z M277.46,90.845c0-11.803-9.657-21.46-21.46-21.46c-11.803,0-21.46,9.657-21.46,21.46s9.657,21.46,21.46,21.46C267.803,112.305,277.46,102.648,277.46,90.845z"/><path d="M256,61.337c-16.271,0-29.508,13.237-29.508,29.508s13.237,29.508,29.508,29.508c16.271,0,29.508-13.237,29.508-29.508S272.27,61.337,256,61.337z M256,104.258c-7.396,0-13.413-6.016-13.413-13.413S248.604,77.432,256,77.432c7.396,0,13.413,6.016,13.413,13.413S263.395,104.258,256,104.258z"/><path d="M441.094,227.653v-32.19h37.555V160.59c0-10.353-8.424-18.778-18.778-18.778h-29.333L256,0L81.462,141.813H52.129c-10.353,0-18.778,8.424-18.778,18.778v34.873h37.555v32.19h16.095v166.316H70.906v32.19h-10.73v32.19h-8.048c-10.353,0-18.778,8.424-18.778,18.778V512h445.298v-34.873c0-10.353-8.424-18.778-18.778-18.778h-8.048v-32.19h-10.73v-32.19h-16.095V227.653H441.094z M424.999,211.558h-91.206v-16.095h91.206V211.558z M387.443,369.827V227.653h21.46v166.316h-59.015V227.653h21.46v142.173H387.443z M333.793,393.969h-16.095v32.19h-16.095V318.859h-91.206V426.16h-16.095v-32.19h-16.095V270.574h155.586V393.969z M285.508,356.414h-59.015v-21.46h59.015V356.414z M226.492,372.509h59.015v53.65h-59.015V372.509z M333.793,254.478H178.207v-26.825h16.095v-32.19h123.396v32.19h16.095V254.478z M256,20.738l149.015,121.074h-298.03L256,20.738z M49.446,179.368V160.59c0-1.454,1.229-2.683,2.683-2.683h407.742c1.454,0,2.683,1.229,2.683,2.683v18.778H49.446z M87.002,195.463h91.206v16.095H87.002V195.463z M140.652,369.827V227.653h21.46v166.316h-59.015V227.653h21.46v142.173H140.652z M87.002,410.064h91.206v16.095H87.002V410.064z M459.871,474.445c1.454,0,2.683,1.229,2.683,2.683v18.778H49.446v-18.778c0-1.454,1.229-2.683,2.683-2.683H459.871z M435.729,442.255v16.095H76.271v-16.095H435.729z M424.999,426.16h-91.206v-16.095h91.206V426.16z"/><rect x="239.903" y="216.919" width="32.19" height="16.095"/><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
                                            </div>
                                            @break

                                        @default
                                            
                                    @endswitch
                                </div>
                                <div class="ltr:pl-4 rtl:pr-4">
                                    <div class="font-medium text-xs hover:text-indigo-600 truncate pb-1.5 block max-w-xs">
                                        @switch($invoice->payment_method)

                                            {{-- Stripe --}}
                                            @case('stripe')
                                                {{ __('messages.t_stripe') }}
                                                @break

                                            {{-- Paypal --}}
                                            @case('paypal')
                                                {{ __('messages.t_paypal') }}
                                                @break

                                            {{-- Balance --}}
                                            @case('balance')
                                                {{ __('messages.t_user_credit') }}
                                                @break

                                            {{-- Offline --}}
                                            @case('offline')
                                                {{ settings('offline_payment')->name }}
                                                @break

                                            @default
                                                
                                        @endswitch
                                    </div>
                                    <div class="flex items-center text-[11px] font-normal text-gray-400">
                                        {{ $invoice->payment_id }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        {{-- Total --}}
                        <td class="text-center">
                            <span class="text-xs font-black font-[Lato]">@money($invoice->order->total_value, settings('currency')->code, true)</span>
                        </td>

                        {{-- Status --}}
                        <td class="text-center">

                            {{-- Paid --}}
                            @if ($invoice->status === 'paid')
                                <span class="px-4 py-1 text-xs rounded-2xl font-semibold text-green-500 bg-green-50">
                                    {{ __('messages.t_paid') }}
                                </span>
                            @else
                                <span class="px-4 py-1 text-xs rounded-2xl font-semibold text-amber-500 bg-amber-50">
                                    {{ __('messages.t_pending') }}
                                </span>
                            @endif

                        </td>

                        {{-- Placed at --}}
                        <td class="text-center">
                            <span class="text-xs font-medium text-gray-500">{{ format_date($invoice->created_at, 'ago') }}</span>
                        </td>

                        {{-- Options --}}
                        <td class="text-center">
                            <div class="relative inline-block text-left">
                                <div>
                                    <button data-dropdown-toggle="table-options-dropdown-{{ $invoice->id }}" type="button" class="inline-flex justify-center items-center rounded-full h-8 w-8 bg-white hover:bg-gray-50 focus:outline-none focus:ring-0" id="menu-button" aria-expanded="true" aria-haspopup="true">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" viewBox="0 0 20 20" fill="currentColor"> <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"/></svg>
                                    </button>
                                </div>
                                <div id="table-options-dropdown-{{ $invoice->id }}" class="hidden z-40 origin-top-right absolute right-0 mt-2 w-44 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                                    <div class="py-1" role="none">

                                        {{-- Order details --}}
                                        <a href="{{ admin_url('orders/details/' . $invoice->order->uid) }}" target="_blank" class="text-gray-800 group flex items-center px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="ltr:mr-3 rtl:ml-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"> <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                                            <span class="text-xs font-medium">{{ __('messages.t_order_details') }}</span>
                                        </a>

                                        {{-- Invoice paid --}}
                                        <button x-on:click="confirm('{{ __('messages.t_are_u_sure_u_received_invocie_payment') }}') ? $wire.paid('{{ $invoice->id }}') : ''" wire:loading.attr="disabled" wire:target="paid('{{ $invoice->id }}')" type="button" class="text-gray-800 group flex items-center px-4 py-2 text-sm" role="menuitem" tabindex="-1" >

                                            {{-- Loading indicator --}}
                                            <div wire:loading wire:target="paid('{{ $invoice->id }}')">
                                                <svg role="status" class="ltr:mr-3 rtl:ml-3 inline w-5 h-5 text-gray-500 animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                                                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                                                </svg>
                                            </div>

                                            {{-- Icon --}}
                                            <div wire:loading.remove wire:target="paid('{{ $invoice->id }}')">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="ltr:mr-3 rtl:ml-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"> <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            </div>

                                            <span class="text-xs font-medium">{{ __('messages.t_payment_received') }}</span>

                                        </button>

                                    </div>
                                </div>
                            </div>
                        </td>

                    </tr>
                @endforeach
                
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if ($invoices->hasPages())
        <div class="bg-gray-100 px-4 py-5 sm:px-6 rounded-bl-lg rounded-br-lg flex justify-center border-t-0 border-r border-l border-b">
            {!! $invoices->links('pagination::tailwind') !!}
        </div>
    @endif

</div>
