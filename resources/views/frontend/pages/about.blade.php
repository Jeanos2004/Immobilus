@extends('frontend.frontend_dashboard')
@section('content')

<!-- page-title -->
<section class="page-title centred">
    <div class="container">
        <div class="content-box">
            <h1>{{ __('À propos de nous') }}</h1>
            <ul class="bread-crumb clearfix">
                <li><a href="{{ route('homepage') }}">{{ __('Accueil') }}</a></li>
                <li>{{ __('À propos') }}</li>
            </ul>
        </div>
    </div>
</section>
<!-- page-title end -->

<!-- about-section -->
<section class="about-section sec-pad">
    <div class="container">
        <div class="row clearfix">
            <div class="col-lg-6 col-md-12 col-sm-12 content-column">
                <div class="content-box">
                    <div class="sec-title">
                        <h5>{{ __('À propos de nous') }}</h5>
                        <h2>{{ __('Immobilus, votre partenaire immobilier de confiance') }}</h2>
                    </div>
                    <div class="text">
                        <p>{{ __('Bienvenue chez Immobilus, votre partenaire immobilier de confiance. Nous sommes une agence immobilière passionnée par l\'excellence du service et dédiée à vous aider à trouver la propriété parfaite ou à vendre votre bien au meilleur prix.') }}</p>
                        <p>{{ __('Fondée avec la vision de transformer l\'expérience immobilière traditionnelle, notre équipe d\'agents expérimentés combine expertise locale, technologie de pointe et approche personnalisée pour vous offrir un service immobilier sans égal.') }}</p>
                    </div>
                    <ul class="list-item clearfix">
                        <li>{{ __('Expertise locale approfondie') }}</li>
                        <li>{{ __('Service client exceptionnel') }}</li>
                        <li>{{ __('Solutions immobilières innovantes') }}</li>
                        <li>{{ __('Transparence et intégrité') }}</li>
                    </ul>
                    <div class="btn-box">
                        <a href="{{ route('contact') }}" class="theme-btn btn-one">{{ __('Contactez-nous') }}</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 image-column">
                <div class="image-box">
                    <figure class="image"><img src="{{ asset('frontend/assets/images/about/about-1.jpg') }}" alt=""></figure>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- about-section end -->

<!-- feature-section -->
<section class="feature-section sec-pad bg-color-1">
    <div class="container">
        <div class="sec-title centred">
            <h5>{{ __('Caractéristiques') }}</h5>
            <h2>{{ __('Pourquoi nous choisir') }}</h2>
            <p>{{ __('Découvrez ce qui fait d\'Immobilus le choix idéal pour tous vos besoins immobiliers') }}</p>
        </div>
        <div class="row clearfix">
            <div class="col-lg-4 col-md-6 col-sm-12 feature-block">
                <div class="feature-block-one wow fadeInUp animated" data-wow-delay="00ms" data-wow-duration="1500ms">
                    <div class="inner-box">
                        <div class="icon-box"><i class="icon-1"></i></div>
                        <h4>{{ __('Excellente réputation') }}</h4>
                        <p>{{ __('Notre réputation d\'excellence et d\'intégrité nous précède dans le secteur immobilier.') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 feature-block">
                <div class="feature-block-one wow fadeInUp animated" data-wow-delay="300ms" data-wow-duration="1500ms">
                    <div class="inner-box">
                        <div class="icon-box"><i class="icon-2"></i></div>
                        <h4>{{ __('Meilleurs agents') }}</h4>
                        <p>{{ __('Notre équipe est composée d\'agents immobiliers expérimentés et passionnés par leur métier.') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 feature-block">
                <div class="feature-block-one wow fadeInUp animated" data-wow-delay="600ms" data-wow-duration="1500ms">
                    <div class="inner-box">
                        <div class="icon-box"><i class="icon-3"></i></div>
                        <h4>{{ __('Service personnalisé') }}</h4>
                        <p>{{ __('Nous offrons un service sur mesure adapté à vos besoins spécifiques et à vos préférences.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- feature-section end -->

<!-- statistics-section -->
<section class="funfact-section centred">
    <div class="container">
        <div class="inner-container">
            <div class="row clearfix">
                <div class="col-lg-3 col-md-6 col-sm-12 counter-block">
                    <div class="counter-block-one">
                        <div class="count-outer count-box">
                            <span class="count-text" data-speed="1500" data-stop="{{ $stats['properties'] }}">0</span>
                        </div>
                        <p>{{ __('Propriétés') }}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 counter-block">
                    <div class="counter-block-one">
                        <div class="count-outer count-box">
                            <span class="count-text" data-speed="1500" data-stop="{{ $stats['agents'] }}">0</span>
                        </div>
                        <p>{{ __('Agents') }}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 counter-block">
                    <div class="counter-block-one">
                        <div class="count-outer count-box">
                            <span class="count-text" data-speed="1500" data-stop="{{ $stats['clients'] }}">0</span>
                        </div>
                        <p>{{ __('Clients') }}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 counter-block">
                    <div class="counter-block-one">
                        <div class="count-outer count-box">
                            <span class="count-text" data-speed="1500" data-stop="{{ $stats['cities'] }}">0</span>
                        </div>
                        <p>{{ __('Villes') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- statistics-section end -->

<!-- team-section -->
<section class="team-section sec-pad">
    <div class="container">
        <div class="sec-title centred">
            <h5>{{ __('Nos agents') }}</h5>
            <h2>{{ __('Rencontrez nos experts') }}</h2>
            <p>{{ __('Notre équipe d\'agents immobiliers expérimentés est prête à vous aider') }}</p>
        </div>
        <div class="row clearfix">
            @foreach($agents as $agent)
            <div class="col-lg-3 col-md-6 col-sm-12 team-block">
                <div class="team-block-one wow fadeInUp animated" data-wow-delay="00ms" data-wow-duration="1500ms">
                    <div class="inner-box">
                        <figure class="image-box">
                            <img src="{{ !empty($agent->photo) ? url('upload/agent_images/'.$agent->photo) : url('upload/no_image.jpg') }}" alt="{{ $agent->name }}">
                        </figure>
                        <div class="lower-content">
                            <div class="inner">
                                <h4><a href="{{ route('agents.details', $agent->id) }}">{{ $agent->name }}</a></h4>
                                <span class="designation">{{ __('Agent Immobilier') }}</span>
                                <ul class="social-links clearfix">
                                    @if($agent->facebook)
                                    <li><a href="{{ $agent->facebook }}"><i class="fab fa-facebook-f"></i></a></li>
                                    @endif
                                    @if($agent->twitter)
                                    <li><a href="{{ $agent->twitter }}"><i class="fab fa-twitter"></i></a></li>
                                    @endif
                                    @if($agent->instagram)
                                    <li><a href="{{ $agent->instagram }}"><i class="fab fa-instagram"></i></a></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="more-btn centred">
            <a href="{{ route('agents.list') }}" class="theme-btn btn-one">{{ __('Voir tous les agents') }}</a>
        </div>
    </div>
</section>
<!-- team-section end -->

<!-- testimonial-section -->
<section class="testimonial-section bg-color-1 sec-pad">
    <div class="container">
        <div class="sec-title centred">
            <h5>{{ __('Témoignages') }}</h5>
            <h2>{{ __('Ce que disent nos clients') }}</h2>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 content-column">
                <div class="testimonial-content">
                    <div class="testimonial-carousel owl-carousel owl-theme owl-nav-none">
                        @foreach($testimonials as $testimonial)
                        <div class="testimonial-block-one">
                            <div class="inner-box">
                                <figure class="thumb-box">
                                    <img src="{{ !empty($testimonial->user->photo) ? url('upload/user_images/'.$testimonial->user->photo) : url('upload/no_image.jpg') }}" alt="">
                                </figure>
                                <div class="text">
                                    <p>{{ $testimonial->message }}</p>
                                </div>
                                <div class="author-info">
                                    <h4>{{ $testimonial->user->name }}</h4>
                                    <span class="designation">{{ __('Client') }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- testimonial-section end -->

@endsection
