@extends('layouts.master')
@section('title', $title)
@section('css')
    {!! Html::style('assets/corals/plugins/cropper/cropper.css') !!}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/authy-form-helpers/2.3/flags.authy.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/authy-form-helpers/2.3/form.authy.css"/>
    <style>
        #image_source {
            cursor: pointer;
        }

        .tab-pane {
            padding: 10px;
        }
    </style>
@endsection
@section('content')

    <div class="profile-edit-container">
        <div class="profile-edit-container">
            <div class="profile-edit-header fl-wrap">
                <h4>@lang('corals-directory-basic::auth.profile')</h4>
            </div>
            <!-- statistic-container-->
            <div class="custom-form">
                {!! Form::model($user = user(), ['url' => url('profile'), 'method'=>'PUT','class'=>'ajax-form','files'=>true]) !!}

                <div class="col-md-6">
                    <!-- profile-edit-container-->


                    <label><i class="fa fa-user-o"></i></label>
                    {!! CoralsForm::text('name','User::attributes.user.name',true) !!}
                    <label><i class="fa fa-user-o"></i></label>
                    {!! CoralsForm::text('last_name','User::attributes.user.last_name',true) !!}
                    <label><i class="fa fa-envelope-o"></i> </label>
                    {!! CoralsForm::email('email','User::attributes.user.email',true) !!}
                    <label><i class="fa fa-phone"></i> </label>
                    {!! CoralsForm::text('phone_country_code','User::attributes.user.phone_country_code',false,null,['id'=>'authy-countries']) !!}
                    <label><i class="fa fa-phone"></i> </label>
                    {!! CoralsForm::text('phone_number','User::attributes.user.phone_number',false,null,['id'=>'authy-cellphone']) !!}
                    <label></label>
                    {!! CoralsForm::textarea('properties[about]', 'User::attributes.user.about' , false, null,[
                         'class'=>'limited-text',
                         'maxlength'=>250,
                         'help_text'=>'<span class="limit-counter">0</span>/250',
                     'rows'=>'4']) !!}
                </div>
                <div class="col-md-6">
                    <img id="image_source"
                         class="profile-user-img img-responsive img-circle"
                         style="width: 200px"
                         src="{{ user()->picture }}"
                         alt="User profile picture">
                    {{ Form::hidden('profile_image') }}
                    <small class="crop_update">@lang('corals-admin::labels.auth.click_pic_update')</small>
                    <label><i class="fa fa-map-marker"></i> </label>

                    <label><i class="fa fa-lock"></i></label>
                    {!! CoralsForm::password('password','User::attributes.user.password') !!}
                    <label><i class="fa fa-lock"></i></label>
                    {!! CoralsForm::password('password_confirmation','User::attributes.user.password_confirmation') !!}

                    @if(\TwoFactorAuth::isActive())
                        {!! CoralsForm::checkbox('two_factor_auth_enabled','User::attributes.user.two_factor_auth_enabled',\TwoFactorAuth::isEnabled($user)) !!}

                        @if(!empty(\TwoFactorAuth::getSupportedChannels()))
                            {!! CoralsForm::radio('channel','User::attributes.user.channel', false,\TwoFactorAuth::getSupportedChannels(),array_get($user->getTwoFactorAuthProviderOptions(),'channel', null)) !!}
                        @endif
                    @endif
                    {!! CoralsForm::text('job_title','User::attributes.user.job_title') !!}
                </div>
            </div>
            <!-- profile-edit-container end-->
            <!-- profile-edit-container-->
            <div class="profile-edit-container">
                <div class="custom-form">
                    {!! CoralsForm::formButtons(trans('corals-directory-basic::auth.save',['title' => $title_singular]),[],['href'=>url('dashboard')]) !!}
                </div>
            </div>
            <!-- profile-edit-container end-->
        </div>


        {!! Form::close() !!}

        <div class="modal fade modal-image" id="modal-image-crop" tabindex="-1" role="dialog"
             aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <strong>@lang('corals-directory-basic::auth.change_image')</strong>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <img width="100%" src="" id="image_cropper" alt="picture 1" class="img-responsive">
                        </div>

                        <div class="row actions my-3">
                            <div class="col-md-8 text-left">
                                                        <span class="btn btn-info btn-file ">@lang('corals-directory-basic::auth.browse_files')
                                                            <input type="file" class="custom-file m-t-30" id="cropper"
                                                                   required>
                        </span>

                            </div>
                            <div class="col-md-4 ">

                                <button type="button" class="btn btn-primary rotate" data-method="rotate"
                                        data-option="-30">
                                    <i class="fa fa-undo"></i></button>
                                <button type="button" class="btn btn-primary rotate" data-method="rotate"
                                        data-option="30">
                                    <i class="fa fa-repeat"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success m-r-10 m-l-10"
                                id="Save">@lang('corals-directory-basic::auth.save',['title'=>''])</button>
                        <button type="button" class="btn btn-danger"
                                data-dismiss="modal">@lang('corals-directory-basic::auth.close')</button>
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
                        minContainerWidth: 350,
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
