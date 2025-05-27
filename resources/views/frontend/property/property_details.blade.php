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
                    <li><a href="#" onclick="window.print()"><i class="icon-37"></i></a></li>
                    <li><a href="#" onclick="shareProperty()"><i class="icon-38"></i></a></li>
                    <li>
                        <!-- Bouton pour ajouter/retirer des favoris -->
                        <a href="#" class="wishlist-btn" id="wishlistBtn" data-property-id="{{ $property->id }}">
                            <i class="icon-12" id="wishlistIcon"></i>
                        </a>
                    </li>
                    <li>
                        <!-- Bouton pour ajouter à la comparaison -->
                        <a href="#" class="add-to-compare" data-id="{{ $property->id }}">
                            <i class="fas fa-exchange-alt"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-8 col-md-12 col-sm-12 content-side">
                <div class="property-details-content">
                    <div class="carousel-inner">
                        <div class="single-item-carousel owl-carousel owl-theme owl-nav-none owl-dot-style-one">
                            <!-- Image principale -->
                            <figure class="image-box"><img src="{{ asset($property->property_thumbnail) }}" alt="{{ $property->property_name }}" style="width:100%; height:500px; object-fit:cover;"></figure>
                            
                            <!-- Images de la galerie -->
                            @foreach($property->propertyImages as $img)
                            <figure class="image-box"><img src="{{ asset($img->photo_name) }}" alt="{{ $property->property_name }} - Image {{ $loop->iteration }}" style="width:100%; height:500px; object-fit:cover;"></figure>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Miniatures des images (galerie en bas) -->
                    @if(count($property->propertyImages) > 0)
                    <div class="thumb-box clearfix mt-3">
                        <div class="row">
                            <!-- Miniature de l'image principale -->
                            <div class="col-lg-3 col-md-4 col-sm-6 col-6 thumb-item">
                                <img src="{{ asset($property->property_thumbnail) }}" alt="{{ $property->property_name }}" style="width:100%; height:100px; object-fit:cover; cursor:pointer; border-radius:5px;" onclick="showImage(0)">
                            </div>
                            
                            <!-- Miniatures des images de la galerie -->
                            @foreach($property->propertyImages as $key => $img)
                            <div class="col-lg-3 col-md-4 col-sm-6 col-6 thumb-item">
                                <img src="{{ asset($img->photo_name) }}" alt="{{ $property->property_name }} - Image {{ $loop->iteration }}" style="width:100%; height:100px; object-fit:cover; cursor:pointer; border-radius:5px;" onclick="showImage({{ $key + 1 }})">
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
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
                    
                    <!-- Section des avis -->
                    <div class="review-box content-widget">
                        <div class="title-box">
                            <h4>Avis et évaluations</h4>
                        </div>
                        <div class="review-inner">
                            <!-- Affichage des avis existants -->
                            @php
                                $reviews = App\Models\PropertyReview::where('property_id', $property->id)
                                            ->where('status', 'approved')
                                            ->with('user')
                                            ->latest()
                                            ->get();
                                
                                $reviewCount = $reviews->count();
                                $averageRating = $reviewCount > 0 ? $reviews->avg('rating') : 0;
                                $roundedRating = round($averageRating);
                            @endphp
                            
                            <div class="rating-summary clearfix mb-4">
                                <div class="overall-rating pull-left">
                                    <h2>{{ number_format($averageRating, 1) }} <span>/5</span></h2>
                                    <ul class="rating clearfix">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $roundedRating)
                                                <li><i class="icon-39"></i></li>
                                            @else
                                                <li><i class="icon-40"></i></li>
                                            @endif
                                        @endfor
                                    </ul>
                                    <span class="total-reviews">{{ $reviewCount }} avis</span>
                                </div>
                                <div class="rating-progress pull-right">
                                    @php
                                        $fiveStars = $reviewCount > 0 ? ($reviews->where('rating', 5)->count() / $reviewCount) * 100 : 0;
                                        $fourStars = $reviewCount > 0 ? ($reviews->where('rating', 4)->count() / $reviewCount) * 100 : 0;
                                        $threeStars = $reviewCount > 0 ? ($reviews->where('rating', 3)->count() / $reviewCount) * 100 : 0;
                                        $twoStars = $reviewCount > 0 ? ($reviews->where('rating', 2)->count() / $reviewCount) * 100 : 0;
                                        $oneStar = $reviewCount > 0 ? ($reviews->where('rating', 1)->count() / $reviewCount) * 100 : 0;
                                    @endphp
                                    <div class="progress-item">
                                        <span>5 étoiles</span>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: {{ $fiveStars }}%" aria-valuenow="{{ $fiveStars }}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <span>{{ $reviews->where('rating', 5)->count() }}</span>
                                    </div>
                                    <div class="progress-item">
                                        <span>4 étoiles</span>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: {{ $fourStars }}%" aria-valuenow="{{ $fourStars }}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <span>{{ $reviews->where('rating', 4)->count() }}</span>
                                    </div>
                                    <div class="progress-item">
                                        <span>3 étoiles</span>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: {{ $threeStars }}%" aria-valuenow="{{ $threeStars }}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <span>{{ $reviews->where('rating', 3)->count() }}</span>
                                    </div>
                                    <div class="progress-item">
                                        <span>2 étoiles</span>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: {{ $twoStars }}%" aria-valuenow="{{ $twoStars }}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <span>{{ $reviews->where('rating', 2)->count() }}</span>
                                    </div>
                                    <div class="progress-item">
                                        <span>1 étoile</span>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: {{ $oneStar }}%" aria-valuenow="{{ $oneStar }}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <span>{{ $reviews->where('rating', 1)->count() }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Liste des avis -->
                            <div class="review-list">
                                @if($reviewCount > 0)
                                    @foreach($reviews as $review)
                                    <div class="review-block">
                                        <div class="review-header clearfix">
                                            <div class="reviewer-info pull-left">
                                                <figure class="reviewer-thumb">
                                                    <img src="{{ !empty($review->user->photo) ? asset($review->user->photo) : url('upload/no_image.jpg') }}" alt="{{ $review->user->name }}">
                                                </figure>
                                                <div class="reviewer-name">
                                                    <h5>{{ $review->user->name }}</h5>
                                                    <span>{{ $review->created_at->format('d/m/Y') }}</span>
                                                </div>
                                            </div>
                                            <div class="rating-box pull-right">
                                                <ul class="rating clearfix">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $review->rating)
                                                            <li><i class="icon-39"></i></li>
                                                        @else
                                                            <li><i class="icon-40"></i></li>
                                                        @endif
                                                    @endfor
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="review-content">
                                            <p>{{ $review->comment }}</p>
                                        </div>
                                    </div>
                                    @endforeach
                                @else
                                    <div class="alert alert-info">
                                        <p>Aucun avis n'a encore été laissé pour cette propriété. Soyez le premier à donner votre avis !</p>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Formulaire pour laisser un avis -->
                            <div class="review-form mt-5">
                                <h4>Laisser un avis</h4>
                                
                                @auth
                                    @php
                                        $userReview = App\Models\PropertyReview::where('property_id', $property->id)
                                                        ->where('user_id', Auth::id())
                                                        ->first();
                                    @endphp
                                    
                                    <form action="{{ route('store.review') }}" method="post" class="mt-3">
                                        @csrf
                                        <input type="hidden" name="property_id" value="{{ $property->id }}">
                                        
                                        <div class="form-group mb-3">
                                            <label>Votre note</label>
                                            <div class="rating-input">
                                                <div class="rating-group">
                                                    <input type="radio" name="rating" value="1" id="rating-1" {{ $userReview && $userReview->rating == 1 ? 'checked' : '' }} required>
                                                    <label for="rating-1"><i class="icon-39"></i></label>
                                                    
                                                    <input type="radio" name="rating" value="2" id="rating-2" {{ $userReview && $userReview->rating == 2 ? 'checked' : '' }}>
                                                    <label for="rating-2"><i class="icon-39"></i></label>
                                                    
                                                    <input type="radio" name="rating" value="3" id="rating-3" {{ $userReview && $userReview->rating == 3 ? 'checked' : '' }}>
                                                    <label for="rating-3"><i class="icon-39"></i></label>
                                                    
                                                    <input type="radio" name="rating" value="4" id="rating-4" {{ $userReview && $userReview->rating == 4 ? 'checked' : '' }}>
                                                    <label for="rating-4"><i class="icon-39"></i></label>
                                                    
                                                    <input type="radio" name="rating" value="5" id="rating-5" {{ $userReview && $userReview->rating == 5 ? 'checked' : '' }}>
                                                    <label for="rating-5"><i class="icon-39"></i></label>
                                                </div>
                                            </div>
                                            @error('rating')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        
                                        <div class="form-group mb-3">
                                            <label>Votre commentaire</label>
                                            <textarea name="comment" class="form-control" rows="5" required>{{ $userReview ? $userReview->comment : '' }}</textarea>
                                            @error('comment')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        
                                        <div class="form-group">
                                            <button type="submit" class="theme-btn btn-one">{{ $userReview ? 'Mettre à jour mon avis' : 'Soumettre mon avis' }}</button>
                                        </div>
                                    </form>
                                @else
                                    <div class="alert alert-warning mt-3">
                                        <p>Vous devez être connecté pour laisser un avis. <a href="{{ route('login') }}" class="text-primary">Connectez-vous ici</a>.</p>
                                    </div>
                                @endauth
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
                        
                        @auth
                        <form action="{{ route('send.message') }}" method="post" class="default-form">
                            @csrf
                            <input type="hidden" name="property_id" value="{{ $property->id }}">
                            <input type="hidden" name="agent_id" value="{{ $property->agent_id }}">
                            
                            <div class="form-group">
                                <input type="text" name="name" value="{{ Auth::user()->name }}" disabled>
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" value="{{ Auth::user()->email }}" disabled>
                            </div>
                            <div class="form-group">
                                <input type="text" name="subject" placeholder="Sujet" required>
                                @error('subject')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <textarea name="message" placeholder="Message" required></textarea>
                                @error('message')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group message-btn">
                                <button type="submit" class="theme-btn btn-one">Envoyer le message</button>
                            </div>
                        </form>
                        @else
                        <div class="alert alert-warning">
                            <p>Vous devez être connecté pour contacter l'agent. <a href="{{ route('login') }}" class="text-primary">Connectez-vous ici</a>.</p>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Widget de prise de rendez-vous -->
                    <div class="form-widget sidebar-widget">
                        <div class="form-title">
                            <h4>Visiter cette propriété</h4>
                        </div>
                        <div class="text-center py-4">
                            <p>Planifiez une visite avec l'agent pour découvrir cette propriété.</p>
                            <a href="{{ route('book.appointment', $property->id) }}" class="theme-btn btn-one w-100">Prendre rendez-vous</a>
                        </div>
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

@section('scripts')
<script>
    // Fonction pour afficher une image spécifique dans le carrousel
    function showImage(index) {
        // Récupérer le carrousel
        var owl = $('.single-item-carousel');
        
        // Aller à l'image spécifiée
        owl.trigger('to.owl.carousel', [index, 300]);
    }
    
    // Fonction pour partager la propriété
    function shareProperty() {
        if (navigator.share) {
            navigator.share({
                title: "{{ $property->property_name }}",
                text: "Découvrez cette propriété sur Immobilus",
                url: window.location.href
            })
            .catch(error => console.log('Erreur de partage', error));
        } else {
            // Fallback pour les navigateurs qui ne supportent pas l'API Web Share
            alert("Copiez ce lien pour partager : " + window.location.href);
        }
        return false;
    }
    
    // Initialiser le carrousel et les fonctionnalités une fois que la page est chargée
    $(document).ready(function() {
        // Enregistrer la vue de cette propriété pour les recommandations
        $.ajax({
            url: "{{ route('track.property.view') }}",
            type: "POST",
            data: {
                property_id: {{ $property->id }},
                _token: "{{ csrf_token() }}"
            },
            dataType: "json"
        });
        
        // Vérifier si le carrousel est déjà initialisé
        if (!$('.single-item-carousel').hasClass('owl-loaded')) {
            // Initialiser le carrousel avec les options appropriées
            $('.single-item-carousel').owlCarousel({
                loop: true,
                margin: 0,
                nav: true,
                autoplay: true,
                autoplayTimeout: 5000,
                smartSpeed: 1000,
                navText: [ '<span class="fas fa-arrow-left"></span>', '<span class="fas fa-arrow-right"></span>' ],
                responsive: {
                    0: { items: 1 },
                    600: { items: 1 },
                    800: { items: 1 },
                    1024: { items: 1 },
                    1200: { items: 1 }
                }
            });
        }
        
        // Gérer le clic sur le bouton de favoris
        $('#wishlistBtn').on('click', function(e) {
            e.preventDefault();
            
            // Récupérer l'ID de la propriété
            var propertyId = $(this).data('property-id');
            
            // Envoyer la requête AJAX
            $.ajax({
                url: "{{ route('add.to.wishlist') }}",
                type: "POST",
                data: {
                    property_id: propertyId,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.status === 'success') {
                        // Afficher un message de succès
                        toastr.success(response.message);
                        
                        // Mettre à jour l'apparence du bouton
                        if (response.message.includes('ajoutée')) {
                            $('#wishlistIcon').css('color', '#ff5a5f');
                        } else {
                            $('#wishlistIcon').css('color', '');
                        }
                    } else {
                        // Rediriger vers la page de connexion si nécessaire
                        if (response.message.includes('connecter')) {
                            window.location.href = "{{ route('login') }}";
                        } else {
                            toastr.error(response.message);
                        }
                    }
                },
                error: function(xhr) {
                    // Gérer les erreurs
                    if (xhr.status === 401) {
                        // Rediriger vers la page de connexion si non authentifié
                        window.location.href = "{{ route('login') }}";
                    } else {
                        toastr.error('Une erreur est survenue. Veuillez réessayer.');
                    }
                }
            });
        });
        
        // Vérifier si la propriété est déjà dans les favoris
        @auth
        $.ajax({
            url: "{{ route('add.to.wishlist') }}",
            type: "POST",
            data: {
                property_id: "{{ $property->id }}",
                _token: "{{ csrf_token() }}",
                check_only: true
            },
            success: function(response) {
                if (response.in_wishlist) {
                    $('#wishlistIcon').css('color', '#ff5a5f');
                }
            }
        });
        @endauth
    });
</script>
@endsection
