@extends('frontend.frontend_dashboard')
@section('content')

<!-- page-title -->
<section class="page-title centred">
    <div class="container">
        <div class="content-box">
            <h1>{{ __('Détail de la photo') }}</h1>
            <ul class="bread-crumb clearfix">
                <li><a href="{{ route('homepage') }}">{{ __('Accueil') }}</a></li>
                <li><a href="{{ route('gallery') }}">{{ __('Galerie') }}</a></li>
                <li>{{ __('Détail') }}</li>
            </ul>
        </div>
    </div>
</section>
<!-- page-title end -->

<!-- image-details-section -->
<section class="property-details-section sec-pad">
    <div class="container">
        <div class="row clearfix">
            <div class="col-lg-8 col-md-12 col-sm-12 content-side">
                <div class="property-details-content">
                    <div class="image-box">
                        <figure class="image">
                            <img src="{{ asset($image->photo_name) }}" alt="{{ $image->property->property_name }}" style="width:100%;">
                        </figure>
                    </div>
                    <div class="details-box content-widget">
                        <div class="title-box">
                            <h4>{{ __('Informations sur la propriété') }}</h4>
                        </div>
                        <div class="text">
                            <h3>{{ $image->property->property_name }}</h3>
                            <p>{{ $image->property->short_description }}</p>
                        </div>
                        <ul class="list clearfix">
                            <li>{{ __('Type de propriété') }}: <span>{{ $image->property->type->type_name }}</span></li>
                            <li>{{ __('Statut') }}: <span>{{ $image->property->property_status }}</span></li>
                            <li>{{ __('Emplacement') }}: <span>{{ $image->property->city }}, {{ $image->property->state }}</span></li>
                            <li>{{ __('Superficie') }}: <span>{{ $image->property->property_size }} m²</span></li>
                            <li>{{ __('Chambres') }}: <span>{{ $image->property->bedrooms }}</span></li>
                            <li>{{ __('Salles de bain') }}: <span>{{ $image->property->bathrooms }}</span></li>
                            <li>{{ __('Prix') }}: <span>{{ number_format($image->property->lowest_price, 0, ',', ' ') }} €</span></li>
                        </ul>
                        <div class="btn-box">
                            <a href="{{ route('property.details', [$image->property->id, $image->property->property_slug]) }}" class="theme-btn btn-one">{{ __('Voir les détails de la propriété') }}</a>
                        </div>
                    </div>
                    
                    @if(count($relatedImages) > 0)
                    <div class="similar-properties content-widget">
                        <div class="title-box">
                            <h4>{{ __('Autres photos de cette propriété') }}</h4>
                        </div>
                        <div class="row clearfix">
                            @foreach($relatedImages as $relatedImage)
                            <div class="col-lg-4 col-md-6 col-sm-12 feature-block">
                                <div class="feature-block-one">
                                    <div class="inner-box">
                                        <div class="image-box">
                                            <figure class="image">
                                                <img src="{{ asset($relatedImage->photo_name) }}" alt="{{ $image->property->property_name }}">
                                            </figure>
                                            <div class="view-btn">
                                                <a href="{{ route('gallery.image', $relatedImage->id) }}"><i class="icon-22"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12 sidebar-side">
                <div class="property-sidebar default-sidebar">
                    <div class="author-widget sidebar-widget">
                        <div class="author-box">
                            <figure class="author-thumb">
                                <img src="{{ !empty($image->property->user->photo) ? asset($image->property->user->photo) : url('upload/no_image.jpg') }}" alt="{{ $image->property->user->name }}">
                            </figure>
                            <div class="inner">
                                <h4>{{ $image->property->user->name }}</h4>
                                <span>{{ __('Agent immobilier') }}</span>
                                <ul class="info clearfix">
                                    <li><i class="fas fa-phone"></i><a href="tel:{{ $image->property->user->phone }}">{{ $image->property->user->phone }}</a></li>
                                    <li><i class="fas fa-envelope"></i><a href="mailto:{{ $image->property->user->email }}">{{ $image->property->user->email }}</a></li>
                                </ul>
                                <div class="btn-box">
                                    <a href="{{ route('agents.details', $image->property->agent_id) }}">{{ __('Voir le profil') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="share-widget sidebar-widget">
                        <div class="widget-title">
                            <h4>{{ __('Partager') }}</h4>
                        </div>
                        <div class="social-links">
                            <ul class="clearfix">
                                <li><a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('gallery.image', $image->id)) }}" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="https://twitter.com/intent/tweet?url={{ urlencode(route('gallery.image', $image->id)) }}&text={{ urlencode($image->property->property_name) }}" target="_blank"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('gallery.image', $image->id)) }}&title={{ urlencode($image->property->property_name) }}" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
                                <li><a href="https://pinterest.com/pin/create/button/?url={{ urlencode(route('gallery.image', $image->id)) }}&media={{ urlencode(asset($image->photo_name)) }}&description={{ urlencode($image->property->property_name) }}" target="_blank"><i class="fab fa-pinterest-p"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- image-details-section end -->

@endsection
