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
            <h1>Propriétés de {{ $agent->name }}</h1>
            <ul class="bread-crumb clearfix">
                <li><a href="{{ route('homepage') }}">Accueil</a></li>
                <li><a href="{{ route('agents.list') }}">Agents</a></li>
                <li>Propriétés</li>
            </ul>
        </div>
    </div>
</section>
<!--End Page Title-->

<section class="property-page-section property-grid">
    <div class="auto-container">
        <div class="row clearfix">
            <div class="col-lg-4 col-md-12 col-sm-12 sidebar-side">
                <div class="default-sidebar property-sidebar">
                    <div class="author-widget">
                        <div class="author-box">
                            <figure class="author-thumb">
                                <img src="{{ !empty($agent->photo) ? asset($agent->photo) : url('upload/no_image.jpg') }}" alt="{{ $agent->name }}">
                            </figure>
                            <h4>{{ $agent->name }}</h4>
                            <span class="designation">Agent Immobilier</span>
                        </div>
                        <ul class="info-list clearfix">
                            <li><i class="icon-24"></i>{{ $agent->phone ?? 'Non renseigné' }}</li>
                            <li><i class="icon-25"></i>{{ $agent->email }}</li>
                            <li><i class="icon-30"></i>{{ $properties->total() }} propriétés publiées</li>
                        </ul>
                        <div class="btn-box">
                            <a href="{{ route('agents.details', $agent->id) }}" class="theme-btn btn-two">Voir le profil complet</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-12 col-sm-12 content-side">
                <div class="property-content-side">
                    <div class="item-shorting clearfix">
                        <div class="left-column pull-left">
                            <h5>{{ $properties->total() }} propriété(s)</h5>
                            <p>Liste des annonces publiées par {{ $agent->name }}</p>
                        </div>
                    </div>
                    <div class="row clearfix">
                        @forelse ($properties as $property)
                            <div class="col-lg-12 deals-list-content">
                                <div class="deals-block-one">
                                    <div class="inner-box">
                                        <div class="image-box">
                                            <figure class="image">
                                                <img src="{{ asset($property->property_thumbnail) }}" alt="{{ $property->property_name }}" style="width:300px; height:320px;">
                                            </figure>
                                            @if($property->featured)
                                                <span class="category">En vedette</span>
                                            @endif
                                            <div class="buy-btn">
                                                <a href="{{ route('property.details', [$property->id, $property->property_slug]) }}">{{ ucfirst($property->property_status) }}</a>
                                            </div>
                                        </div>
                                        <div class="lower-content">
                                            <div class="title-text">
                                                <h4><a href="{{ route('property.details', [$property->id, $property->property_slug]) }}">{{ $property->property_name }}</a></h4>
                                                <p><i class="fas fa-map-marker-alt"></i> {{ $property->address }}, {{ $property->city }}</p>
                                            </div>
                                            <div class="price-box clearfix">
                                                <div class="price-info pull-left">
                                                    <h6>Prix</h6>
                                                    <h4>{{ currency_gnf($property->lowest_price) }}</h4>
                                                </div>
                                                @if($property->type)
                                                    <div class="author-box pull-right">
                                                        <h6>Type</h6>
                                                        <span>{{ $property->type->type_name }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <ul class="more-details clearfix">
                                                <li><i class="icon-14"></i>{{ $property->bedrooms }} Chambres</li>
                                                <li><i class="icon-15"></i>{{ $property->bathrooms }} Salles de bain</li>
                                                <li><i class="icon-16"></i>{{ $property->property_size }} m²</li>
                                            </ul>
                                            <div class="other-info-box clearfix">
                                                <div class="btn-box pull-left">
                                                    <a href="{{ route('property.details', [$property->id, $property->property_slug]) }}" class="theme-btn btn-two">Voir les détails</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="no-results text-center">
                                    <h3>Aucune propriété publiée</h3>
                                    <p>Cet agent n’a pas encore publié d’annonces.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                    @if($properties->hasPages())
                        <div class="pagination-wrapper">
                            {{ $properties->links('vendor.pagination.custom') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

