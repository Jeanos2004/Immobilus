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
            <h1>{{ $propertyType->type_name }}</h1>
            <ul class="bread-crumb clearfix">
                <li><a href="/">{{ __('messages.home') }}</a></li>
                <li><a href="{{ route('property.list') }}">{{ __('messages.properties') }}</a></li>
                <li>{{ $propertyType->type_name }}</li>
            </ul>
        </div>
    </div>
</section>
<!--End Page Title-->

<!-- property-page-section -->
<section class="property-page-section property-list">
    <div class="auto-container">
        <div class="row clearfix">
            <div class="col-lg-4 col-md-12 col-sm-12 sidebar-side">
                <div class="default-sidebar property-sidebar">
                    <div class="filter-widget sidebar-widget">
                        <div class="widget-title">
                            <h5>Filtrer les propriétés</h5>
                        </div>
                        <form action="{{ route('property.search') }}" method="GET" class="search-form">
                            <div class="widget-content">
                                <div class="select-box">
                                    <label>Statut</label>
                                    <select name="status" class="wide">
                                        <option value="">Tous</option>
                                        <option value="à vendre">À vendre</option>
                                        <option value="à louer">À louer</option>
                                    </select>
                                </div>
                                <div class="select-box">
                                    <label>Type de propriété</label>
                                    <select name="ptype_id" class="wide">
                                        <option value="">Tous les types</option>
                                        @foreach($propertyTypes as $type)
                                        <option value="{{ $type->id }}" {{ $type->id == $propertyType->id ? 'selected' : '' }}>{{ $type->type_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="select-box">
                                    <label>Fourchette de prix</label>
                                    <select name="price_range" class="wide">
                                        <option value="">Tous les prix</option>
                                        <option value="0-100000">0€ - 100,000€</option>
                                        <option value="100000-200000">100,000€ - 200,000€</option>
                                        <option value="200000-300000">200,000€ - 300,000€</option>
                                        <option value="300000-400000">300,000€ - 400,000€</option>
                                        <option value="400000-500000">400,000€ - 500,000€</option>
                                        <option value="500000-1000000">500,000€ - 1,000,000€</option>
                                        <option value="1000000-0">Plus de 1,000,000€</option>
                                    </select>
                                </div>
                                <div class="select-box">
                                    <label>Chambres</label>
                                    <select name="bedrooms" class="wide">
                                        <option value="">Toutes</option>
                                        <option value="1">1 chambre</option>
                                        <option value="2">2 chambres</option>
                                        <option value="3">3 chambres</option>
                                        <option value="4">4 chambres</option>
                                        <option value="5">5 chambres ou plus</option>
                                    </select>
                                </div>
                                <div class="select-box">
                                    <label>Salles de bain</label>
                                    <select name="bathrooms" class="wide">
                                        <option value="">Toutes</option>
                                        <option value="1">1 salle de bain</option>
                                        <option value="2">2 salles de bain</option>
                                        <option value="3">3 salles de bain</option>
                                        <option value="4">4 salles de bain ou plus</option>
                                    </select>
                                </div>
                                <div class="filter-btn">
                                    <button type="submit" class="theme-btn btn-one">Rechercher</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="category-widget sidebar-widget">
                        <div class="widget-title">
                            <h5>Types de propriétés</h5>
                        </div>
                        <ul class="category-list clearfix">
                            @foreach($propertyTypes as $type)
                            @php
                                $count = \App\Models\Property::where('ptype_id', $type->id)
                                    ->where('status', 1)
                                    ->count();
                            @endphp
                            <li><a href="{{ route('property.type', $type->id) }}" class="{{ $type->id == $propertyType->id ? 'current' : '' }}">{{ $type->type_name }} <span>({{ $count }})</span></a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-12 col-sm-12 content-side">
                <div class="property-content-side">
                    <div class="item-shorting clearfix">
                        <div class="left-column pull-left">
                            <h5>Résultats : <span>{{ $properties->total() }} propriétés trouvées</span></h5>
                        </div>
                        <div class="right-column pull-right clearfix">
                            <div class="short-box clearfix">
                                <div class="select-box">
                                    <select class="wide">
                                        <option data-display="Trier par défaut">Trier par défaut</option>
                                        <option value="1">Trier par prix (croissant)</option>
                                        <option value="2">Trier par prix (décroissant)</option>
                                        <option value="3">Trier par date (récent)</option>
                                        <option value="4">Trier par date (ancien)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="short-menu clearfix">
                                <button class="list-view on"><i class="icon-35"></i></button>
                                <button class="grid-view"><i class="icon-36"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="wrapper list">
                        @if(count($properties) > 0)
                            @foreach($properties as $property)
                            <div class="deals-list-content list-item">
                                <div class="deals-block-one">
                                    <div class="inner-box">
                                        <div class="image-box">
                                            <figure class="image"><img src="{{ asset($property->property_thumbnail) }}" alt="{{ $property->property_name }}"></figure>
                                            <div class="batch"><i class="icon-11"></i></div>
                                            <span class="category">{{ $property->type->type_name }}</span>
                                        </div>
                                        <div class="lower-content">
                                            <div class="title-text"><h4><a href="{{ route('property.details', [$property->id, $property->property_slug]) }}">{{ $property->property_name }}</a></h4></div>
                                            <div class="price-box clearfix">
                                                <div class="price-info pull-left">
                                                    <h6>À partir de</h6>
                                                    <h4>{{ number_format($property->lowest_price, 0, ',', ' ') }} €</h4>
                                                </div>
                                                <div class="author-box pull-right">
                                                    @if(!empty($property->user->photo))
                                                    <figure class="author-thumb">
                                                        <img src="{{ asset($property->user->photo) }}" alt="{{ $property->user->name }}">
                                                        <span>{{ $property->user->name }}</span>
                                                    </figure>
                                                    @else
                                                    <figure class="author-thumb">
                                                        <img src="{{ asset('frontend/assets/images/feature/author-1.jpg') }}" alt="{{ $property->user->name }}">
                                                        <span>{{ $property->user->name }}</span>
                                                    </figure>
                                                    @endif
                                                </div>
                                            </div>
                                            <p>{{ Str::limit($property->short_description, 100) }}</p>
                                            <ul class="more-details clearfix">
                                                <li><i class="icon-14"></i>{{ $property->bedrooms }} Chambres</li>
                                                <li><i class="icon-15"></i>{{ $property->bathrooms }} Salles de bain</li>
                                                <li><i class="icon-16"></i>{{ $property->property_size }} m²</li>
                                            </ul>
                                            <div class="other-info-box clearfix">
                                                <div class="btn-box pull-left"><a href="{{ route('property.details', [$property->id, $property->property_slug]) }}" class="theme-btn btn-two">Voir détails</a></div>
                                                <ul class="other-option pull-right clearfix">
                                                    <li><a href="javascript:void(0)" onclick="addToFavorite({{ $property->id }})" data-favorite="{{ $property->id }}" class="favorite-btn"><i class="icon-12"></i></a></li>
                                                    <li><a href="{{ route('property.details', [$property->id, $property->property_slug]) }}"><i class="icon-13"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            <div class="pagination-wrapper">
                                {{ $properties->links('vendor.pagination.custom') }}
                            </div>
                        @else
                            <div class="no-results">
                                <h3>Aucune propriété trouvée pour ce type</h3>
                                <p>Essayez de modifier vos critères de recherche ou consultez toutes nos propriétés.</p>
                                <div class="btn-box mt-4">
                                    <a href="{{ route('property.list') }}" class="theme-btn btn-one">Voir toutes les propriétés</a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- property-page-section end -->

<style>
    /* Styles pour la page des propriétés par type */
    .category-list li a.current {
        color: #2dbe6c;
        font-weight: bold;
    }
    
    .no-results {
        text-align: center;
        padding: 50px 0;
    }
    
    .no-results h3 {
        margin-bottom: 15px;
        color: #2dbe6c;
    }
    
    .no-results p {
        margin-bottom: 20px;
        color: #777;
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

@endsection
