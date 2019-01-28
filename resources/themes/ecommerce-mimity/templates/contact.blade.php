@extends('layouts.master')


@section('editable_content')
    <div class="row">
        <div class="col-sm-6 mb-3 mb-sm-0">
            <div class="img-thumbnail">
                <div class="embed-responsive embed-map">
                    <iframe src="{{ \Settings::get('google_map_url', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3387.331591494841!2d35.19981536504809!3d31.897586781246385!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x518201279a8595!2sLeaders!5e0!3m2!1sen!2s!4v1512481232226') }}"
                            width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            {!! $item->rendered !!}
            <h3>CONTACT US</h3>
            <div id="form_status" class=" alert alert-success "
                 style="display: none;font-weight:bold;text-align:center"></div>
            <form id="main-contact-form" class="mt-3" name="contact-form" method="post"
                  action="{{ url('contact/email') }}">
                {{ csrf_field() }}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <div class="media">
                            <span><i class="fa fa-map-marker fa-fw text-info"></i></span>
                            <div class="media-body ml-1">
                                <div>767 Fifth Avenue</div>
                                <div>New York</div>
                                <div>NY 10153</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <div class="media mb-3 mb-md-0">
                            <span><i class="fa fa-phone fa-fw text-info"></i></span>
                            <div class="media-body ml-1">212 123 456 789</div>
                        </div>
                        <div class="media">
                            <span><i class="fa fa-envelope fa-fw text-info"></i></span>
                            <div class="media-body ml-1">support@example.com</div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <input type="text" name="name" required="required" class="form-control"
                           placeholder="@lang('corals-ecommerce-mimity::labels.template.contact.name')">
                </div>
                <div class="form-group">
                    <input type="email" name="email" required="required" class="form-control"
                           placeholder="@lang('corals-ecommerce-mimity::labels.template.contact.email')">
                </div>
                <div class="form-group">
                    <input type="text" name="phone" class="form-control"
                           placeholder="@lang('corals-ecommerce-mimity::labels.template.contact.phone')">
                </div>
                <div class="form-group">
                    <input type="text" name="company" class="form-control"
                           placeholder="@lang('corals-ecommerce-mimity::labels.template.contact.company_name')">
                </div>
                <div class="form-group">
                    <input type="text" name="subject" class="form-control form-control"
                           placeholder="@lang('corals-ecommerce-mimity::labels.template.contact.subject')"
                           required="required">
                </div>
                <div class="form-group">
                    <textarea class="form-control" name="message" id="message" required="required" rows="3"
                              placeholder="@lang('corals-ecommerce-mimity::labels.template.contact.message')"></textarea>
                </div>
                <button type="submit" class="btn btn-info" name="submit" required="required">
                    @lang('corals-ecommerce-mimity::labels.template.contact.submit_message')
                </button>
            </form>
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