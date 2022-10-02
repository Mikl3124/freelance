<div class="w-full px-2 lg:px-0">
    <div class="w-full lg:max-w-4xl mx-auto">
        <div class="relative py-16 bg-white overflow-hidden rounded-md shadow-sm border border-gray-100">
            <div class="relative px-4 sm:px-6 lg:px-8">
                <div class="text-lg mx-auto">
                    <h1>
                        <span class="block text-xl text-center leading-8 font-extrabold tracking-wide text-gray-900 sm:text-3xl mb-2">{{ $page->title }}</span>
                        <span class="block text-xs text-center text-gray-400 font-normal tracking-widest">
                            {{ __('messages.t_page_last_update_date', ['date' => format_date($page->updated_at)]) }}
                        </span>
                    </h1>
                </div>
                <div class="mt-16 px-12">
                    {!! $page->content !!}
                </div>
            </div>
        </div>
    </div>
</div>