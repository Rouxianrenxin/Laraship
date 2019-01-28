@if ($paginator->hasPages())
    <nav aria-label="Page navigation example" class="clearfix">
        <ul class="pagination float-right">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="disabled page-item"><a class="page-link" href="#">@lang('corals-saas::labels.partial.previous')</a></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">@lang('corals-saas::labels.partial.previous')</a></li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="disabled page-item"><a class="page-link" href="#">{{ $element }}</a></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active page-item"><a class="page-link" href="#">{{ $page }}</a></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">@lang('corals-saas::labels.partial.next')</a></li>
            @else
                <li class="disabled page-item"><a class="page-link" href="#">@lang('corals-saas::labels.partial.next')</a></li>
            @endif
        </ul>
    </nav>
@endif
