@extends('layouts.master')

@section('editable_content')
    {!! $item->rendered !!}
    <section class="contact-section section">
        <div class="container">
            <h2 class="title text-center">@lang('corals-neptune::labels.template.start_project')</h2>
            <p class="intro text-center">
                @lang('corals-neptune::labels.template.paragraph')
            </p>
            <div id="form_status" class=" alert alert-success "
                 style="display: none;font-weight:bold;text-align:center"></div>
            <form id="main-contact-form" class="saas-contact" name="contact-form" method="post"
                  action="{{ url('contact/email') }}">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" name="name" class="form-control" required="required"
                                   placeholder="Name *">
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" class="form-control" required="required"
                                   placeholder="Email *">
                        </div>
                        <div class="form-group">
                            <input type="text" name="phone" class="form-control" placeholder="Phone">
                        </div>
                        <div class="form-group">
                            <input type="text" name="company" class="form-control" placeholder="Company Name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" name="subject" class="form-control" required="required"
                                   placeholder="Subject *">
                        </div>
                        <div class="form-group">
                                <textarea name="message" id="message" required="required" class="form-control"
                                          rows="6" placeholder="Message *"></textarea>
                        </div>
                        <div class="form-group text-right">
                            <button type="submit" name="submit" class="btn btn-primary btn-rounded">
                                @lang('corals-neptune::labels.template.send_message')
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div><!--//container-->
    </section><!--//contact-section-->
    {{--<div class="contact-us-info">--}}
    {{--<div class="container">--}}
    {{--<!--Google Maps-->--}}
    {{--<div class="row">--}}
    {{--<div class="col-md-12">--}}
    {{--<iframe src=""--}}
    {{--width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="row">--}}
    {{--<div class="col-md-12">--}}

    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="row">--}}
    {{--<div class="col-lg-8 message">--}}
    {{--<div id="form_status" class=" alert alert-success "--}}
    {{--style="display: none;font-weight:bold;text-align:center"></div>--}}
    {{--<form id="main-contact-form" class="saas-contact" name="contact-form" method="post"--}}
    {{--action="{{ url('contact/email') }}">--}}
    {{--{{ csrf_field() }}--}}
    {{--<div class="form-group">--}}
    {{--<input type="text" name="name" class="form-control" required="required"--}}
    {{--placeholder="Name *">--}}
    {{--</div>--}}
    {{--<div class="form-group">--}}
    {{--<input type="email" name="email" class="form-control" required="required"--}}
    {{--placeholder="Email *">--}}
    {{--</div>--}}
    {{--<div class="form-group">--}}
    {{--<input type="text" name="phone" class="form-control" placeholder="Phone">--}}
    {{--</div>--}}
    {{--<div class="form-group">--}}
    {{--<input type="text" name="company" class="form-control" placeholder="Company Name">--}}
    {{--</div>--}}
    {{--<div class="form-group">--}}
    {{--<input type="text" name="subject" class="form-control" required="required"--}}
    {{--placeholder="Subject *">--}}
    {{--</div>--}}
    {{--<div class="form-group">--}}
    {{--<textarea name="message" id="message" required="required" class="form-control"--}}
    {{--rows="6" placeholder="Message *"></textarea>--}}
    {{--</div>--}}
    {{--<div class="form-group text-right">--}}
    {{--<button type="submit" name="submit" class="btn btn-primary btn-rounded">Send Message--}}
    {{--</button>--}}
    {{--</div>--}}
    {{--</form>--}}
    {{--</div>--}}
    {{--<div class="col-lg-4 contact">--}}
    {{--<div class="address">--}}
    {{--<h3>Our Address</h3>--}}
    {{--<p>--}}
    {{--The Old Road Willington, <br/>--}}
    {{--7 Kings Road, <br/>--}}
    {{--Southshore, 64890--}}
    {{--</p>--}}
    {{--</div>--}}
    {{--<div class="phone">--}}
    {{--<h3>By Phone</h3>--}}
    {{--<p>--}}
    {{--1-800-346-3344--}}
    {{--</p>--}}
    {{--</div>--}}
    {{--<div class="online-support">--}}
    {{--<strong>Looking for online support?</strong>--}}
    {{--<p>--}}
    {{--Talk to us now with our online chat--}}
    {{--</p>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    <!-- ******Map Section****** -->
    <section class="map-section section">
        <div class="gmap-wrapper">
            <!--//Ref: https://support.google.com/maps/answer/144361?co=GENIE.Platform%3DDesktop&hl=en -->
            <iframe src="{{ \Settings::get('google_map_url', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3387.331591494841!2d35.19981536504809!3d31.897586781246385!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x518201279a8595!2sLeaders!5e0!3m2!1sen!2s!4v1512481232226') }}"
                    width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
        </div><!--//gmap-wrapper-->
    </section><!--//map-section-->
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