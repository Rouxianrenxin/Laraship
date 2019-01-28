@extends('layouts.crud.show')

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title }}
        @endslot
        @slot('breadcrumb')
            {{ Breadcrumbs::render('discussions') }}
        @endslot
    @endcomponent
@endsection

@section('content')
    <div class="row">
        <div class="col-md-2">
            @can('create', Corals\Modules\Messaging\Models\Discussion::class)
                @can('select_recipient', Corals\Modules\Messaging\Models\Discussion::class)
                {!! CoralsForm::link(url('messaging/discussions/create'),'Messaging::labels.discussion.compose',['class'=>"btn btn-primary btn-block margin-bottom"]) !!}
                @endcan
            @endcan
            @include('Messaging::partials.messaging_sidebar')
        </div>
        <!-- /.col -->
        <div class="col-md-10">
            <div>
                {!! CoralsForm::openForm(null, ['url' => '', 'method' => 'GET', 'class' => '']) !!}
                {!! CoralsForm::text('search','',false,null,['placeholder'=>'Messaging::attributes.discussion.search','right_addon'=>'<i class="fa fa-search"></i>','class'=>'m-b-0']) !!}
                {!! CoralsForm::closeForm() !!}
            </div>
            @component('components.box')

                @if(count($discussions))
                    <div class="row m-b-5">
                        <div class="col-md-12">
                            <div class="mailbox-controls row">
                                <div class="col-md-10">
                                    @if(!empty($search_term))
                                        <h5>
                                            <b>@lang('Messaging::messages.discussion.search_result')</b> {{ $search_term }}
                                        </h5>
                                    @endif
                                </div>
                                <div class="col-md-2">
                                    <div class="btn-group pull-right" id="bulk_actions">

                                        @if($status != 'deleted')
                                            <a href="{{ url('messaging/discussions/bulk-action/deleted') }}"
                                               data-confirmation="@lang('Messaging::labels.discussion.confirm_delete')"
                                               class="btn btn-default btn-sm"><i class="fa fa-trash-o" title="@lang('Messaging::attributes.discussion.status_options.deleted')"></i></a>
                                        @endif
                                        <a href="{{ url('messaging/discussions/bulk-action/read') }}"
                                           data-confirmation="@lang('Messaging::labels.discussion.confirm_read')"
                                           class="btn btn-default btn-sm m-l-5"><i class="fa fa-envelope-open" title="@lang('Messaging::attributes.discussion.status_options.read')"></i></a>

                                    </div>
                                </div>
                                <!-- /.btn-group -->
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive mailbox-messages" style="min-height: 300px;">
                        <table class="table table-hover table-striped">
                            <thead>
                            <tr>
                                <th>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="check-all"/>
                                        <label class="custom-control-label" for="check-all"> </label>
                                    </div>
                                </th>
                                <th></th>
                                <th>@lang('Messaging::labels.participation.participation')</th>
                                <th>@lang('Messaging::attributes.discussion.subject')</th>
                                <th>@lang('Messaging::labels.discussion.messages_count')</th>
                                <th>@lang('Corals::attributes.created_at')</th>
                                <th>@lang('Corals::labels.actions')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($discussions as $discussion)
                                <tr>
                                    <td>{!! $discussion->present('checkbox') !!}</td>
                                    <td>{!! $discussion->present('icon') !!}</td>
                                    <td class="mailbox-name">
                                        {!! $discussion->present('participations') !!}
                                    </td>
                                    <td class="mailbox-subject">{!! $discussion->present('subject') !!}
                                    </td>
                                    <td><b>{{ count($discussion->messages()) }}</b>
                                        ({{ count($discussion->getUnreadMessages(user())) }} @lang('Messaging::labels.discussion.new')
                                        )
                                    </td>
                                    <td>{!! $discussion->present('created_at') !!}</td>
                                    <td>{!! $discussion->present('action') !!}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <!-- /.table -->
                    </div>
                    <div>
                        {{ $discussions->appends(request()->except('page'))->links() }}
                    </div>
                @else
                    <h4 class="text-center">
                        @lang('Messaging::labels.discussion.no_discussions_found')
                    </h4>
                @endif
            @endcomponent
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function () {

            $(document).on('change', '#check-all', function (event) {
                if ($(this).prop('checked')) {
                    $('.checkbox').prop('checked', true);
                } else {
                    $('.checkbox').prop('checked', false);
                }

                if ($.fn.iCheck) {
                    $('.checkbox').iCheck('update')
                }
            });

            $(document).on('change', '.checkbox', function (event) {
                var checkboxes = $('.checkbox');

                if (checkboxes.length == checkboxes.filter(':checked').length) {
                    $('#check-all').prop('checked', 'checked');
                } else {
                    $('#check-all').prop('checked', false);
                }

                if ($.fn.iCheck) {
                    $('#check-all').iCheck('update')
                }
            });

            $(document).on('click', '#bulk_actions a', function (event) {

                event.preventDefault();

                checked_ids = $('tbody input:checkbox:checked').map(function () {
                    return $(this).val();
                }).get();

                if (checked_ids.length > 0) {

                    var confirmation_message = $(this).data('confirmation');
                    var url = $(this).attr('href');

                    if (confirmation_message) {
                        themeConfirmation(
                            corals.confirmation.title,
                            confirmation_message,
                            'warning',
                            corals.confirmation.yes,
                            corals.confirmation.cancel,

                            function () {

                                $.ajax({
                                    url: url,
                                    type: 'POST',
                                    data: {selection: checked_ids},
                                    success: function (msg) {
                                        themeNotify(msg);
                                        site_reload();
                                    }
                                });

                            }
                        )

                    }
                }
            });
        });

    </script>
@endsection
