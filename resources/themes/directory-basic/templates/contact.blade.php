@extends('layouts.theme')

@section('editable_content')
   @include('partials.page_header')
    <div class="content">
        <section id="sec1">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="list-single-main-item fl-wrap">
                            <div class="list-single-main-item-title fl-wrap">
                                <h3>Contact <span>Details </span></h3>
                            </div>
                            <div class="list-author-widget-contacts">
                                <ul>
                                    <li><span><i class="fa fa-phone"></i> Phone :</span> <a href="#">{{ \Settings::get('contact_mobile','+970599593301') }}</a>
                                    </li>
                                    <li><span><i class="fa fa-envelope-o"></i> Mail :</span> <a href="#">{{ \Settings::get('contact_form_email','support@corals.io') }}</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="list-widget-social">
                                <ul class="social justify-content-center">          <!-- Social Media Links -->
                                    @foreach(\Settings::get('social_links',[]) as $key=>$link)
                                        <li><a href="{{ $link }}" target="_blank"><i class="fa fa-{{ $key }}"></i></a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="list-single-main-wrapper fl-wrap">
                            <div class="list-single-main-item-title fl-wrap">
                                <h3>Our Location</h3>
                            </div>
                            <div class="map-container">
                                <iframe src="{{ \Settings::get('google_map_url', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3387.331591494841!2d35.19981536504809!3d31.897586781246385!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x518201279a8595!2sLeaders!5e0!3m2!1sen!2s!4v1512481232226') }}"
                                        width="597" height="253" frameborder="0" style="border:0"
                                        allowfullscreen></iframe>
                            </div>
                            <div class="list-single-main-item-title fl-wrap">
                                <h3>Get In Touch</h3>
                            </div>
                            <div id="contact-form">
                                {!! $item->rendered !!}
                                <div id="form_status" class=" alert alert-success "
                                     style="display: none;font-weight:bold;text-align:center"></div>
                                <form id="main-contact-form" class="custom-form" method="post" action="{{ url('contact/email') }}" name="contact-form">
                                    {{ csrf_field() }}
                                    <fieldset>
                                        <label>@lang('corals-directory-basic::labels.template.contact.name')</label>
                                        <label><i class="fa fa-user-o"></i></label>
                                        <input type="text" name="name" id="name" value="" required="required">
                                        <div class="clearfix"></div>
                                        <label>@lang('corals-directory-basic::labels.template.contact.email')</label>
                                        <label><i class="fa fa-envelope-o"></i> </label>
                                        <input type="text" name="email" id="email" value="" required="required">
                                        <div class="clearfix"></div>
                                        <label>@lang('corals-directory-basic::labels.template.contact.phone')</label>
                                        <label><i class="fa fa-phone"></i> </label>
                                        <input type="text" name="phone" id="phone" value="" required="required">
                                        <label>@lang('corals-directory-basic::labels.template.contact.company_name')</label>
                                        <label><i class="fa fa-home"></i></label>
                                        <input type="text" name="company" class="form-control form-control-rounded" required="required">
                                        <label>@lang('corals-directory-basic::labels.template.contact.subject')</label>
                                        <input type="text" name="subject" class="form-control form-control-rounded" required="required">
                                        <label>@lang('corals-directory-basic::labels.template.contact.message')</label>
                                        <textarea name="message" id="message" required="required"
                                                  class="form-control form-control-rounded"
                                                  rows="10"></textarea>
                                    </fieldset>
                                    <button class="btn  big-btn  color-bg flat-btn" id="submit" type="submit"
                                            required="required">
                                        @lang('corals-directory-basic::labels.template.contact.submit_message')
                                        <i class="fa fa-angle-right"></i></button>
                                </form>
                            </div>
                            <!-- contact form  end-->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- section end -->
        <div class="limit-box fl-wrap"></div>
        <!--section -->
        <section class="gradient-bg">
            <div class="cirle-bg">
                <div class="bg" data-bg="{{ Theme::url('/images/bg/circle.png') }}"></div>
            </div>
            <div class="container">
                <div class="join-wrap fl-wrap">
                    <div class="row">
                        <div class="col-md-8">
                            <h3>Join our online community</h3>
                            <p>Grow your marketing and be happy with your online business</p>
                        </div>
                        <div class="col-md-4"><a href="#" class="join-wrap-btn modal-open">Sign Up <i
                                        class="fa fa-sign-in"></i></a></div>
                    </div>
                </div>
            </div>
        </section>
        <!-- section end -->
    </div>

@stop

<!-- contentend -->
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