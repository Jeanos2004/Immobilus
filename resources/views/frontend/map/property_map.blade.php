@extends('frontend.frontend_dashboard')

@section('title')
Carte interactive des propriétés | Immobilus
@endsection

@section('head')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<!-- MarkerCluster CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css" />
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
<!-- Animate.css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
@endsection

@section('content')

<section class="page-title-two bg-color-1 centred">
    <div class="pattern-layer">
        <div class="pattern-1" style="background-image: url({{ asset('frontend/assets/images/shape/shape-9.png') }});"></div>
        <div class="pattern-2" style="background-image: url({{ asset('frontend/assets/images/shape/shape-10.png') }});"></div>
    </div>
    <div class="auto-container">
        <div class="content-box clearfix">
            <h1>Carte interactive des propriétés</h1>
            <ul class="bread-crumb clearfix">
                <li><a href="{{ url('/') }}">Accueil</a></li>
                <li>Carte interactive</li>
            </ul>
        </div>
    </div>
</section>

<section class="property-page-section property-list sec-pad">
    <div class="auto-container">
        <div class="row clearfix">
            <div class="col-lg-4 col-md-12 col-sm-12 sidebar-side">
                <div class="default-sidebar property-sidebar">
                    <div class="filter-widget sidebar-widget">
                        <div class="widget-title">
                            <h5><i class="fas fa-filter"></i> Filtres</h5>
                        </div>
                        <div class="widget-content">
                            <form id="mapFilterForm" class="filter-form">
                                <div class="form-group">
                                    <label><i class="fas fa-home"></i> Type de propriété</label>
                                    <div class="select-box">
                                        <select class="form-control wide" name="property_type" id="property_type">
                                            <option value="">Tous les types</option>
                                            @foreach($propertyTypes as $type)
                                                <option value="{{ $type->id }}">{{ $type->type_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label><i class="fas fa-tag"></i> Statut</label>
                                    <div class="select-box">
                                        <select class="form-control wide" name="status" id="property_status">
                                            <option value="">Tous</option>
                                            <option value="rent">Location</option>
                                            <option value="sale">Vente</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="price-filters">
                                    <label><i class="fas fa-euro-sign"></i> Fourchette de prix</label>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <div class="field-input">
                                                    <input type="number" class="form-control" name="min_price" id="min_price" placeholder="Prix min">
                                                    <i class="fas fa-euro-sign"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <div class="field-input">
                                                    <input type="number" class="form-control" name="max_price" id="max_price" placeholder="Prix max">
                                                    <i class="fas fa-euro-sign"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label><i class="fas fa-bed"></i> Chambres (min)</label>
                                    <div class="select-box">
                                        <select class="form-control wide" name="bedrooms" id="bedrooms">
                                            <option value="">Indifférent</option>
                                            <option value="1">1+</option>
                                            <option value="2">2+</option>
                                            <option value="3">3+</option>
                                            <option value="4">4+</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label><i class="fas fa-bath"></i> Salles de bain (min)</label>
                                    <div class="select-box">
                                        <select class="form-control wide" name="bathrooms" id="bathrooms">
                                            <option value="">Indifférent</option>
                                            <option value="1">1+</option>
                                            <option value="2">2+</option>
                                            <option value="3">3+</option>
                                            <option value="4">4+</option>
                                        </select>
                                    </div>
                                </div>

                                <hr>

                                <div class="address-search-box">
                                    <div class="widget-title mt-4">
                                        <h5><i class="fas fa-search-location"></i> Recherche par adresse</h5>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Adresse</label>
                                        <div class="field-input">
                                            <input type="text" class="form-control" id="address_search" placeholder="Entrez une adresse">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Rayon de recherche: <span id="radius_value" class="text-primary">10 km</span></label>
                                        <input type="range" class="form-control-range custom-range" id="radius" min="1" max="50" value="10">
                                        <div class="range-labels d-flex justify-content-between">
                                            <small>1 km</small>
                                            <small>25 km</small>
                                            <small>50 km</small>
                                        </div>
                                    </div>

                                    <div class="form-group mt-4">
                                        <button type="button" id="searchByAddressBtn" class="theme-btn btn-one w-100">
                                            <i class="fas fa-search"></i> Rechercher par adresse
                                        </button>
                                    </div>
                                </div>

                            <hr>

                            <div class="action-buttons d-flex justify-content-between mt-4">
                                <button type="button" id="applyFiltersBtn" class="theme-btn btn-one flex-grow-1 me-2">
                                    <i class="fas fa-filter"></i> Appliquer
                                </button>

                                <button type="button" id="resetMapBtn" class="theme-btn btn-two flex-grow-1">
                                    <i class="fas fa-redo"></i> Réinitialiser
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="category-widget sidebar-widget">
                    <div class="widget-title">
                        <h5><i class="fas fa-list"></i> Propriétés trouvées (<span id="property_count" class="text-primary">{{ count($mapData) }}</span>)</h5>
                    </div>
                    <div id="property_list" class="property-list-container custom-scrollbar">
                        @foreach($properties as $property)
                            @if(!empty($property->latitude) && !empty($property->longitude))
                            <div class="property-item animate__animated animate__fadeIn" data-id="{{ $property->id }}">
                                <div class="property-image">
                                    <img src="{{ asset($property->property_thumbnail) }}" alt="{{ $property->property_name }}">
                                    <span class="property-badge">{{ $property->property_status }}</span>
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

            <div class="col-lg-8 col-md-12 col-sm-12 content-side">
                <div class="map-outer">
                    <div class="map-canvas">
                        <div id="property-map" style="height: 700px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);"></div>
                    </div>
                    <div class="map-controls">
                        <div class="control-panel">
                            <button id="zoomInBtn" class="control-btn"><i class="fas fa-plus"></i></button>
                            <button id="zoomOutBtn" class="control-btn"><i class="fas fa-minus"></i></button>
                            <button id="recenterBtn" class="control-btn"><i class="fas fa-location-arrow"></i></button>
                        </div>
                    </div>
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
        var map = L.map('property-map', {
            zoomControl: false // Désactiver les contrôles de zoom par défaut
        }).setView([46.603354, 1.888334], 6); // Centre sur la France
        
        // Sauvegarder la vue initiale pour le recentrage
        var initialView = {
            center: [46.603354, 1.888334],
            zoom: 6
        };

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
                    <div class="popup-property">
                        <div class="popup-image">
                            <img src="{{ asset('') }}${property.thumbnail}" alt="${property.name}" style="width: 100%; max-height: 150px; object-fit: cover;">
                        </div>
                        <div class="popup-content">
                            <h4 class="popup-title">${property.name}</h4>
                            <div class="popup-meta">
                                <span><i class="fas fa-bed"></i> ${property.bedrooms}</span>
                                <span><i class="fas fa-bath"></i> ${property.bathrooms}</span>
                                <span><i class="fas fa-ruler-combined"></i> ${property.size} m²</span>
                            </div>
                            <div class="popup-price">${property.status === 'rent' ? property.price + ' € / mois' : property.price + ' €'}</div>
                            ${property.distance ? '<p class="distance-info"><i class="fas fa-map-marker-alt"></i> Distance: ' + property.distance + '</p>' : ''}
                            <a href="${property.url}" class="theme-btn btn-two btn-sm w-100 mt-2">Voir détails</a>
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
        
        // Contrôles de la carte personnalisés
        $('#zoomInBtn').on('click', function() {
            map.zoomIn();
        });
        
        $('#zoomOutBtn').on('click', function() {
            map.zoomOut();
        });
        
        $('#recenterBtn').on('click', function() {
            map.setView(initialView.center, initialView.zoom);
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
