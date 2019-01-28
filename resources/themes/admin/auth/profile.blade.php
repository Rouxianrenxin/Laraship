@extends('layouts.master')

@section('title',$title)

@section('content_header')
    @component('components.content_header')

        @slot('page_title')
            {{ $title }}
        @endslot

        @slot('breadcrumb')
            {{ Breadcrumbs::render('profile') }}
        @endslot

    @endcomponent
@endsection

@section('css')
    {!! Html::style('assets/corals/plugins/cropper/cropper.css') !!}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/authy-form-helpers/2.3/flags.authy.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/authy-form-helpers/2.3/form.authy.css"/>
    <style>
        #image_source {
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <!-- /.col -->
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="@if($active_tab=="profile") active @endif">
                        <a href="#profile" data-toggle="tab">
                            @lang('corals-admin::labels.auth.profile')
                        </a>
                    </li>
                    @php \Actions::do_action('user_profile_tabs',user(),$active_tab) @endphp

                </ul>
                <div class="tab-content">
                    <div class="tab-pane @if($active_tab=="profile") active @endif" id="profile">
                        {!! Form::model($user = user(), ['url' => url('profile'), 'method'=>'PUT','class'=>'ajax-form','files'=>true]) !!}
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-pills">
                                <li class="active"><a href="#edit_profile" data-toggle="pill"><i
                                                class="fa fa-pencil"></i> @lang('corals-admin::labels.auth.edit_profile')
                                    </a></li>
                                <li>
                                    <a href="#profile_addresses" data-toggle="pill"><i class="fa fa-map-marker"></i>
                                        @lang('corals-admin::labels.auth.addresses')</a>
                                </li>
                                <li>
                                    <a href="#reset_password" data-toggle="pill"><i class="fa fa-lock"></i>
                                        @lang('corals-admin::labels.auth.auth_password')</a>
                                </li>
                                <li>
                                    <a href="#notification_preferences" data-toggle="pill"><i class="fa fa-bell-o"></i>
                                        @lang('corals-admin::labels.auth.notification_preferences')</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="edit_profile">
                                    <div class="row">
                                        <div class="col-md-4">
                                            {!! CoralsForm::text('name','User::attributes.user.name',true) !!}
                                            {!! CoralsForm::email('email','User::attributes.user.email',true) !!}
                                            {!! CoralsForm::textarea('properties[about]', 'User::attributes.user.about' , false, null,[
                                                'class'=>'limited-text',
                                                'maxlength'=>250,
                                                'help_text'=>'<span class="limit-counter">0</span>/250',
                                            'rows'=>'4']) !!}
                                        </div>
                                        <div id="country-div" class="col-md-4">
                                            {!! CoralsForm::text('last_name','User::attributes.user.last_name',true) !!}
                                            {!! CoralsForm::text('phone_country_code','User::attributes.user.phone_country_code',false,null,['id'=>'authy-countries']) !!}
                                            {!! CoralsForm::text('phone_number','User::attributes.user.phone_number',false,null,['id'=>'authy-cellphone']) !!}
                                            {!! CoralsForm::text('job_title','User::attributes.user.job_title') !!}
                                        </div>
                                        <div class="col-md-4">
                                            <div class="text-center">
                                                <img id="image_source"
                                                     class="profile-user-img img-responsive img-circle"
                                                     style="width: 200px"
                                                     src="{{ user()->picture }}"
                                                     alt="User profile picture">
                                                {{ Form::hidden('profile_image') }}
                                                <small class="">@lang('corals-admin::labels.auth.click_pic_update')</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="profile_addresses">
                                    @include('Settings::addresses.address_list_form', [
                                    'url'=>url('users/'.$user->hashed_id.'/address'),'method'=>'POST',
                                    'model'=>$user,
                                    'addressDiv'=>'#profile_addresses'
                                    ])
                                </div>
                                <div class="tab-pane" id="notification_preferences">
                                    @forelse(\CoralsNotification::getUserNotificationTemplates(user()) as $notifications_template)
                                        <div class="row">
                                            <div class="col-md-12">
                                                {!! CoralsForm::checkboxes(
                                                'notification_preferences['.$notifications_template->id .'][]',
                                                $notifications_template->friendly_name,
                                                false, $options = config('notification.supported_channels'),
                                                $selected = $user->notification_preferences[$notifications_template->id] ?? [],
                                                ['checkboxes_wrapper'=>'span', 'label'=>['class' => 'm-r-10']])
                                                !!}
                                            </div>
                                        </div>
                                    @empty
                                        <h4>@lang('corals-admin::labels.auth.no_notification')</h4>
                                    @endforelse
                                </div>
                                <div class="tab-pane" id="reset_password">
                                    <div class="row">
                                        <div class="col-md-4">
                                            {!! CoralsForm::password('password','User::attributes.user.password') !!}
                                            {!! CoralsForm::password('password_confirmation','User::attributes.user.password_confirmation') !!}

                                            @if(\TwoFactorAuth::isActive())
                                                {!! CoralsForm::checkbox('two_factor_auth_enabled','User::attributes.user.two_factor_auth_enabled',\TwoFactorAuth::isEnabled($user)) !!}

                                                @if(!empty(\TwoFactorAuth::getSupportedChannels()))
                                                    {!! CoralsForm::radio('channel','User::attributes.user.channel', false,\TwoFactorAuth::getSupportedChannels(),array_get($user->getTwoFactorAuthProviderOptions(),'channel', null)) !!}
                                                @endif
                                            @endif
                                        </div>
                                        <div class="col-md-6 text-center">
                                            <i class="fa fa-lock" style="color:#7777770f; font-size: 10em;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                {!! CoralsForm::formButtons(trans('corals-admin::labels.auth.save',['title' => $title_singular]),[],['href'=>url('dashboard')]) !!}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    @php \Actions::do_action('user_profile_tabs_content',user(),$active_tab) @endphp

                </div>
                <!-- /.tab-pane -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
    </div>
    <!-- /.row -->
    <!-- /.row -->
    <div class="modal fade modal-image" id="modal-image-crop" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i
                                class="icons-office-52"></i></button>
                    <h4 class="modal-title"><strong>@lang('corals-admin::labels.auth.change_image')</strong></h4>
                </div>
                <div class="modal-body">
                    <img width="100%" src="" id="image_cropper" alt="picture 1" class="img-responsive">
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="file col-md-6">
                            <div class="text-left">
    <span class="btn btn-info btn-file">
    @lang('corals-admin::labels.auth.browse_files')
        <input type="file" class="custom-file" id="cropper"
               onchange="document.getElementById('uploader').value = this.value;" required>

    </span>

                            </div>
                        </div>
                        <div class="col-md-6 pull-right m-b-10">
                            <button type="button" class="btn btn-primary rotate pull-right" data-method="rotate"
                                    data-option="-30">
                                <i class="fa fa-undo"></i></button>
                            <button type="button" class="btn btn-primary rotate pull-right m-r-10" data-method="rotate"
                                    data-option="30">
                                <i class="fa fa-repeat"></i></button>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary m-r-10 m-l-10"
                            id="Save">@lang('corals-admin::labels.auth.save',['title'=>''])</button>
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal">@lang('corals-admin::labels.auth.close')</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    {!! Html::script('assets/corals/plugins/cropper/cropper.js') !!}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/authy-form-helpers/2.3/form.authy.js"></script>

    <script type="text/javascript">
        $('#country-div').bind("DOMSubtreeModified", function () {
            $(".countries-input").addClass('form-control');
        });

        $(function () {
/////// Cropper Options set
            var $cropper = $('#image_cropper');
            var options = {
                aspectRatio: 1 / 1,
                minContainerWidth: 570,
                minContainerHeight: 350,
                minCropBoxWidth: 145,
                minCropBoxHeight: 145,
                rotatable: true,
                cropBoxResizable: true,
                crop: function (e) {
                    $("#cropped_value").val(JSON.stringify(e.detail));
                }
            };
///// Show cropper on existing Image
            $("body").on("click", "#image_source", function () {
                var src = $("#image_source").attr("src");
                src = src.replace("/thumb", "");
                $cropper.attr('src', src);
                $("#modal-image-crop").modal("show");
            });
///// Destroy Cropper on Model Hide
            $("#modal-image-crop").on("hide.bs.modal", function () {
                $cropper.cropper('destroy');
                $(".cropper-container").remove();

            });
/// Show Cropper on Model Show
            $("#modal-image-crop").on("show.bs.modal", function () {
                $cropper.cropper(options);
            });
///// Rotate Image
            $("body").on("click", "#modal-image-crop .rotate", function () {
                var degree = $(this).attr("data-option");
                $cropper.cropper('rotate', degree);
            });
///// Saving Image with Ajax Call
            $("body").on("click", "#Save", function () {
                var cropped_image = $cropper.cropper('getCroppedCanvas');
                var canvasURL = cropped_image.toDataURL('image/jpeg');
                $("#image_source").attr('src', canvasURL);
                $("input[name=profile_image]").val(canvasURL);

                $cropper.cropper('destroy');
                $("#modal-image-crop").modal("hide");
            });

////// When user upload image
            $(document).on("change", "#cropper", function () {
                var imagecheck = $(this).data('imagecheck'),
                    file = this.files[0],
                    imagefile = file.type,
                    _URL = window.URL || window.webkitURL;
                img = new Image();
                img.src = _URL.createObjectURL(file);
                img.onload = function () {
                    var match = ["image/jpeg", "image/png", "image/jpg"];
                    if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]))) {
                        alert('Please Select A valid Image File');
                        return false;
                    } else {
                        var reader = new FileReader();
                        reader.readAsDataURL(file);
                        reader.onloadend = function () { // set image data as background of div
                            $('#image_cropper').attr('src', this.result);
                            $cropper.cropper('destroy');
                            $cropper.cropper(options);
                        }
                    }
                }
            });
        });
    </script>

    <script type="text/javascript">
        function refresh_address(data) {
            $('#profile_addresses').html(data.address_list);
            $('#profile_addresses input').val("");
            $('#profile_addresses select').val("");
        }
    </script>
@endsection