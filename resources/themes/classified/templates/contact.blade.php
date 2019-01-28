@extends('layouts.theme')

@section('hero_area')
    @include('partials.page_header')
@endsection

@section('editable_content')
    <!-- Map Section Start -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <iframe src="{{ \Settings::get('google_map_url', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3387.331591494841!2d35.19981536504809!3d31.897586781246385!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x518201279a8595!2sLeaders!5e0!3m2!1sen!2s!4v1512481232226') }}"
                            height="450" frameborder="0" style="border:0;width: 100%;" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </section>
    <!-- Map Section End -->

    @if(!empty($item->rendered))
        <section class="section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12">
                        {!! $item->rendered !!}
                    </div>
                </div>
            </div>
        </section>
    @endif

    <section id="content">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-9">
                    <div id="form_status" class=" alert alert-success "
                         style="display: none;font-weight:bold;text-align:center"></div>
                    <form id="main-contact-form" class="contact-form" name="contact-form" method="post"
                          action="{{ url('contact/email') }}">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group required-field ">
                                    <label>
                                        @lang('corals-classified-master::email.contact_form.name')
                                    </label>
                                    <input type="text" class="form-control" id="name" name="name"
                                           placeholder="@lang('corals-classified-master::email.contact_form.name')">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group required-field ">
                                    <label>
                                        @lang('corals-classified-master::email.contact_form.email')
                                    </label>
                                    <input type="email" class="form-control" id="email" name="email"
                                           placeholder="@lang('corals-classified-master::email.contact_form.email')">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>@lang('corals-classified-master::email.contact_form.phone')</label>
                                    <input type="text" class="form-control" id="msg_phone" name="phone"
                                           placeholder="@lang('corals-classified-master::email.contact_form.phone')">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>@lang('corals-classified-master::email.contact_form.company_name')</label>
                                    <input type="text" class="form-control" id="company_name"
                                           name="company"
                                           placeholder="@lang('corals-classified-master::email.contact_form.company_name')">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group required-field ">
                                    <label>
                                        @lang('corals-classified-master::email.contact_form.subject')
                                    </label>
                                    <input type="text" class="form-control" id="subject" name="subject"
                                           placeholder="@lang('corals-classified-master::email.contact_form.subject')"
                                           required="required">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group required-field ">
                                    <label>
                                        @lang('corals-classified-master::email.contact_form.message')
                                    </label>
                                    <textarea class="form-control"
                                              placeholder="@lang('corals-classified-master::email.contact_form.message')"
                                              name="message" rows="10" required="required"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" id="submit"
                                    class="btn btn-common">
                                @lang('corals-classified-master::email.contact_form.submit_message')
                            </button>
                            <div class="clearfix"></div>
                        </div>
                    </form>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">
                    <h2 class="contact-title">
                        Get In Touch
                    </h2>
                    <div class="information">
                        <p>Lorem Ipsum Is simply dummy text of the printing and typesetting Industry.
                            Lorem Ipsum has been the Industry's</p>
                        <div class="contact-datails">
                            <div class="icon">
                                <i class="lni-map-marker icon-radius"></i>
                            </div>
                            <div class="info">
                                <h3>Address</h3>
                                <span class="detail">Level 13, 2 Ellzabeth St, <br> Lorem Ipsum Is simply dummy text</span>
                            </div>
                        </div>
                        <div class="contact-datails">
                            <div class="icon">
                                <i class="lni-pointer icon-radius"></i>
                            </div>
                            <div class="info">
                                <h3>Have any Questions?</h3>
                                <span class="detail">support@corals.io</span>
                                <br/>
                                <br/>
                                <h3>Call Us & Hire us</h3>
                                <span class="detail">WhatsApp: +970599593301</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Contact Us Section  -->
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
                    scrollTop: form_status.offset().top - 50
                }, 1000);
                form_status.html(data.message).addClass(data.class).delay(3000).fadeOut();
                $('#main-contact-form').find("input[type=text], textarea").val("");
            });
        });
    </script>
@endsection



