@component('components.box')
    <div class="announcement-item">
        @if($item->image)
            <div class="el-overlay-1">
                <div class="announcement-image" style="background-image: url('{{ $item->image }}');">
                </div>
                <div class="el-overlay">
                    <ul class="el-info">
                        <li>
                            <a class="btn default btn-outline image-popup-vertical-fit show_announcement"
                               href="{{ $item->getShowURL() }}" data-title="{{ $item->title }}"
                               data-ann_hashed_id="{{ $item->hashed_id }}">
                                <i class="fa fa-search fa-fw"></i>
                            </a>
                        </li>
                        @if($item->link)
                            <li>
                                <a class="btn default btn-outline" target="_blank" href="{{ $item->link }}">
                                    <i class="fa fa-link fa-fw"></i>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        @endif
        <div class="m-t-5">
            <small class="pull-left float-left">
                <i class="fa fa-clock-o"></i> {!! $item->starts_at->diffForHumans() !!}
            </small>
            <small class="pull-right float-right {{ !($isRead= $item->isRead())?'badge badge-yellow':'' }}">
                <i class="fa fa-flag-o"></i> {{ $isRead?trans('Announcement::labels.is_read'):trans('Announcement::labels.is_new') }}
            </small>
            <div class="clearfix"></div>
        </div>
        <div class="announcement-title">
            <a href="{{ $item->getShowURL() }}" data-title="{{ $item->title }}"
               class="show_announcement" data-ann_hashed_id="{{ $item->hashed_id }}">
                <h4 class="text-center m-t-10 m-b-10">{{ $item->title }}</h4>
            </a>
        </div>
    </div>
@endcomponent