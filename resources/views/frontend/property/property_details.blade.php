@extends('frontend.frontend_dashboard')
@section('content')

<!--Page Title-->
<section class="page-title-two bg-color-1 centred">
    <div class="pattern-layer">
        <div class="pattern-1" style="background-image: url({{ asset('frontend/assets/images/shape/shape-9.png') }});"></div>
        <div class="pattern-2" style="background-image: url({{ asset('frontend/assets/images/shape/shape-10.png') }});"></div>
    </div>
    <div class="auto-container">
        <div class="content-box clearfix">
            <h1>{{ $property->property_name }}</h1>
            <ul class="bread-crumb clearfix">
                <li><a href="/">Accueil</a></li>
                <li><a href="{{ route('property.list') }}">Propriétés</a></li>
                <li>Détails</li>
            </ul>
        </div>
    </div>
</section>
<!--End Page Title-->

<!-- property-details -->
<section class="property-details property-details-one">
    <div class="auto-container">
        <div class="top-details clearfix">
            <div class="left-column pull-left clearfix">
                <h3>{{ $property->property_name }}</h3>
                <div class="author-info clearfix">
                    <div class="author-box pull-left">
                        <figure class="author-thumb"><img src="{{ !empty($property->user->photo) ? asset($property->user->photo) : url('upload/no_image.jpg') }}" alt=""></figure>
                        <h6>{{ $property->user->name }}</h6>
                    </div>
                    <ul class="rating clearfix pull-left">
                        <li><i class="icon-39"></i></li>
                        <li><i class="icon-39"></i></li>
                        <li><i class="icon-39"></i></li>
                        <li><i class="icon-39"></i></li>
                        <li><i class="icon-40"></i></li>
                    </ul>
                </div>
            </div>
            <div class="right-column pull-right clearfix">
                <div class="price-inner clearfix">
                    <ul class="category clearfix pull-left">
                        <li><a href="#">{{ $property->type->type_name }}</a></li>
                        <li><a href="#">{{ $property->property_status }}</a></li>
                    </ul>
                    <div class="price-box pull-right">
                        <h3>{{ number_format($property->lowest_price, 0, ',', ' ') }}€</h3>
                    </div>
                </div>
                <ul class="other-option pull-right clearfix">
                    <li><a href="#"><i class="icon-37"></i></a></li>
                    <li><a href="#"><i class="icon-38"></i></a></li>
                    <li><a href="#"><i class="icon-12"></i></a></li>
                    <li><a href="#"><i class="icon-13"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-8 col-md-12 col-sm-12 content-side">
                <div class="property-details-content">
                    <div class="carousel-inner">
                        <div class="single-item-carousel owl-carousel owl-theme owl-dots-none">
                            <figure class="image-box"><img src="{{ asset($property->property_thumbnail) }}" alt=""></figure>
                        </div>
                    </div>
                    <div class="discription-box content-widget">
                        <div class="title-box">
                            <h4>Description</h4>
                        </div>
                        <div class="text">
                            <p>{!! $property->long_description !!}</p>
                        </div>
                    </div>
                    <div class="details-box content-widget">
                        <div class="title-box">
                            <h4>Détails de la propriété</h4>
                        </div>
                        <ul class="list clearfix">
                            <li>ID de la propriété: <span>{{ $property->property_code }}</span></li>
                            <li>Type de propriété: <span>{{ $property->type->type_name }}</span></li>
                            <li>Statut: <span>{{ $property->property_status }}</span></li>
                            <li>Superficie: <span>{{ $property->property_size }} m²</span></li>
                            <li>Chambres: <span>{{ $property->bedrooms }}</span></li>
                            <li>Salles de bain: <span>{{ $property->bathrooms }}</span></li>
                            <li>Garage: <span>{{ $property->garage }}</span></li>
                            <li>Taille du garage: <span>{{ $property->garage_size }}</span></li>
                            <li>Année de construction: <span>2022</span></li>
                            <li>Adresse: <span>{{ $property->address }}</span></li>
                            <li>Ville: <span>{{ $property->city }}</span></li>
                            <li>État/Région: <span>{{ $property->state }}</span></li>
                            <li>Code postal: <span>{{ $property->postal_code }}</span></li>
                            <li>Quartier: <span>{{ $property->neighborhood }}</span></li>
                        </ul>
                    </div>
                    <div class="amenities-box content-widget">
                        <div class="title-box">
                            <h4>Équipements</h4>
                        </div>
                        <ul class="list clearfix">
                            @foreach($property->amenities as $amenity)
                            <li>{{ $amenity->amenities_name }}</li>
                            @endforeach
                        </ul>
                    </div>
                    
                    @if($property->video)
                    <div class="video-box content-widget">
                        <div class="title-box">
                            <h4>Vidéo</h4>
                        </div>
                        <div class="video-inner">
                            <div class="video-holder" style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden;">
                                <iframe style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" src="{{ $property->property_video }}" frameborder="0" allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    @if($property->latitude && $property->longitude)
                    <div class="location-box content-widget">
                        <div class="title-box">
                            <h4>Localisation</h4>
                        </div>
                        <ul class="info clearfix">
                            <li><span>Adresse:</span> {{ $property->address }}</li>
                            <li><span>État/Région:</span> {{ $property->state }}</li>
                            <li><span>Quartier:</span> {{ $property->neighborhood }}</li>
                            <li><span>Code postal:</span> {{ $property->postal_code }}</li>
                            <li><span>Ville:</span> {{ $property->city }}</li>
                        </ul>
                        <div class="google-map-area">
                            <div 
                                class="google-map" 
                                id="contact-google-map" 
                                data-map-lat="{{ $property->latitude }}" 
                                data-map-lng="{{ $property->longitude }}" 
                                data-icon-path="{{ asset('frontend/assets/images/icons/map-marker.png') }}"  
                                data-map-title="Brooklyn, New York, United Kingdom" 
                                style="height: 400px;">
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <div class="nearby-box content-widget">
                        <div class="title-box">
                            <h4>À proximité</h4>
                        </div>
                        <div class="inner-box">
                            <div class="single-item">
                                <div class="icon-box"><i class="fas fa-book-reader"></i></div>
                                <div class="inner">
                                    <h5>Écoles et universités</h5>
                                    <div class="box clearfix">
                                        <div class="text pull-left">
                                            <h6>École primaire</h6>
                                            <span>500m de distance</span>
                                        </div>
                                        <ul class="rating pull-right clearfix">
                                            <li><i class="icon-39"></i></li>
                                            <li><i class="icon-39"></i></li>
                                            <li><i class="icon-39"></i></li>
                                            <li><i class="icon-39"></i></li>
                                            <li><i class="icon-40"></i></li>
                                        </ul>
                                    </div>
                                    <div class="box clearfix">
                                        <div class="text pull-left">
                                            <h6>Collège</h6>
                                            <span>1.5km de distance</span>
                                        </div>
                                        <ul class="rating pull-right clearfix">
                                            <li><i class="icon-39"></i></li>
                                            <li><i class="icon-39"></i></li>
                                            <li><i class="icon-39"></i></li>
                                            <li><i class="icon-39"></i></li>
                                            <li><i class="icon-40"></i></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="single-item">
                                <div class="icon-box"><i class="fas fa-shopping-basket"></i></div>
                                <div class="inner">
                                    <h5>Commerces</h5>
                                    <div class="box clearfix">
                                        <div class="text pull-left">
                                            <h6>Supermarché</h6>
                                            <span>300m de distance</span>
                                        </div>
                                        <ul class="rating pull-right clearfix">
                                            <li><i class="icon-39"></i></li>
                                            <li><i class="icon-39"></i></li>
                                            <li><i class="icon-39"></i></li>
                                            <li><i class="icon-39"></i></li>
                                            <li><i class="icon-39"></i></li>
                                        </ul>
                                    </div>
                                    <div class="box clearfix">
                                        <div class="text pull-left">
                                            <h6>Centre commercial</h6>
                                            <span>2km de distance</span>
                                        </div>
                                        <ul class="rating pull-right clearfix">
                                            <li><i class="icon-39"></i></li>
                                            <li><i class="icon-39"></i></li>
                                            <li><i class="icon-39"></i></li>
                                            <li><i class="icon-39"></i></li>
                                            <li><i class="icon-40"></i></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="single-item">
                                <div class="icon-box"><i class="fas fa-transport"></i></div>
                                <div class="inner">
                                    <h5>Transports</h5>
                                    <div class="box clearfix">
                                        <div class="text pull-left">
                                            <h6>Arrêt de bus</h6>
                                            <span>100m de distance</span>
                                        </div>
                                        <ul class="rating pull-right clearfix">
                                            <li><i class="icon-39"></i></li>
                                            <li><i class="icon-39"></i></li>
                                            <li><i class="icon-39"></i></li>
                                            <li><i class="icon-39"></i></li>
                                            <li><i class="icon-39"></i></li>
                                        </ul>
                                    </div>
                                    <div class="box clearfix">
                                        <div class="text pull-left">
                                            <h6>Station de métro</h6>
                                            <span>800m de distance</span>
                                        </div>
                                        <ul class="rating pull-right clearfix">
                                            <li><i class="icon-39"></i></li>
                                            <li><i class="icon-39"></i></li>
                                            <li><i class="icon-39"></i></li>
                                            <li><i class="icon-39"></i></li>
                                            <li><i class="icon-40"></i></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="similar-properties content-widget">
                        <div class="title-box">
                            <h4>Propriétés similaires</h4>
                        </div>
                        <div class="row clearfix">
                            @foreach($similarProperties as $item)
                            <div class="col-lg-6 col-md-6 col-sm-12 feature-block">
                                <div class="feature-block-one">
                                    <div class="inner-box">
                                        <div class="image-box">
                                            <figure class="image"><img src="{{ asset($item->property_thumbnail) }}" alt="" style="width:370px; height:250px;"></figure>
                                            <div class="batch"><i class="icon-11"></i></div>
                                            @if($item->featured == 1)
                                            <span class="category">En vedette</span>
                                            @endif
                                        </div>
                                        <div class="lower-content">
                                            <div class="title-text"><h4><a href="{{ route('property.details', [$item->id, $item->property_slug]) }}">{{ $item->property_name }}</a></h4></div>
                                            <div class="price-box clearfix">
                                                <div class="price-info">
                                                    <h6>Prix</h6>
                                                    <h4>{{ number_format($item->lowest_price, 0, ',', ' ') }}€</h4>
                                                </div>
                                            </div>
                                            <p>{{ $item->short_description }}</p>
                                            <ul class="more-details clearfix">
                                                <li><i class="icon-14"></i>{{ $item->bedrooms }} Chambres</li>
                                                <li><i class="icon-15"></i>{{ $item->bathrooms }} Salles de bain</li>
                                                <li><i class="icon-16"></i>{{ $item->property_size }} m²</li>
                                            </ul>
                                            <div class="btn-box"><a href="{{ route('property.details', [$item->id, $item->property_slug]) }}" class="theme-btn btn-two">Voir les détails</a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12 sidebar-side">
                <div class="property-sidebar default-sidebar">
                    <div class="author-widget sidebar-widget">
                        <div class="author-box">
                            <figure class="author-thumb"><img src="{{ !empty($property->user->photo) ? asset($property->user->photo) : url('upload/no_image.jpg') }}" alt=""></figure>
                            <div class="inner">
                                <h4>{{ $property->user->name }}</h4>
                                <ul class="info clearfix">
                                    <li><i class="fas fa-phone-volume"></i><a href="tel:{{ $property->user->phone }}">{{ $property->user->phone }}</a></li>
                                    <li><i class="fas fa-envelope"></i><a href="mailto:{{ $property->user->email }}">{{ $property->user->email }}</a></li>
                                </ul>
                                <div class="btn-box"><a href="{{ route('agent.properties', $property->user->id) }}">Voir toutes les propriétés</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-widget sidebar-widget">
                        <div class="form-title">
                            <h4>Contacter l'agent</h4>
                        </div>
                        <form action="#" method="post" class="default-form">
                            <div class="form-group">
                                <input type="text" name="name" placeholder="Votre nom" required="">
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" placeholder="Votre email" required="">
                            </div>
                            <div class="form-group">
                                <input type="text" name="phone" placeholder="Téléphone" required="">
                            </div>
                            <div class="form-group">
                                <textarea name="message" placeholder="Message"></textarea>
                            </div>
                            <div class="form-group message-btn">
                                <button type="submit" class="theme-btn btn-one">Envoyer le message</button>
                            </div>
                        </form>
                    </div>
                    <div class="calculator-widget sidebar-widget">
                        <div class="calculator-title">
                            <h4>Calculateur de prêt</h4>
                        </div>
                        <form action="#" method="post" class="default-form">
                            <div class="form-group">
                                <i class="fas fa-dollar-sign"></i>
                                <input type="text" name="price" placeholder="Prix de la propriété" value="{{ $property->lowest_price }}">
                            </div>
                            <div class="form-group">
                                <i class="fas fa-dollar-sign"></i>
                                <input type="text" name="down_payment" placeholder="Apport initial">
                            </div>
                            <div class="form-group">
                                <i class="fas fa-percent"></i>
                                <input type="text" name="interest_rate" placeholder="Taux d'intérêt">
                            </div>
                            <div class="form-group">
                                <i class="far fa-calendar-alt"></i>
                                <input type="text" name="loan_term" placeholder="Durée du prêt">
                            </div>
                            <div class="form-group">
                                <div class="select-box">
                                    <select class="wide">
                                       <option data-display="Mensuel">Mensuel</option>
                                       <option value="1">Annuel</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group message-btn">
                                <button type="submit" class="theme-btn btn-one">Calculer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- property-details end -->

@endsection
