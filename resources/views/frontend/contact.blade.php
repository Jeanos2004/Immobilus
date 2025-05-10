@extends('frontend.frontend_dashboard')
@section('content')

<!-- page-title -->
<section class="page-title centred">
    <div class="title-outer">
        <div class="content-box">
            <h1>{{ __('messages.contact') }}</h1>
            <ul class="bread-crumb clearfix">
                <li><a href="{{ route('homepage') }}">{{ __('messages.home') }}</a></li>
                <li>{{ __('messages.contact') }}</li>
            </ul>
        </div>
    </div>
</section>
<!-- page-title end -->

<!-- contact-info-section -->
<section class="contact-info-section sec-pad">
    <div class="auto-container">
        <div class="sec-title centred">
            <h5>{{ __('messages.contact_us') }}</h5>
            <h2>{{ __('messages.get_in_touch') }}</h2>
        </div>
        <div class="row clearfix">
            <div class="col-lg-4 col-md-6 col-sm-12 info-block">
                <div class="info-block-one">
                    <div class="inner-box">
                        <div class="icon-box"><i class="icon-32"></i></div>
                        <h4>{{ __('messages.email_address') }}</h4>
                        <p><a href="mailto:info@immobilus.com">info@immobilus.com</a></p>
                        <p><a href="mailto:support@immobilus.com">support@immobilus.com</a></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 info-block">
                <div class="info-block-one">
                    <div class="inner-box">
                        <div class="icon-box"><i class="icon-33"></i></div>
                        <h4>{{ __('messages.phone_number') }}</h4>
                        <p><a href="tel:+33123456789">+33 1 23 45 67 89</a></p>
                        <p><a href="tel:+33987654321">+33 9 87 65 43 21</a></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 info-block">
                <div class="info-block-one">
                    <div class="inner-box">
                        <div class="icon-box"><i class="icon-34"></i></div>
                        <h4>{{ __('messages.office_address') }}</h4>
                        <p>123 Avenue des Champs-Élysées, 75008 Paris, France</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- contact-info-section end -->

<!-- contact-section -->
<section class="contact-section bg-color-1">
    <div class="auto-container">
        <div class="row align-items-center clearfix">
            <div class="col-lg-6 col-md-12 col-sm-12 content-column">
                <div class="content-box">
                    <div class="sec-title">
                        <h5>{{ __('messages.contact') }}</h5>
                        <h2>{{ __('messages.contact_us_title') }}</h2>
                    </div>
                    <div class="form-inner">
                        <form method="post" action="{{ route('contact.submit') }}" id="contact-form" class="default-form">
                            @csrf
                            <div class="row clearfix">
                                <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                    <input type="text" name="name" placeholder="{{ __('messages.your_name') }}" required>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                    <input type="email" name="email" placeholder="{{ __('messages.your_email') }}" required>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                    <input type="text" name="phone" placeholder="{{ __('messages.phone') }}" required>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                    <input type="text" name="subject" placeholder="{{ __('messages.subject') }}" required>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                    <textarea name="message" placeholder="{{ __('messages.message') }}"></textarea>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 form-group message-btn">
                                    <button class="theme-btn btn-one" type="submit" name="submit-form">{{ __('messages.send_message') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 map-column">
                <div class="map-inner">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2624.142047342337!2d2.2957656156742766!3d48.86970170866946!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e66fc4a7c36b15%3A0x57fccb06b68c6c9!2sAvenue%20des%20Champs-%C3%89lys%C3%A9es%2C%20Paris%2C%20France!5e0!3m2!1sen!2sus!4v1623264855105!5m2!1sen!2sus" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- contact-section end -->

@endsection
