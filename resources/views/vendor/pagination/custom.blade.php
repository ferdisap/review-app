@if ($paginator->hasPages())
    <nav x-data role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between mt-5">

        <div class="w-full flex flex-wrap justify-center">
            <div class="mx-4">
                <p class="text-sm text-gray-700 leading-5">
                    {!! __('Showing') !!}
                    @if ($paginator->firstItem())
                        <span class="font-medium">{{ $paginator->firstItem() }}</span>
                        {!! __('to') !!}
                        <span class="font-medium">{{ $paginator->lastItem() }}</span>
                    @else
                        {{ $paginator->count() }}
                    @endif
                    {!! __('of') !!}
                    <span class="font-medium">{{ $paginator->total() }}</span>
                    {!! __('results') !!}
                </p>
            </div>

            <div>
                <span class="relative z-0 inline-flex shadow-sm rounded-md">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                            <span class="mx-1" aria-hidden="true">
                                <<
                            </span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="mx-1" aria-label="{{ __('pagination.previous') }}"
                           x-on:click="$store.paginationURL.chgURL(this.event, $el.href)">
                            <<
                        </a>
                    @endif
                    

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span class="mx-1">{{ $element }}</span>
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page">
                                        <span class="mx-1" style="color:#38bdf8"><b>{{ $page }}</b></span>
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="mx-1" aria-label="{{ __('Go to page :page', ['page' => $page]) }}"
                                       x-on:click="$store.paginationURL.chgURL(this.event, $el.href)">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="mx-1" aria-label="{{ __('pagination.next') }}"
                          x-on:click="$store.paginationURL.chgURL(this.event, $el.href)">
                            >>
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                            <span class="mx-1" aria-hidden="true">
                                >>
                            </span>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
