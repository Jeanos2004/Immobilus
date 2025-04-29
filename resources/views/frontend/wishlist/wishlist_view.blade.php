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
            <h1>Mes propriétés favorites</h1>
            <ul class="bread-crumb clearfix">
                <li><a href="/">Accueil</a></li>
                <li>Favoris</li>
            </ul>
        </div>
    </div>
</section>
<!--End Page Title-->

<!-- property-page-section -->
<section class="property-page-section property-list">
    <div class="auto-container">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 content-side">
                <div class="property-content-side">
                    
                    @if(count($wishlist) > 0)
                    <div class="wrapper list">
                        <div class="deals-list-content list-item">
                            
                            @foreach($wishlist as $item)
                            <div class="deals-block-one">
                                <div class="inner-box">
                                    <div class="image-box">
                                        <figure class="image"><img src="{{ asset($item->property->property_thumbnail) }}" alt="{{ $item->property->property_name }}" style="width:100%; height:350px; object-fit:cover;"></figure>
                                        <div class="batch"><i class="icon-11"></i></div>
                                        
                                        <!-- Bouton pour retirer des favoris -->
                                        <a href="{{ route('remove.wishlist', $item->id) }}" class="wishlist-btn remove-wishlist" onclick="return confirm('Êtes-vous sûr de vouloir retirer cette propriété de vos favoris ?')">
                                            <i class="icon-12"></i>
                                            <span class="tooltip-text">Retirer des favoris</span>
                                        </a>
                                        
                                        @if($item->property->featured == 1)
                                        <span class="category">Coup de cœur</span>
                                        @endif
                                        
                                        @if($item->property->property_status == 'À louer')
                                        <span class="category2">À louer</span>
                                        @else
                                        <span class="category2">À vendre</span>
                                        @endif
                                    </div>
                                    <div class="lower-content">
                                        <div class="title-text">
                                            <h4><a href="{{ url('property/details/'.$item->property->id.'/'.$item->property->property_slug) }}">{{ $item->property->property_name }}</a></h4>
                                        </div>
                                        <div class="price-box clearfix">
                                            <div class="price-info pull-left">
                                                <h6>À partir de</h6>
                                                <h4>{{ number_format($item->property->lowest_price, 0, ',', ' ') }}€</h4>
                                            </div>
                                            <div class="author-box pull-right">
                                                <figure class="author-thumb">
                                                    <img src="{{ !empty($item->property->user->photo) ? asset($item->property->user->photo) : url('upload/no_image.jpg') }}" alt="{{ $item->property->user->name }}">
                                                    <span>{{ $item->property->user->name }}</span>
                                                </figure>
                                            </div>
                                        </div>
                                        <p>{{ Str::limit($item->property->short_description, 100) }}</p>
                                        <ul class="more-details clearfix">
                                            <li><i class="icon-14"></i>{{ $item->property->bedrooms }} Chambres</li>
                                            <li><i class="icon-15"></i>{{ $item->property->bathrooms }} Salles de bain</li>
                                            <li><i class="icon-16"></i>{{ $item->property->property_size }} m²</li>
                                        </ul>
                                        <div class="other-info-box clearfix">
                                            <div class="btn-box pull-left">
                                                <a href="{{ url('property/details/'.$item->property->id.'/'.$item->property->property_slug) }}" class="theme-btn btn-two">Détails</a>
                                            </div>
                                            <ul class="other-option pull-right clearfix">
                                                <li><a href="{{ url('property/details/'.$item->property->id.'/'.$item->property->property_slug) }}"><i class="icon-13"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            
                        </div>
                    </div>
                    @else
                    <div class="alert alert-info text-center p-5">
                        <h4>Vous n'avez pas encore de propriétés favorites</h4>
                        <p class="mt-3">Explorez notre catalogue de propriétés et ajoutez celles qui vous intéressent à vos favoris pour les retrouver facilement.</p>
                        <a href="{{ route('property.list') }}" class="theme-btn btn-one mt-3">Voir toutes les propriétés</a>
                    </div>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</section>
<!-- property-page-section end -->

@endsection

@section('scripts')
<style>
    .remove-wishlist {
        background-color: #ff5a5f !important;
    }
    .remove-wishlist:hover {
        background-color: #ff2d33 !important;
    }
</style>
@endsection
