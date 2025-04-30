@extends('frontend.frontend_dashboard')

@section('head')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<!-- MarkerCluster CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css" />
@endsection

@section('content')

<div class="page-title-area page-title-bg1">
    <div class="container">
        <div class="page-title-content">
            <h2>Recherche géographique de propriétés</h2>
            <ul>
                <li><a href="{{ url('/') }}">Accueil</a></li>
                <li>Carte interactive</li>
            </ul>
        </div>
    </div>
</div>

<section class="property-area ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="widget-area" id="secondary">
                    <div class="widget widget_filter">
                        <h3 class="widget-title">Filtres</h3>
                        <form id="mapFilterForm">
                            <div class="form-group">
                                <label>Type de propriété</label>
                                <select class="form-control" name="property_type" id="property_type">
                                    <option value="">Tous les types</option>
                                    @foreach($propertyTypes as $type)
                                        <option value="{{ $type->id }}">{{ $type->type_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Statut</label>
                                <select class="form-control" name="status" id="property_status">
                                    <option value="">Tous</option>
                                    <option value="rent">Location</option>
                                    <option value="sale">Vente</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Prix minimum</label>
                                <input type="number" class="form-control" name="min_price" id="min_price" placeholder="Prix minimum">
                            </div>

                            <div class="form-group">
                                <label>Prix maximum</label>
                                <input type="number" class="form-control" name="max_price" id="max_price" placeholder="Prix maximum">
                            </div>

                            <div class="form-group">
                                <label>Chambres (min)</label>
                                <select class="form-control" name="bedrooms" id="bedrooms">
                                    <option value="">Indifférent</option>
                                    <option value="1">1+</option>
                                    <option value="2">2+</option>
                                    <option value="3">3+</option>
                                    <option value="4">4+</option>
                                    <option value="5">5+</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Salles de bain (min)</label>
                                <select class="form-control" name="bathrooms" id="bathrooms">
                                    <option value="">Indifférent</option>
                                    <option value="1">1+</option>
                                    <option value="2">2+</option>
                                    <option value="3">3+</option>
                                    <option value="4">4+</option>
                                </select>
                            </div>

                            <hr>

                            <div class="form-group">
                                <label>Recherche par adresse</label>
                                <input type="text" class="form-control" id="address_search" placeholder="Entrez une adresse">
                            </div>

                            <div class="form-group">
                                <label>Rayon (km)</label>
                                <input type="range" class="form-control-range" id="radius" min="1" max="50" value="10">
                                <span id="radius_value">10 km</span>
                            </div>

                            <div class="form-group mt-3">
                                <button type="button" id="searchByAddressBtn" class="btn btn-primary btn-block">Rechercher par adresse</button>
                            </div>

                            <hr>

                            <div class="form-group">
                                <button type="button" id="resetMapBtn" class="btn btn-secondary btn-block">Réinitialiser la carte</button>
                            </div>
                        </form>
                    </div>

                    <div class="widget widget_properties">
                        <h3 class="widget-title">Propriétés trouvées (<span id="property_count">{{ count($mapData) }}</span>)</h3>
                        <div id="property_list" class="property-list-container">
                            @foreach($properties as $property)
                                @if(!empty($property->latitude) && !empty($property->longitude))
                                <div class="property-item" data-id="{{ $property->id }}">
                                    <div class="single-property-box">
                                        <div class="property-item-thumb">
                                            <a href="{{ route('property.details', [$property->id, $property->property_slug]) }}">
                                                <img src="{{ asset($property->property_thumbnail) }}" alt="{{ $property->property_name }}">
                                            </a>
                                            <div class="property-badge">
                                                @if($property->property_status == 'rent')
                                                    <span class="rent">À louer</span>
                                                @else
                                                    <span class="sale">À vendre</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="property-item-content">
                                            <div class="price">
                                                @if($property->property_status == 'rent')
                                                    {{ number_format($property->lowest_price, 0, ',', ' ') }} € / mois
                                                @else
                                                    {{ number_format($property->max_price, 0, ',', ' ') }} €
                                                @endif
                                            </div>
                                            <h3>
                                                <a href="{{ route('property.details', [$property->id, $property->property_slug]) }}">{{ $property->property_name }}</a>
                                            </h3>
                                            <p><i class="bx bx-map"></i> {{ $property->address }}</p>
                                            <ul class="property-feature">
                                                <li><i class="bx bx-bed"></i> {{ $property->bedrooms }} chambres</li>
                                                <li><i class="bx bx-bath"></i> {{ $property->bathrooms }} SDB</li>
                                                <li><i class="bx bx-area"></i> {{ $property->property_size }} m²</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="map-container">
                    <div id="property-map" style="height: 700px;"></div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<!-- Leaflet JavaScript -->
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<!-- MarkerCluster -->
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css" />
<script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>

<script>
    // S'assurer que jQuery est chargé avant d'exécuter notre code
    document.addEventListener('DOMContentLoaded', function() {
        // Vérifier si jQuery est disponible
        if (typeof jQuery !== 'undefined') {
        // Initialisation de la carte
        var map = L.map('property-map').setView([46.603354, 1.888334], 6); // Centre sur la France

        // Ajout du fond de carte OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Groupe de marqueurs pour le clustering
        var markers = L.markerClusterGroup();
        
        // Données des propriétés (JSON)
        var properties = @json($mapData);
        
        // Ajouter les marqueurs pour chaque propriété
        properties.forEach(function(property) {
            var marker = L.marker([property.lat, property.lng]);
            
            // Popup avec les informations de la propriété
            var popupContent = `
                <div class="property-popup">
                    <div class="property-image">
                        <img src="{{ asset('') }}${property.thumbnail}" alt="${property.name}" style="width: 100%; max-height: 150px; object-fit: cover;">
                    </div>
                    <div class="property-info">
                        <h5>${property.name}</h5>
                        <p><i class="bx bx-map"></i> ${property.address}</p>
                        <p><strong>Prix:</strong> ${property.status === 'rent' ? property.price + ' € / mois' : property.price + ' €'}</p>
                        <p><strong>Type:</strong> ${property.type}</p>
                        <div class="property-features">
                            <span><i class="bx bx-bed"></i> ${property.bedrooms} chambres</span>
                            <span><i class="bx bx-bath"></i> ${property.bathrooms} SDB</span>
                            <span><i class="bx bx-area"></i> ${property.size} m²</span>
                        </div>
                        <a href="/property/details/${property.id}/${property.slug}" class="btn btn-sm btn-primary mt-2">Voir les détails</a>
                    </div>
                </div>
            `;
            
            marker.bindPopup(popupContent);
            markers.addLayer(marker);
            
            // Lier le marqueur à l'élément de la liste de propriétés
            marker.propertyId = property.id;
        });
        
        // Ajouter le groupe de marqueurs à la carte
        map.addLayer(markers);
        
        // Ajuster la vue pour montrer tous les marqueurs
        if (properties.length > 0) {
            map.fitBounds(markers.getBounds(), { padding: [50, 50] });
        }
        
        // Recherche par zone (lorsque la carte est déplacée)
        map.on('moveend', function() {
            if ($('#property_type').val() || $('#property_status').val() || $('#min_price').val() || $('#max_price').val() || $('#bedrooms').val() || $('#bathrooms').val()) {
                searchByMapBounds();
            }
        });
        
        // Fonction pour rechercher par les limites de la carte
        function searchByMapBounds() {
            var bounds = map.getBounds();
            
            $.ajax({
                url: '{{ route("property.map.search.area") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    north: bounds.getNorth(),
                    south: bounds.getSouth(),
                    east: bounds.getEast(),
                    west: bounds.getWest(),
                    property_type: $('#property_type').val(),
                    status: $('#property_status').val(),
                    min_price: $('#min_price').val(),
                    max_price: $('#max_price').val(),
                    bedrooms: $('#bedrooms').val(),
                    bathrooms: $('#bathrooms').val()
                },
                success: function(response) {
                    // Mettre à jour les marqueurs
                    updateMarkers(response.properties);
                    // Mettre à jour le compteur
                    $('#property_count').text(response.count);
                    // Mettre à jour la liste des propriétés
                    updatePropertyList(response.properties);
                },
                error: function(xhr) {
                    console.error('Erreur lors de la recherche:', xhr.responseText);
                }
            });
        }
        
        // Recherche par adresse
        $('#searchByAddressBtn').on('click', function() {
            var address = $('#address_search').val();
            var radius = $('#radius').val();
            
            if (!address) {
                alert('Veuillez entrer une adresse');
                return;
            }
            
            $.ajax({
                url: '{{ route("property.map.search.address") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    address: address,
                    radius: radius,
                    property_type: $('#property_type').val(),
                    status: $('#property_status').val()
                },
                success: function(response) {
                    // Centrer la carte sur l'adresse
                    map.setView([response.center.lat, response.center.lng], 12);
                    
                    // Ajouter un marqueur pour l'adresse recherchée
                    var addressMarker = L.marker([response.center.lat, response.center.lng], {
                        icon: L.divIcon({
                            className: 'address-marker',
                            html: '<div style="background-color: #ff0000; width: 12px; height: 12px; border-radius: 50%; border: 2px solid white;"></div>',
                            iconSize: [12, 12],
                            iconAnchor: [6, 6]
                        })
                    }).addTo(map);
                    
                    addressMarker.bindPopup(`<strong>Adresse recherchée:</strong><br>${response.center.address}`).openPopup();
                    
                    // Dessiner un cercle pour le rayon de recherche
                    var circle = L.circle([response.center.lat, response.center.lng], {
                        radius: radius * 1000, // Convertir en mètres
                        color: '#ff0000',
                        fillColor: '#ff0000',
                        fillOpacity: 0.1
                    }).addTo(map);
                    
                    // Mettre à jour les marqueurs
                    updateMarkers(response.properties);
                    // Mettre à jour le compteur
                    $('#property_count').text(response.count);
                    // Mettre à jour la liste des propriétés
                    updatePropertyList(response.properties);
                },
                error: function(xhr) {
                    console.error('Erreur lors de la recherche par adresse:', xhr.responseText);
                }
            });
        });
        
        // Mise à jour des marqueurs
        function updateMarkers(properties) {
            // Supprimer tous les marqueurs existants
            markers.clearLayers();
            
            // Ajouter les nouveaux marqueurs
            properties.forEach(function(property) {
                var marker = L.marker([property.lat, property.lng]);
                
                // Popup avec les informations de la propriété
                var popupContent = `
                    <div class="property-popup">
                        <div class="property-image">
                            <img src="{{ asset('') }}${property.thumbnail}" alt="${property.name}" style="width: 100%; max-height: 150px; object-fit: cover;">
                        </div>
                        <div class="property-info">
                            <h5>${property.name}</h5>
                            <p><i class="bx bx-map"></i> ${property.address}</p>
                            <p><strong>Prix:</strong> ${property.status === 'rent' ? property.price + ' € / mois' : property.price + ' €'}</p>
                            <p><strong>Type:</strong> ${property.type}</p>
                            <div class="property-features">
                                <span><i class="bx bx-bed"></i> ${property.bedrooms} chambres</span>
                                <span><i class="bx bx-bath"></i> ${property.bathrooms} SDB</span>
                                <span><i class="bx bx-area"></i> ${property.size} m²</span>
                            </div>
                            ${property.distance ? '<p><strong>Distance:</strong> ' + property.distance + '</p>' : ''}
                            <a href="${property.url}" class="btn btn-sm btn-primary mt-2">Voir les détails</a>
                        </div>
                    </div>
                `;
                
                marker.bindPopup(popupContent);
                markers.addLayer(marker);
                
                // Lier le marqueur à l'élément de la liste de propriétés
                marker.propertyId = property.id;
            });
            
            // Ajouter le groupe de marqueurs à la carte
            map.addLayer(markers);
        }
        
        // Mise à jour de la liste des propriétés
        function updatePropertyList(properties) {
            var html = '';
            
            properties.forEach(function(property) {
                html += `
                <div class="property-item" data-id="${property.id}">
                    <div class="single-property-box">
                        <div class="property-item-thumb">
                            <a href="${property.url}">
                                <img src="{{ asset('') }}${property.thumbnail}" alt="${property.name}">
                            </a>
                            <div class="property-badge">
                                ${property.status === 'rent' ? '<span class="rent">À louer</span>' : '<span class="sale">À vendre</span>'}
                            </div>
                        </div>
                        <div class="property-item-content">
                            <div class="price">
                                ${property.status === 'rent' ? property.price + ' € / mois' : property.price + ' €'}
                            </div>
                            <h3>
                                <a href="${property.url}">${property.name}</a>
                            </h3>
                            <p><i class="bx bx-map"></i> ${property.address}</p>
                            <ul class="property-feature">
                                <li><i class="bx bx-bed"></i> ${property.bedrooms} chambres</li>
                                <li><i class="bx bx-bath"></i> ${property.bathrooms} SDB</li>
                                <li><i class="bx bx-area"></i> ${property.size} m²</li>
                            </ul>
                            ${property.distance ? '<p><strong>Distance:</strong> ' + property.distance + '</p>' : ''}
                        </div>
                    </div>
                </div>
                `;
            });
            
            $('#property_list').html(html);
            
            // Ajouter un événement de clic sur les éléments de la liste
            $('.property-item').on('click', function() {
                var propertyId = $(this).data('id');
                
                // Trouver le marqueur correspondant et ouvrir sa popup
                markers.eachLayer(function(layer) {
                    if (layer.propertyId === propertyId) {
                        map.setView(layer.getLatLng(), 14);
                        layer.openPopup();
                    }
                });
            });
        }
        
        // Réinitialiser la carte
        $('#resetMapBtn').on('click', function() {
            // Réinitialiser les filtres
            $('#mapFilterForm')[0].reset();
            
            // Réinitialiser la carte
            map.setView([46.603354, 1.888334], 6);
            
            // Recharger les marqueurs initiaux
            updateMarkers(properties);
            
            // Mettre à jour le compteur
            $('#property_count').text(properties.length);
            
            // Réinitialiser la liste des propriétés
            var html = '';
            @foreach($properties as $property)
                @if(!empty($property->latitude) && !empty($property->longitude))
                html += `
                <div class="property-item" data-id="{{ $property->id }}">
                    <div class="single-property-box">
                        <div class="property-item-thumb">
                            <a href="{{ route('property.details', [$property->id, $property->property_slug]) }}">
                                <img src="{{ asset($property->property_thumbnail) }}" alt="{{ $property->property_name }}">
                            </a>
                            <div class="property-badge">
                                @if($property->property_status == 'rent')
                                    <span class="rent">À louer</span>
                                @else
                                    <span class="sale">À vendre</span>
                                @endif
                            </div>
                        </div>
                        <div class="property-item-content">
                            <div class="price">
                                @if($property->property_status == 'rent')
                                    {{ number_format($property->lowest_price, 0, ',', ' ') }} € / mois
                                @else
                                    {{ number_format($property->max_price, 0, ',', ' ') }} €
                                @endif
                            </div>
                            <h3>
                                <a href="{{ route('property.details', [$property->id, $property->property_slug]) }}">{{ $property->property_name }}</a>
                            </h3>
                            <p><i class="bx bx-map"></i> {{ $property->address }}</p>
                            <ul class="property-feature">
                                <li><i class="bx bx-bed"></i> {{ $property->bedrooms }} chambres</li>
                                <li><i class="bx bx-bath"></i> {{ $property->bathrooms }} SDB</li>
                                <li><i class="bx bx-area"></i> {{ $property->property_size }} m²</li>
                            </ul>
                        </div>
                    </div>
                </div>
                `;
                @endif
            @endforeach
            
            $('#property_list').html(html);
            
            // Ajouter un événement de clic sur les éléments de la liste
            $('.property-item').on('click', function() {
                var propertyId = $(this).data('id');
                
                // Trouver le marqueur correspondant et ouvrir sa popup
                markers.eachLayer(function(layer) {
                    if (layer.propertyId === propertyId) {
                        map.setView(layer.getLatLng(), 14);
                        layer.openPopup();
                    }
                });
            });
        });
        
        // Mise à jour de l'affichage du rayon
        $('#radius').on('input', function() {
            $('#radius_value').text($(this).val() + ' km');
        });
        
        // Filtres de recherche
        $('#property_type, #property_status, #min_price, #max_price, #bedrooms, #bathrooms').on('change', function() {
            searchByMapBounds();
        });
        
        // Ajouter un événement de clic sur les éléments de la liste
        $('.property-item').on('click', function() {
            var propertyId = $(this).data('id');
            
            // Trouver le marqueur correspondant et ouvrir sa popup
            markers.eachLayer(function(layer) {
                if (layer.propertyId === propertyId) {
                    map.setView(layer.getLatLng(), 14);
                    layer.openPopup();
                }
            });
        });
        }
    });
</script>

<style>
    /* Style pour le conteneur de la carte */
    .map-container {
        width: 100%;
        height: 700px;
        position: relative;
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    /* Style pour la carte elle-même */
    #property-map {
        width: 100%;
        height: 700px;
        z-index: 1;
    }
    
    .property-list-container {
        max-height: 500px;
        overflow-y: auto;
        padding-right: 10px;
    }
    
    .property-item {
        margin-bottom: 15px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .property-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .property-popup {
        width: 300px;
    }
    
    .property-features {
        display: flex;
        justify-content: space-between;
        margin-top: 10px;
    }
    
    .property-features span {
        font-size: 12px;
    }
    
    /* Style pour le slider de rayon */
    input[type=range] {
        width: 100%;
    }
    
    #radius_value {
        display: inline-block;
        width: 100%;
        text-align: center;
        font-weight: bold;
    }
    
    /* Style pour les marqueurs de la carte */
    .leaflet-marker-icon {
        transition: transform 0.3s ease;
    }
    
    .leaflet-marker-icon:hover {
        transform: scale(1.2);
    }
    
    /* Style pour les popups */
    .leaflet-popup-content {
        padding: 5px;
    }
</style>
@endsection
