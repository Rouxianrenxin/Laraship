@extends('layouts.master')

@section('title', $item->title)

@section('content')
    @include('CMS::cms_internal.partials.page_header',['content' => $item->rendered])

    <div class='row'>
        <div class="col-md-12">
            <div id="form_status" class=" alert alert-success "
                 style="display: none;font-weight:bold;text-align:center"></div>
            <form id="main-contact-form" class="" name="contact-form" method="post"
                  action="{{ url('contact/email') }}">
                {{ csrf_field() }}
                <div class='row'>
                    <div class="col-md-4 col-md-offset-2">
                        <div class="form-group">
                            <input type="text" name="name" class="form-control" required="required"
                                   placeholder="@lang('CMS::labels.cms_internal.contact_form.name')">
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" class="form-control" required="required"
                                   placeholder="@lang('CMS::labels.cms_internal.contact_form.email')">
                        </div>
                        <div class="form-group">
                            <input type="text" name="phone" class="form-control"
                                   placeholder="@lang('CMS::labels.cms_internal.contact_form.phone')">
                        </div>
                        <div class="form-group">
                            <input type="text" name="company" class="form-control"
                                   placeholder="@lang('CMS::labels.cms_internal.contact_form.company')">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="text" name="subject" class="form-control" required="required"
                                   placeholder="@lang('CMS::labels.cms_internal.contact_form.subject')">
                        </div>
                        <div class="form-group">
                                <textarea name="message" id="message" required="required" class="form-control"
                                          rows="6"
                                          placeholder="@lang('CMS::labels.cms_internal.contact_form.message')"></textarea>
                        </div>
                        <div class="form-group text-right">
                            <button type="submit" name="submit" class="btn btn-primary btn-rounded">
                                @lang('CMS::labels.cms_internal.contact_form.submit')
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--Google Maps-->
    <div class="row">
        <div class="col-md-12">
            <iframe src="{{ \Settings::get('google_map_url', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3387.331591494841!2d35.19981536504809!3d31.897586781246385!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x518201279a8595!2sLeaders!5e0!3m2!1sen!2s!4v1512481232226') }}"
                    width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
        </div>
    </div>
@stop

@section('js')
    <script type="text/javascript">

        // Contact form
        var form = $('#main-contact-form');

        form.submit(function (event) {
            event.preventDefault();
            var form_status = $('#form_status');
            form_status.removeClass('alert-success')
            form_status.removeClass('alert-warning')
            $.ajax({
                url: $(this).attr('action'),
                type: "POST",
                data: $(this).serialize(),
                beforeSend: function () {
                    form_status.html('<p><i class="fa fa-spinner fa-spin"></i> Sending Email ...</p>').fadeIn();
                }
            }).done(function (data) {
                $('html, body').animate({
                    scrollTop: form_status.offset().top - 20
                }, 1000);
                form_status.html(data.message).addClass(data.class).delay(3000).fadeOut();
                $('#main-contact-form').find("input[type=text], textarea").val("");
            });
        });
    </script>
@endsection