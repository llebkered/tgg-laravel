
@if ($paginator->hasPages())
<nav class="pagination is-centered" role="navigation" aria-label="pagination">

    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
    <a class="pagination-previous" disabled aria-disabled="true"
        aria-label="@lang('pagination.previous')">Previous</a>
    @else
    <a class="pagination-previous" href="{{ $paginator->previousPageUrl() }}" rel="prev"
        aria-label="@lang('pagination.previous')">Previous</a>
    @endif

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
    <a class="pagination-next" href="{{ $paginator->nextPageUrl() }}" rel="next"
        aria-label="@lang('pagination.next')">Next page</a>
    @else
    <a class="pagination-next" disabled aria-disabled="true" aria-label="@lang('pagination.next')">Next page</a>
    @endif

            {{-- Pagination Elements --}}
            <ul class="pagination-list">
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="disabled pagination-ellipsis" aria-disabled="true"><span>{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="pagination-link is-current" aria-current="page"><span>{{ $page }}</span></li>
                        @else
                            <li><a class="pagination-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach
            </ul>
</nav>

@endif
