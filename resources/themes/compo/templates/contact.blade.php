@extends('layouts.master')

@section('editable_content')

    <section id="contact-page" class="mt-5">
        <div class="container">
            <div>
                {!! $item->rendered !!}
            </div>
            <div id="form_status" class=" alert alert-success "
                 style="display: none;font-weight:bold;text-align:center"></div>
            <div class="row contact-wrap">
                <div class="col-lg-5 mt-20">
                    <h3 class="heading">Contact <span class="text-primary">Us</span></h3>
                    <p>Not sure where to start? Visit our <a href="https://www.laraship.com/" target="_blank">help
                            center</a> to get
                        answers to your queries.
                    </p>
                    <br>
                    <div class="bg-light p-20">
                        <address class="nom">
                            <span>first Floor,<br/> Abraj Al-Wataniya Building,<br/> Palestine</span>
                        </address>
                    </div>
                    <br>
                    <div class="bg-light p-20">
                        <h5 class="heading">Contacts</h5>
                        <p class="nom">Call us : {{ \Settings::get('contact_mobile','+970599593301') }}</p>
                        <p class="nom">Email us : {{ \Settings::get('contact_form_email','support@corals.io') }}</p>
                    </div>
                    <br>
                    <div class="bg-light p-20">
                        <h5 class="heading">Social Connect</h5>
                        <ul class="social nom">
                            @foreach(\Settings::get('social_links',[]) as $key=>$link)
                                <li><a href="{{ $link }}" target="_blank"><i class="fa fa-{{ $key }}"></i></a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-lg-7 mt-20">
                    <form id="main-contact-form" class="contact-form" name="contact-form" method="post"
                          action="{{ url('contact/email') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label>@lang('corals-compo::labels.template.contact.name')</label>
                            <input id="contact-name" type="text" name="name" class="form-control" required="required">
                        </div>
                        <div class="form-group">
                            <label>@lang('corals-compo::labels.template.contact.email')</label>
                            <input type="email" name="email" class="form-control" required="required">
                        </div>
                        <div class="form-group">
                            <label>@lang('corals-compo::labels.template.contact.phone')</label>
                            <input type="text" name="phone" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>@lang('corals-compo::labels.template.contact.company_name')</label>
                            <input type="text" name="company" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>@lang('corals-compo::labels.template.contact.subject')</label>
                            <input type="text" name="subject" class="form-control" required="required">
                        </div>
                        <div class="form-group">
                            <label>@lang('corals-compo::labels.template.contact.message')</label>
                            <textarea name="message" id="message" required="required" class="form-control"
                                      rows="8"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" name="submit" class="btn btn-primary btn-lg" required="required">
                                @lang('corals-compo::labels.template.contact.submit_message')
                            </button>
                        </div>
                    </form>
                </div>
            </div><!--/.row-->
        </div><!--/.container-->
    </section><!--/#contact-page-->
    <div class="container mt-100 mb-100">
        <div class="row">
            <div class="col-lg-12">
                <div class="map">
                    <iframe src="{{ \Settings::get('google_map_url', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3387.331591494841!2d35.19981536504809!3d31.897586781246385!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x518201279a8595!2sLeaders!5e0!3m2!1sen!2s!4v1512481232226') }}"
                            class="gmap" id="gmap" style="height:550px" data-lat="51.508103" data-long="-0.074911"
                            data-info-win="<h5 class='bold'>Educomp London Campus</h5><p>45th Floor,<br>Newzek Estate Building, <br>United Kingdom</p>"></iframe>
                </div>
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