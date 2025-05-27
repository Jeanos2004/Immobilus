@extends('frontend.frontend_dashboard')
@section('content')

<!-- page-title -->
<section class="page-title centred">
    <div class="container">
        <div class="content-box">
            <h1>{{ __('Comparaison de propriétés') }}</h1>
            <ul class="bread-crumb clearfix">
                <li><a href="{{ route('homepage') }}">{{ __('Accueil') }}</a></li>
                <li>{{ __('Comparaison') }}</li>
            </ul>
        </div>
    </div>
</section>
<!-- page-title end -->

<!-- compare-section -->
<section class="compare-section sec-pad">
    <div class="container">
        @if(count($properties) > 0)
            <div class="clearfix mb-4">
                <div class="float-right">
                    <a href="{{ route('compare.clear') }}" class="theme-btn btn-two">{{ __('Vider la liste') }}</a>
                </div>
            </div>
            
            <div class="compare-table-wrapper">
                <div class="table-responsive">
                    <table class="table table-bordered compare-table">
                        <thead>
                            <tr>
                                <th class="property-info">{{ __('Propriété') }}</th>
                                @foreach($properties as $property)
                                    <th class="text-center">
                                        <div class="property-thumb">
                                            <img src="{{ asset(!empty($property->property_thumbnail) ? $property->property_thumbnail : 'upload/no_image.jpg') }}" alt="{{ $property->property_name }}">
                                            <div class="remove-btn">
                                                <button type="button" class="remove-compare" data-id="{{ $property->id }}">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <h4><a href="{{ route('property.details', [$property->id, $property->property_slug]) }}">{{ $property->property_name }}</a></h4>
                                        <div class="price">{{ $property->property_status == 'rent' ? __('À louer') : __('À vendre') }}: <span>{{ number_format($property->lowest_price, 0, ',', ' ') }} €</span></div>
                                    </th>
                                @endforeach
                                @for($i = count($properties); $i < 3; $i++)
                                    <th class="text-center empty-property">
                                        <div class="empty-box">
                                            <i class="fas fa-home"></i>
                                            <p>{{ __('Ajouter une propriété') }}</p>
                                            <a href="{{ route('property.list') }}" class="theme-btn btn-one">{{ __('Parcourir') }}</a>
                                        </div>
                                    </th>
                                @endfor
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Informations de base -->
                            <tr class="section-heading">
                                <td colspan="{{ count($properties) + (3 - count($properties)) + 1 }}">{{ __('Informations de base') }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('Type de propriété') }}</td>
                                @foreach($properties as $property)
                                    <td>{{ $property->type->type_name }}</td>
                                @endforeach
                                @for($i = count($properties); $i < 3; $i++)
                                    <td>-</td>
                                @endfor
                            </tr>
                            <tr>
                                <td>{{ __('Statut') }}</td>
                                @foreach($properties as $property)
                                    <td>{{ $property->property_status == 'rent' ? __('À louer') : __('À vendre') }}</td>
                                @endforeach
                                @for($i = count($properties); $i < 3; $i++)
                                    <td>-</td>
                                @endfor
                            </tr>
                            <tr>
                                <td>{{ __('Surface') }}</td>
                                @foreach($properties as $property)
                                    <td>{{ $property->property_size }} m²</td>
                                @endforeach
                                @for($i = count($properties); $i < 3; $i++)
                                    <td>-</td>
                                @endfor
                            </tr>
                            <tr>
                                <td>{{ __('Chambres') }}</td>
                                @foreach($properties as $property)
                                    <td>{{ $property->bedrooms }}</td>
                                @endforeach
                                @for($i = count($properties); $i < 3; $i++)
                                    <td>-</td>
                                @endfor
                            </tr>
                            <tr>
                                <td>{{ __('Salles de bain') }}</td>
                                @foreach($properties as $property)
                                    <td>{{ $property->bathrooms }}</td>
                                @endforeach
                                @for($i = count($properties); $i < 3; $i++)
                                    <td>-</td>
                                @endfor
                            </tr>
                            <tr>
                                <td>{{ __('Garage') }}</td>
                                @foreach($properties as $property)
                                    <td>{{ $property->garage ? $property->garage : '0' }}</td>
                                @endforeach
                                @for($i = count($properties); $i < 3; $i++)
                                    <td>-</td>
                                @endfor
                            </tr>
                            <tr>
                                <td>{{ __('Année de construction') }}</td>
                                @foreach($properties as $property)
                                    <td>{{ $property->property_year ? $property->property_year : '-' }}</td>
                                @endforeach
                                @for($i = count($properties); $i < 3; $i++)
                                    <td>-</td>
                                @endfor
                            </tr>
                            
                            <!-- Localisation -->
                            <tr class="section-heading">
                                <td colspan="{{ count($properties) + (3 - count($properties)) + 1 }}">{{ __('Localisation') }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('Adresse') }}</td>
                                @foreach($properties as $property)
                                    <td>{{ $property->address }}</td>
                                @endforeach
                                @for($i = count($properties); $i < 3; $i++)
                                    <td>-</td>
                                @endfor
                            </tr>
                            <tr>
                                <td>{{ __('Ville') }}</td>
                                @foreach($properties as $property)
                                    <td>{{ $property->city }}</td>
                                @endforeach
                                @for($i = count($properties); $i < 3; $i++)
                                    <td>-</td>
                                @endfor
                            </tr>
                            <tr>
                                <td>{{ __('Code postal') }}</td>
                                @foreach($properties as $property)
                                    <td>{{ $property->postal_code }}</td>
                                @endforeach
                                @for($i = count($properties); $i < 3; $i++)
                                    <td>-</td>
                                @endfor
                            </tr>
                            
                            <!-- Prix -->
                            <tr class="section-heading">
                                <td colspan="{{ count($properties) + (3 - count($properties)) + 1 }}">{{ __('Prix') }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('Prix') }}</td>
                                @foreach($properties as $property)
                                    <td>{{ number_format($property->lowest_price, 0, ',', ' ') }} €</td>
                                @endforeach
                                @for($i = count($properties); $i < 3; $i++)
                                    <td>-</td>
                                @endfor
                            </tr>
                            <tr>
                                <td>{{ __('Prix au m²') }}</td>
                                @foreach($properties as $property)
                                    <td>{{ number_format($property->lowest_price / $property->property_size, 0, ',', ' ') }} €/m²</td>
                                @endforeach
                                @for($i = count($properties); $i < 3; $i++)
                                    <td>-</td>
                                @endfor
                            </tr>
                            
                            <!-- Commodités -->
                            <tr class="section-heading">
                                <td colspan="{{ count($properties) + (3 - count($properties)) + 1 }}">{{ __('Commodités') }}</td>
                            </tr>
                            @foreach($allAmenities as $amenity)
                            <tr>
                                <td>{{ $amenity->amenity_name }}</td>
                                @foreach($properties as $property)
                                    <td>
                                        @if($property->propertyAmenities->contains('amenity_id', $amenity->id))
                                            <i class="fas fa-check text-success"></i>
                                        @else
                                            <i class="fas fa-times text-danger"></i>
                                        @endif
                                    </td>
                                @endforeach
                                @for($i = count($properties); $i < 3; $i++)
                                    <td>-</td>
                                @endfor
                            </tr>
                            @endforeach
                            
                            <!-- Agent -->
                            <tr class="section-heading">
                                <td colspan="{{ count($properties) + (3 - count($properties)) + 1 }}">{{ __('Agent immobilier') }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('Nom de l\'agent') }}</td>
                                @foreach($properties as $property)
                                    <td>{{ $property->user->name }}</td>
                                @endforeach
                                @for($i = count($properties); $i < 3; $i++)
                                    <td>-</td>
                                @endfor
                            </tr>
                            <tr>
                                <td>{{ __('Contact') }}</td>
                                @foreach($properties as $property)
                                    <td>
                                        <a href="{{ route('agents.details', $property->agent_id) }}" class="theme-btn btn-one btn-sm">{{ __('Contacter') }}</a>
                                    </td>
                                @endforeach
                                @for($i = count($properties); $i < 3; $i++)
                                    <td>-</td>
                                @endfor
                            </tr>
                            
                            <!-- Actions -->
                            <tr class="section-heading">
                                <td colspan="{{ count($properties) + (3 - count($properties)) + 1 }}">{{ __('Actions') }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('Voir détails') }}</td>
                                @foreach($properties as $property)
                                    <td>
                                        <a href="{{ route('property.details', [$property->id, $property->property_slug]) }}" class="theme-btn btn-one btn-sm">{{ __('Voir détails') }}</a>
                                    </td>
                                @endforeach
                                @for($i = count($properties); $i < 3; $i++)
                                    <td>-</td>
                                @endfor
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="empty-compare text-center py-5">
                <div class="icon-box mb-4">
                    <i class="fas fa-exchange-alt fa-4x"></i>
                </div>
                <h3>{{ __('Aucune propriété à comparer') }}</h3>
                <p>{{ __('Vous n\'avez pas encore ajouté de propriétés à comparer.') }}</p>
                <div class="mt-4">
                    <a href="{{ route('property.list') }}" class="theme-btn btn-one">{{ __('Parcourir les propriétés') }}</a>
                </div>
            </div>
        @endif
    </div>
</section>
<!-- compare-section end -->

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Supprimer une propriété de la comparaison
        $('.remove-compare').on('click', function() {
            const propertyId = $(this).data('id');
            
            $.ajax({
                url: "{{ route('compare.remove') }}",
                type: "POST",
                data: {
                    property_id: propertyId,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.status === 'success') {
                        toastr.success(response.message);
                        // Recharger la page après 1 seconde
                        setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function() {
                    toastr.error("{{ __('Une erreur est survenue. Veuillez réessayer.') }}");
                }
            });
        });
    });
</script>
@endsection
