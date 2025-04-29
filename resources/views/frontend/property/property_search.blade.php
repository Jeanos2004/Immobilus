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
            <h1>Résultats de recherche</h1>
            <ul class="bread-crumb clearfix">
                <li><a href="/">Accueil</a></li>
                <li>Recherche de propriétés</li>
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
                            <h5>Affiner votre recherche</h5>
                        </div>
                        <form action="{{ route('property.search') }}" method="GET" class="search-form">
                            <div class="widget-content">
                                <div class="select-box">
                                    <label>Statut</label>
                                    <select name="status" class="wide">
                                        <option value="">Tous</option>
                                        <option value="à vendre" {{ $request->status == 'à vendre' ? 'selected' : '' }}>À vendre</option>
                                        <option value="à louer" {{ $request->status == 'à louer' ? 'selected' : '' }}>À louer</option>
                                    </select>
                                </div>
                                <div class="select-box">
                                    <label>Type de propriété</label>
                                    <select name="ptype_id" class="wide">
                                        <option value="">Tous les types</option>
                                        @foreach($propertyTypes as $type)
                                        <option value="{{ $type->id }}" {{ $request->ptype_id == $type->id ? 'selected' : '' }}>{{ $type->type_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="select-box">
                                    <label>Fourchette de prix</label>
                                    <select name="price_range" class="wide">
                                        <option value="">Tous les prix</option>
                                        <option value="100000-300000" {{ $request->price_range == '100000-300000' ? 'selected' : '' }}>100 000€ - 300 000€</option>
                                        <option value="300000-500000" {{ $request->price_range == '300000-500000' ? 'selected' : '' }}>300 000€ - 500 000€</option>
                                        <option value="500000-800000" {{ $request->price_range == '500000-800000' ? 'selected' : '' }}>500 000€ - 800 000€</option>
                                        <option value="800000-1000000" {{ $request->price_range == '800000-1000000' ? 'selected' : '' }}>800 000€ - 1 000 000€</option>
                                        <option value="1000000-0" {{ $request->price_range == '1000000-0' ? 'selected' : '' }}>Plus de 1 000 000€</option>
                                    </select>
                                </div>
                                <div class="select-box">
                                    <label>Chambres</label>
                                    <select name="bedrooms" class="wide">
                                        <option value="">Toutes</option>
                                        <option value="1" {{ $request->bedrooms == '1' ? 'selected' : '' }}>1+ chambre</option>
                                        <option value="2" {{ $request->bedrooms == '2' ? 'selected' : '' }}>2+ chambres</option>
                                        <option value="3" {{ $request->bedrooms == '3' ? 'selected' : '' }}>3+ chambres</option>
                                        <option value="4" {{ $request->bedrooms == '4' ? 'selected' : '' }}>4+ chambres</option>
                                        <option value="5" {{ $request->bedrooms == '5' ? 'selected' : '' }}>5+ chambres</option>
                                    </select>
                                </div>
                                <div class="select-box">
                                    <label>Salles de bain</label>
                                    <select name="bathrooms" class="wide">
                                        <option value="">Toutes</option>
                                        <option value="1" {{ $request->bathrooms == '1' ? 'selected' : '' }}>1+ salle de bain</option>
                                        <option value="2" {{ $request->bathrooms == '2' ? 'selected' : '' }}>2+ salles de bain</option>
                                        <option value="3" {{ $request->bathrooms == '3' ? 'selected' : '' }}>3+ salles de bain</option>
                                        <option value="4" {{ $request->bathrooms == '4' ? 'selected' : '' }}>4+ salles de bain</option>
                                    </select>
                                </div>
                                <div class="select-box">
                                    <label>Recherche par mot-clé</label>
                                    <input type="text" name="search" placeholder="Adresse, ville, code postal..." value="{{ $request->search }}">
                                </div>
                                <div class="filter-btn">
                                    <button type="submit" class="theme-btn btn-one"><i class="fas fa-filter"></i>Filtrer</button>
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
                                $property_count = App\Models\Property::where('ptype_id', $type->id)->where('status', 1)->count();
                            @endphp
                            <li><a href="{{ route('property.type', $type->id) }}">{{ $type->type_name }} <span>({{ $property_count }})</span></a></li>
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
                                        <option value="1">Prix croissant</option>
                                        <option value="2">Prix décroissant</option>
                                        <option value="3">Plus récent</option>
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
                                            <figure class="image"><img src="{{ asset($property->property_thumbnail) }}" alt="" style="width:300px; height:350px;"></figure>
                                            <div class="batch"><i class="icon-11"></i></div>
                                            @if($property->featured == 1)
                                            <span class="category">En vedette</span>
                                            @endif
                                            <div class="buy-btn"><a href="{{ route('property.details', [$property->id, $property->property_slug]) }}">{{ $property->property_status }}</a></div>
                                        </div>
                                        <div class="lower-content">
                                            <div class="title-text"><h4><a href="{{ route('property.details', [$property->id, $property->property_slug]) }}">{{ $property->property_name }}</a></h4></div>
                                            <div class="price-box clearfix">
                                                <div class="price-info pull-left">
                                                    <h6>Prix</h6>
                                                    <h4>{{ number_format($property->lowest_price, 0, ',', ' ') }}€</h4>
                                                </div>
                                                <div class="author-box pull-right">
                                                    <h6>Agent</h6>
                                                    <figure class="author-thumb">
                                                        <img src="{{ !empty($property->user->photo) ? asset($property->user->photo) : url('upload/no_image.jpg') }}" alt="">
                                                        <span>{{ $property->user->name }}</span>
                                                    </figure>
                                                </div>
                                            </div>
                                            <p>{{ $property->short_description }}</p>
                                            <ul class="more-details clearfix">
                                                <li><i class="icon-14"></i>{{ $property->bedrooms }} Chambres</li>
                                                <li><i class="icon-15"></i>{{ $property->bathrooms }} Salles de bain</li>
                                                <li><i class="icon-16"></i>{{ $property->property_size }} m²</li>
                                            </ul>
                                            <div class="other-info-box clearfix">
                                                <div class="btn-box pull-left"><a href="{{ route('property.details', [$property->id, $property->property_slug]) }}" class="theme-btn btn-two">Détails</a></div>
                                                <ul class="other-option pull-right clearfix">
                                                    <li><a href="#"><i class="icon-12"></i></a></li>
                                                    <li><a href="#"><i class="icon-13"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            <div class="pagination-wrapper">
                                {{ $properties->appends(request()->query())->links('vendor.pagination.custom') }}
                            </div>
                        @else
                            <div class="no-results">
                                <h3>Aucune propriété trouvée</h3>
                                <p>Essayez de modifier vos critères de recherche ou contactez-nous pour trouver la propriété de vos rêves.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- property-page-section end -->

@endsection
