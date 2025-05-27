@extends('frontend.frontend_dashboard')
@section('content')

<!-- page-title -->
<section class="page-title centred">
    <div class="container">
        <div class="content-box">
            <h1>{{ __('Newsletter') }}</h1>
            <ul class="bread-crumb clearfix">
                <li><a href="{{ route('homepage') }}">{{ __('Accueil') }}</a></li>
                <li>{{ __('Newsletter') }}</li>
            </ul>
        </div>
    </div>
</section>
<!-- page-title end -->

<!-- newsletter-section -->
<section class="contact-section sec-pad">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 col-md-12 col-sm-12 content-column">
                <div class="contact-form-area">
                    <div class="sec-title centred">
                        <h5>{{ __('Restez informé') }}</h5>
                        <h2>{{ __('Abonnez-vous à notre newsletter') }}</h2>
                    </div>
                    <div class="text centred mb-5">
                        <p>{{ __('Recevez nos dernières actualités immobilières, conseils d\'experts et offres exclusives directement dans votre boîte mail.') }}</p>
                    </div>
                    
                    @if(session('message'))
                    <div class="alert alert-{{ session('alert-type') }} alert-dismissible fade show" role="alert">
                        {{ session('message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    
                    <form method="post" action="{{ route('newsletter.store') }}" class="default-form">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                <input type="email" name="email" placeholder="{{ __('Votre adresse email') }}" required>
                                @error('email')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 form-group message-btn centred">
                                <button type="submit" class="theme-btn btn-one">{{ __('S\'abonner') }}</button>
                            </div>
                        </div>
                    </form>
                    
                    <div class="text centred mt-4">
                        <p class="small">{{ __('En vous abonnant, vous acceptez de recevoir nos newsletters et communications marketing. Vous pourrez vous désabonner à tout moment en cliquant sur le lien de désabonnement présent dans chaque email.') }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-5">
            <div class="col-lg-10 offset-lg-1 col-md-12 col-sm-12">
                <div class="sec-title">
                    <h3>{{ __('Pourquoi s\'abonner à notre newsletter ?') }}</h3>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-12 feature-block">
                        <div class="feature-block-one wow fadeInUp animated" data-wow-delay="00ms" data-wow-duration="1500ms">
                            <div class="inner-box">
                                <div class="icon-box"><i class="icon-1"></i></div>
                                <h4>{{ __('Actualités immobilières') }}</h4>
                                <p>{{ __('Restez informé des dernières tendances du marché immobilier et des évolutions du secteur.') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12 feature-block">
                        <div class="feature-block-one wow fadeInUp animated" data-wow-delay="300ms" data-wow-duration="1500ms">
                            <div class="inner-box">
                                <div class="icon-box"><i class="icon-2"></i></div>
                                <h4>{{ __('Conseils d\'experts') }}</h4>
                                <p>{{ __('Bénéficiez de conseils pratiques pour l\'achat, la vente ou la location de biens immobiliers.') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12 feature-block">
                        <div class="feature-block-one wow fadeInUp animated" data-wow-delay="600ms" data-wow-duration="1500ms">
                            <div class="inner-box">
                                <div class="icon-box"><i class="icon-3"></i></div>
                                <h4>{{ __('Offres exclusives') }}</h4>
                                <p>{{ __('Accédez en avant-première à nos nouvelles propriétés et offres spéciales réservées à nos abonnés.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- newsletter-section end -->

@endsection
