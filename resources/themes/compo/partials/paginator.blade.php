@if ($paginator->hasPages())
<nav class="mt-40">
    <ul class="pagination justify-content-center">
        @if ($paginator->onFirstPage())
            <li class="page-item"><a class="page-link" href="#">@lang('corals-compo::labels.partial.previous')</a></li>
        @else
            <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">@lang('corals-compo::labels.partial.previous')</a></li>
        @endif

            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="disabled"><a href="#">{{ $element }}</a></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active"><a class="page-link" href="#">{{ $page }}</a></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">@lang('corals-compo::labels.partial.next')</a></li>
            @else
                <li class="page-item"><a class="page-link" href="#">@lang('corals-compo::labels.partial.next')</a></li>
            @endif
    </ul>
</nav>
@endif