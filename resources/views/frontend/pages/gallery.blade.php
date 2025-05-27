@extends('frontend.frontend_dashboard')
@section('content')

<!-- page-title -->
<section class="page-title centred">
    <div class="container">
        <div class="content-box">
            <h1>{{ __('Galerie de photos') }}</h1>
            <ul class="bread-crumb clearfix">
                <li><a href="{{ route('homepage') }}">{{ __('Accueil') }}</a></li>
                <li>{{ __('Galerie') }}</li>
            </ul>
        </div>
    </div>
</section>
<!-- page-title end -->

<!-- gallery-section -->
<section class="gallery-section sec-pad">
    <div class="container">
        <div class="sec-title centred">
            <h5>{{ __('Galerie') }}</h5>
            <h2>{{ __('Explorez notre collection de propriétés') }}</h2>
            <p>{{ __('Découvrez nos propriétés exceptionnelles à travers notre galerie de photos') }}</p>
        </div>
        
        <!-- Filtres -->
        <div class="gallery-filter mb-5">
            <div class="filter-btns centred">
                <ul class="filter-buttons clearfix">
                    <li class="active" data-filter=".all">{{ __('Toutes') }} ({{ $totalImages }})</li>
                    @foreach($propertyTypes as $type)
                    <li data-filter=".type-{{ $type->id }}">{{ $type->type_name }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        
        <div class="row gallery-items">
            @foreach($properties as $property)
                @foreach($property->propertyImages as $image)
                <div class="col-lg-4 col-md-6 col-sm-12 gallery-block all type-{{ $property->ptype_id }}">
                    <div class="gallery-block-one">
                        <div class="inner-box">
                            <figure class="image-box">
                                <img src="{{ asset($image->photo_name) }}" alt="{{ $property->property_name }}">
                            </figure>
                            <div class="view-btn">
                                <a href="{{ asset($image->photo_name) }}" class="lightbox-image" data-fancybox="gallery"><i class="icon-18"></i></a>
                            </div>
                            <div class="lower-content">
                                <h4><a href="{{ route('property.details', [$property->id, $property->property_slug]) }}">{{ $property->property_name }}</a></h4>
                                <span>{{ $property->city }}, {{ $property->state }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @endforeach
        </div>
        
        <div class="pagination-wrapper centred">
            {{ $properties->links() }}
        </div>
    </div>
</section>
<!-- gallery-section end -->

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Filtrage des images par type de propriété
        $('.filter-buttons li').on('click', function() {
            const filterValue = $(this).attr('data-filter');
            
            // Mettre à jour la classe active
            $('.filter-buttons li').removeClass('active');
            $(this).addClass('active');
            
            if (filterValue === '.all') {
                $('.gallery-block').show();
            } else {
                $('.gallery-block').hide();
                $(filterValue).show();
            }
        });
    });
</script>
@endsection
