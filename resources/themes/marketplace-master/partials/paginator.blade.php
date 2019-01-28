@if ($paginator->hasPages())
    <nav class="pagination">
        {{-- Previous Page Link --}}
        @if (!$paginator->onFirstPage())
            <div class="column text-left hidden-xs-down">
                <a class="btn btn-outline-secondary btn-sm" href="{{ $paginator->previousPageUrl() }}">
                    <i class="icon-arrow-left"></i>&nbsp; @lang('corals-marketplace-master::labels.partial.previous')
                </a>
            </div>
        @endif
        <div class="column">
            <ul class="pages">
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li>{{ $element }}</li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="active"><a href="#">{{ $page }}</a></li>
                            @else
                                <li><a href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </ul>
        </div>
        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <div class="column text-right hidden-xs-down">
                <a class="btn btn-outline-secondary btn-sm" href="{{ $paginator->nextPageUrl() }}">
                    @lang('corals-marketplace-master::labels.partial.next')&nbsp;<i class="icon-arrow-right"></i></a>
            </div>
        @endif
    </nav>
@endif
