@if ($paginator->hasPages())
    <div class="pagination-container text-center">
        <ul class="pagination justify-content-center">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="disabled page-item"><a class="page-link" href="#">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only"> @lang('corals-neptune::labels.partial.previous')</span></a>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}"
                       rel="prev">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">@lang('corals-neptune::labels.partial.previous')</span>
                    </a>
                </li>
            @endif

            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="disabled page-item"><a class="page-link" href="#">{{ $element }}</a></li>
                @endif
                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active page-item">
                                <a class="page-link" href="#">
                                    {{ $page }}
                                </a>
                            </li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach
            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">@lang('corals-neptune::labels.partial.next')</span>
                    </a>
                </li>
            @else
                <li class="disabled page-item">
                    <a class="page-link" href="#">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">@lang('corals-neptune::labels.partial.next')</span>
                    </a>
                </li>
            @endif
        </ul><!--//pagination-->
    </div><!--//pagination-container-->
@endif
