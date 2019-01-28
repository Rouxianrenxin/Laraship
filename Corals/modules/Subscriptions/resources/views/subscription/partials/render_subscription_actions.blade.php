@foreach($actions as $action)
    @if(!empty($action) && is_array($action) && array_has($action,'url') && array_has($action,'title'))
        <a href="{{ $action['url'] }}"
           title="{{ $action['title'] }}"
           class="{{ $action['class']??'' }}">
            <i class="{{ $action['icon']??'' }}"></i> {{ $action['title'] }}
        </a>
    @endif
@endforeach