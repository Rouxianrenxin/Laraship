@component('components.box',['box_title' => 'Folders'])
    @slot('box_title')
        @lang('Messaging::labels.discussion.folders')
    @endslot
    <ul class="nav-pills nav-stacked">
        <li><a href="{{ url('messaging/discussions') }}"><i class="fa fa-inbox"></i> @lang('Messaging::labels.discussion.inbox')
            </a></li>
        </li>
        <li><a href="{{ url('messaging/discussions/status/deleted') }}"><i class="fa fa-trash-o"></i> @lang('Messaging::labels.discussion.deleted')</a></li>
    </ul>
@endcomponent
<!-- /. box -->

@component('components.box')
    @slot('box_title')
        @lang('Messaging::labels.discussion.labels')
    @endslot

    <ul class=" nav-pills nav-stacked">
        <li><a href="{{ url('messaging/discussions/status/read') }}"><i class="fa fa-envelope-open"></i> @lang('Messaging::labels.discussion.read')</a></li>
        <li><a href="{{ url('messaging/discussions/status/unread') }}"><i class="fa fa-envelope"></i> @lang('Messaging::labels.discussion.unread')</a></li>
        <li><a href="{{ url('messaging/discussions/status/important') }}"><i class="fa fa-info-circle"></i> @lang('Messaging::labels.discussion.important')</a></li>
        <li><a href="{{ url('messaging/discussions/status/star') }}"><i class="fa fa-star"></i> @lang('Messaging::labels.discussion.star')</a></li>

    </ul>
@endcomponent
<!-- /.box -->