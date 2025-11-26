<section class="feature-section sec-pad bg-color-1">
    <div class="auto-container">
        <div class="sec-title centred">
            <h5>Propriétés</h5>
            <h2>Nos biens en vedette</h2>
            <p>Découvrez notre sélection de biens immobiliers exceptionnels, sélectionnés pour leur qualité <br />et leur emplacement privilégié.</p>
        </div>
        
        @if(count($featuredProperties) > 0)
        <!-- Propriétés en vedette -->
        <div class="properties-container">
            <div class="row">
                @foreach($featuredProperties as $property)
                <div class="col-lg-4 col-md-6 col-sm-12 property-item">
                    <div class="feature-block-one wow fadeInUp animated" data-wow-delay="00ms" data-wow-duration="1500ms">
                        <div class="inner-box">
                            <div class="image-box">
                                <figure class="image"><img src="{{ asset($property->property_thumbnail) }}" alt="{{ $property->property_name }}"></figure>
                                <div class="batch"><i class="icon-11"></i></div>
                                <span class="category">{{ $property->type->type_name }}</span>
                            </div>
                            <div class="lower-content">
                                <div class="author-info clearfix">
                                    <div class="author pull-left">
                                        @if(!empty($property->user->photo))
                                        <figure class="author-thumb"><img src="{{ asset($property->user->photo) }}" alt="{{ $property->user->name }}"></figure>
                                        @else
                                        <figure class="author-thumb"><img src="{{ asset('frontend/assets/images/feature/author-1.jpg') }}" alt="{{ $property->user->name }}"></figure>
                                        @endif
                                        <h6>{{ $property->user->name }}</h6>
                                    </div>
                                    <div class="buy-btn pull-right"><a href="{{ route('property.details', [$property->id, $property->property_slug]) }}">{{ $property->property_status }}</a></div>
                                </div>
                                <div class="title-text"><h4><a href="{{ route('property.details', [$property->id, $property->property_slug]) }}">{{ $property->property_name }}</a></h4></div>
                                <div class="price-box clearfix">
                                    <div class="price-info pull-left">
                                        <h6>À partir de</h6>
                                        <h4>{{ currency_gnf($property->lowest_price) }}</h4>
                                    </div>
                                    <ul class="other-option pull-right clearfix">
                                        <li><a href="javascript:void(0)" onclick="addToFavorite({{ $property->id }})" data-favorite="{{ $property->id }}" class="favorite-btn"><i class="icon-12"></i></a></li>
                                        <li><a href="{{ route('property.details', [$property->id, $property->property_slug]) }}"><i class="icon-13"></i></a></li>
                                    </ul>
                                </div>
                                <p>{{ Str::limit($property->short_description, 60) }}</p>
                                <ul class="more-details clearfix">
                                    <li><i class="icon-14"></i>{{ $property->bedrooms }} Chambres</li>
                                    <li><i class="icon-15"></i>{{ $property->bathrooms }} Salles de bain</li>
                                    <li><i class="icon-16"></i>{{ $property->property_size }} m²</li>
                                </ul>
                                <div class="btn-box"><a href="{{ route('property.details', [$property->id, $property->property_slug]) }}" class="theme-btn btn-two">Voir détails</a></div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="row">
                <div class="col-12 text-center">
                    <p>Aucune propriété en vedette disponible pour le moment.</p>
                </div>
            </div>
            @endif
        </div>
        <div class="more-btn centred mt-4"><a href="{{ route('property.list') }}" class="theme-btn btn-one">Voir toutes les propriétés</a></div>
    </div>
</section>

<style>
    /* Styles pour les cartes de propriétés */
    .properties-container {
        margin-bottom: 30px;
    }
    
    .property-item {
        margin-bottom: 30px;
    }
    
    .property-item .feature-block-one {
        height: 100%;
        display: flex;
        flex-direction: column;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        border-radius: 10px;
        overflow: hidden;
    }
    
    .property-item .feature-block-one:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.12);
    }
    
    .property-item .inner-box {
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .property-item .image-box img {
        height: 250px;
        width: 100%;
        object-fit: cover;
    }
    
    .property-item .lower-content {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        padding: 20px;
    }
    
    .property-item .btn-box {
        margin-top: auto;
    }
    
    /* Garantir que toutes les cartes d'une même ligne ont la même hauteur */
    .row {
        display: flex;
        flex-wrap: wrap;
    }
    
    /* Responsive */
    @media (max-width: 991px) {
        .property-item {
            margin-bottom: 20px;
        }
    }
    
    /* Favorite button styling */
    .favorite-btn {
        position: relative;
        transition: all 0.3s ease;
    }
    
    .favorite-btn.active i,
    .favorite-btn:hover i {
        color: #ff5a5f;
    }
    
    .favorite-btn.active i::before {
        content: '\f004'; /* Solid heart icon */
        font-weight: 900;
    }
    
    .favorite-btn::after {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        background: rgba(255, 90, 95, 0.2);
        border-radius: 50%;
        left: 0;
        top: 0;
        transform: scale(0);
        transition: transform 0.3s ease;
    }
    
    .favorite-btn:active::after {
        transform: scale(1.5);
        opacity: 0;
    }
</style>