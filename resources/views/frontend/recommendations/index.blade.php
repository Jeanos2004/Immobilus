@extends('frontend.frontend_dashboard')

@section('content')

<div class="page-title-area page-title-bg1">
    <div class="container">
        <div class="page-title-content">
            <h2>Recommandations personnalisées</h2>
            <ul class="breadcrumb">
                <li><a href="{{ url('/') }}">Accueil</a></li>
                <li>Recommandations</li>
            </ul>
        </div>
    </div>
</div>

<section class="property-section sec-pad">
    <div class="container">
        <div class="sec-title centred">
            <h5>Découvrez des propriétés qui pourraient vous plaire</h5>
            <h2>Recommandations personnalisées</h2>
        </div>

        @if(Auth::check())
            <!-- Recommandations basées sur les favoris -->
            @if($favoriteBasedRecommendations->count() > 0)
            <div class="recommendation-section mb-5">
                <h3 class="mb-4">Basé sur vos favoris</h3>
                <div class="row">
                    @foreach($favoriteBasedRecommendations as $property)
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="feature-block-one">
                            <div class="inner-box">
                                <div class="image-box">
                                    <figure class="image">
                                        @if($property->propertyImages->count() > 0)
                                            <img src="{{ asset($property->propertyImages->first()->photo_name) }}" alt="{{ $property->property_name }}">
                                        @else
                                            <img src="{{ asset('frontend/assets/images/feature/feature-1.jpg') }}" alt="{{ $property->property_name }}">
                                        @endif
                                    </figure>
                                    <div class="batch"><i class="icon-11"></i></div>
                                    <span class="category">{{ $property->type->type_name }}</span>
                                </div>
                                <div class="lower-content">
                                    <div class="author-info clearfix">
                                        <div class="author pull-left">
                                            @if(!empty($property->agent->photo))
                                                <img src="{{ asset($property->agent->photo) }}" alt="{{ $property->agent->name }}">
                                            @else
                                                <img src="{{ asset('frontend/assets/images/feature/author-1.jpg') }}" alt="{{ $property->agent->name }}">
                                            @endif
                                            <h6>{{ $property->agent->name }}</h6>
                                        </div>
                                        <div class="buy-btn pull-right"><a href="{{ url('property/details/'.$property->id.'/'.$property->property_slug) }}">{{ $property->property_status }}</a></div>
                                    </div>
                                    <div class="title-text"><h4><a href="{{ url('property/details/'.$property->id.'/'.$property->property_slug) }}">{{ $property->property_name }}</a></h4></div>
                                    <div class="price-box clearfix">
                                        <div class="price-info pull-left">
                                            <h6>À partir de</h6>
                                            <h4>{{ number_format($property->lowest_price, 0, ',', ' ') }} €</h4>
                                        </div>
                                        <ul class="other-option pull-right clearfix">
                                            <li><a href="javascript:void(0)" onclick="addToFavorite({{ $property->id }})"><i class="icon-12"></i></a></li>
                                            <li><a href="{{ url('property/details/'.$property->id.'/'.$property->property_slug) }}"><i class="icon-13"></i></a></li>
                                        </ul>
                                    </div>
                                    <p>{{ Str::limit($property->short_descp, 60) }}</p>
                                    <ul class="more-details clearfix">
                                        <li><i class="icon-14"></i>{{ $property->bedrooms }} Chambres</li>
                                        <li><i class="icon-15"></i>{{ $property->bathrooms }} Salles de bain</li>
                                        <li><i class="icon-16"></i>{{ $property->property_size }} m²</li>
                                    </ul>
                                    <div class="btn-box"><a href="{{ url('property/details/'.$property->id.'/'.$property->property_slug) }}" class="theme-btn btn-two">Détails</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Recommandations basées sur l'historique de navigation -->
            @if($viewHistoryRecommendations->count() > 0)
            <div class="recommendation-section mb-5">
                <h3 class="mb-4">Basé sur votre historique de navigation</h3>
                <div class="row">
                    @foreach($viewHistoryRecommendations as $property)
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="feature-block-one">
                            <div class="inner-box">
                                <div class="image-box">
                                    <figure class="image">
                                        @if($property->propertyImages->count() > 0)
                                            <img src="{{ asset($property->propertyImages->first()->photo_name) }}" alt="{{ $property->property_name }}">
                                        @else
                                            <img src="{{ asset('frontend/assets/images/feature/feature-1.jpg') }}" alt="{{ $property->property_name }}">
                                        @endif
                                    </figure>
                                    <div class="batch"><i class="icon-11"></i></div>
                                    <span class="category">{{ $property->type->type_name }}</span>
                                </div>
                                <div class="lower-content">
                                    <div class="author-info clearfix">
                                        <div class="author pull-left">
                                            @if(!empty($property->agent->photo))
                                                <img src="{{ asset($property->agent->photo) }}" alt="{{ $property->agent->name }}">
                                            @else
                                                <img src="{{ asset('frontend/assets/images/feature/author-1.jpg') }}" alt="{{ $property->agent->name }}">
                                            @endif
                                            <h6>{{ $property->agent->name }}</h6>
                                        </div>
                                        <div class="buy-btn pull-right"><a href="{{ url('property/details/'.$property->id.'/'.$property->property_slug) }}">{{ $property->property_status }}</a></div>
                                    </div>
                                    <div class="title-text"><h4><a href="{{ url('property/details/'.$property->id.'/'.$property->property_slug) }}">{{ $property->property_name }}</a></h4></div>
                                    <div class="price-box clearfix">
                                        <div class="price-info pull-left">
                                            <h6>À partir de</h6>
                                            <h4>{{ number_format($property->lowest_price, 0, ',', ' ') }} €</h4>
                                        </div>
                                        <ul class="other-option pull-right clearfix">
                                            <li><a href="javascript:void(0)" onclick="addToFavorite({{ $property->id }})"><i class="icon-12"></i></a></li>
                                            <li><a href="{{ url('property/details/'.$property->id.'/'.$property->property_slug) }}"><i class="icon-13"></i></a></li>
                                        </ul>
                                    </div>
                                    <p>{{ Str::limit($property->short_descp, 60) }}</p>
                                    <ul class="more-details clearfix">
                                        <li><i class="icon-14"></i>{{ $property->bedrooms }} Chambres</li>
                                        <li><i class="icon-15"></i>{{ $property->bathrooms }} Salles de bain</li>
                                        <li><i class="icon-16"></i>{{ $property->property_size }} m²</li>
                                    </ul>
                                    <div class="btn-box"><a href="{{ url('property/details/'.$property->id.'/'.$property->property_slug) }}" class="theme-btn btn-two">Détails</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Recommandations basées sur les utilisateurs similaires -->
            @if($similarUserRecommendations->count() > 0)
            <div class="recommendation-section mb-5">
                <h3 class="mb-4">D'autres utilisateurs comme vous ont aimé</h3>
                <div class="row">
                    @foreach($similarUserRecommendations as $property)
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="feature-block-one">
                            <div class="inner-box">
                                <div class="image-box">
                                    <figure class="image">
                                        @if($property->propertyImages->count() > 0)
                                            <img src="{{ asset($property->propertyImages->first()->photo_name) }}" alt="{{ $property->property_name }}">
                                        @else
                                            <img src="{{ asset('frontend/assets/images/feature/feature-1.jpg') }}" alt="{{ $property->property_name }}">
                                        @endif
                                    </figure>
                                    <div class="batch"><i class="icon-11"></i></div>
                                    <span class="category">{{ $property->type->type_name }}</span>
                                </div>
                                <div class="lower-content">
                                    <div class="author-info clearfix">
                                        <div class="author pull-left">
                                            @if(!empty($property->agent->photo))
                                                <img src="{{ asset($property->agent->photo) }}" alt="{{ $property->agent->name }}">
                                            @else
                                                <img src="{{ asset('frontend/assets/images/feature/author-1.jpg') }}" alt="{{ $property->agent->name }}">
                                            @endif
                                            <h6>{{ $property->agent->name }}</h6>
                                        </div>
                                        <div class="buy-btn pull-right"><a href="{{ url('property/details/'.$property->id.'/'.$property->property_slug) }}">{{ $property->property_status }}</a></div>
                                    </div>
                                    <div class="title-text"><h4><a href="{{ url('property/details/'.$property->id.'/'.$property->property_slug) }}">{{ $property->property_name }}</a></h4></div>
                                    <div class="price-box clearfix">
                                        <div class="price-info pull-left">
                                            <h6>À partir de</h6>
                                            <h4>{{ number_format($property->lowest_price, 0, ',', ' ') }} €</h4>
                                        </div>
                                        <ul class="other-option pull-right clearfix">
                                            <li><a href="javascript:void(0)" onclick="addToFavorite({{ $property->id }})"><i class="icon-12"></i></a></li>
                                            <li><a href="{{ url('property/details/'.$property->id.'/'.$property->property_slug) }}"><i class="icon-13"></i></a></li>
                                        </ul>
                                    </div>
                                    <p>{{ Str::limit($property->short_descp, 60) }}</p>
                                    <ul class="more-details clearfix">
                                        <li><i class="icon-14"></i>{{ $property->bedrooms }} Chambres</li>
                                        <li><i class="icon-15"></i>{{ $property->bathrooms }} Salles de bain</li>
                                        <li><i class="icon-16"></i>{{ $property->property_size }} m²</li>
                                    </ul>
                                    <div class="btn-box"><a href="{{ url('property/details/'.$property->id.'/'.$property->property_slug) }}" class="theme-btn btn-two">Détails</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        @else
            <!-- Propriétés populaires pour les utilisateurs non connectés -->
            <div class="recommendation-section mb-5">
                <h3 class="mb-4">Propriétés populaires</h3>
                <div class="row">
                    @foreach($popularProperties as $property)
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="feature-block-one">
                            <div class="inner-box">
                                <div class="image-box">
                                    <figure class="image">
                                        @if($property->propertyImages->count() > 0)
                                            <img src="{{ asset($property->propertyImages->first()->photo_name) }}" alt="{{ $property->property_name }}">
                                        @else
                                            <img src="{{ asset('frontend/assets/images/feature/feature-1.jpg') }}" alt="{{ $property->property_name }}">
                                        @endif
                                    </figure>
                                    <div class="batch"><i class="icon-11"></i></div>
                                    <span class="category">{{ $property->type->type_name }}</span>
                                </div>
                                <div class="lower-content">
                                    <div class="author-info clearfix">
                                        <div class="author pull-left">
                                            @if(!empty($property->agent->photo))
                                                <img src="{{ asset($property->agent->photo) }}" alt="{{ $property->agent->name }}">
                                            @else
                                                <img src="{{ asset('frontend/assets/images/feature/author-1.jpg') }}" alt="{{ $property->agent->name }}">
                                            @endif
                                            <h6>{{ $property->agent->name }}</h6>
                                        </div>
                                        <div class="buy-btn pull-right"><a href="{{ url('property/details/'.$property->id.'/'.$property->property_slug) }}">{{ $property->property_status }}</a></div>
                                    </div>
                                    <div class="title-text"><h4><a href="{{ url('property/details/'.$property->id.'/'.$property->property_slug) }}">{{ $property->property_name }}</a></h4></div>
                                    <div class="price-box clearfix">
                                        <div class="price-info pull-left">
                                            <h6>À partir de</h6>
                                            <h4>{{ number_format($property->lowest_price, 0, ',', ' ') }} €</h4>
                                        </div>
                                        <ul class="other-option pull-right clearfix">
                                            <li><a href="{{ route('login') }}"><i class="icon-12"></i></a></li>
                                            <li><a href="{{ url('property/details/'.$property->id.'/'.$property->property_slug) }}"><i class="icon-13"></i></a></li>
                                        </ul>
                                    </div>
                                    <p>{{ Str::limit($property->short_descp, 60) }}</p>
                                    <ul class="more-details clearfix">
                                        <li><i class="icon-14"></i>{{ $property->bedrooms }} Chambres</li>
                                        <li><i class="icon-15"></i>{{ $property->bathrooms }} Salles de bain</li>
                                        <li><i class="icon-16"></i>{{ $property->property_size }} m²</li>
                                    </ul>
                                    <div class="btn-box"><a href="{{ url('property/details/'.$property->id.'/'.$property->property_slug) }}" class="theme-btn btn-two">Détails</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="text-center mt-4">
                    <a href="{{ route('login') }}" class="theme-btn btn-one">Connectez-vous pour des recommandations personnalisées</a>
                </div>
            </div>
        @endif
    </div>
</section>

@endsection

@section('scripts')
<script>
    // Fonction pour ajouter une propriété aux favoris
    function addToFavorite(propertyId) {
        $.ajax({
            url: "{{ route('add.to.favorite') }}",
            type: "POST",
            data: {
                property_id: propertyId,
                _token: "{{ csrf_token() }}"
            },
            dataType: "json",
            success: function(data) {
                // Afficher un message de succès
                toastr.success(data.message);
            },
            error: function(xhr, status, error) {
                // Gérer les erreurs
                if (xhr.status === 401) {
                    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
                    window.location.href = "{{ route('login') }}";
                } else {
                    toastr.error("Une erreur s'est produite. Veuillez réessayer.");
                }
            }
        });
    }
</script>
@endsection
