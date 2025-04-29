@extends('admin.admin_dashboard')
@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<div class="page-content">
    <div class="row profile-body">
        <div class="col-md-12 col-xl-12 middle-wrapper">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Modifier la propriété</h6>

                        <form method="POST" action="{{ route('update.property') }}">
                            @csrf

                            <input type="hidden" name="id" value="{{ $property->id }}">

                            <div class="row">
                                <!-- Première colonne -->
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Nom de la propriété</label>
                                        <input type="text" name="property_name" class="form-control" value="{{ $property->property_name }}" required>
                                    </div>
                                </div>

                                <!-- Deuxième colonne -->
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Type de propriété</label>
                                        <select name="ptype_id" class="form-select" required>
                                            <option selected disabled>Sélectionner un type</option>
                                            @foreach($propertyTypes as $type)
                                                <option value="{{ $type->id }}" {{ $type->id == $property->ptype_id ? 'selected' : '' }}>{{ $type->type_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Prix minimum</label>
                                        <input type="text" name="lowest_price" class="form-control" value="{{ $property->lowest_price }}" required>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Prix maximum</label>
                                        <input type="text" name="max_price" class="form-control" value="{{ $property->max_price }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Image principale</label>
                                        <img src="{{ asset($property->property_thumbnail) }}" style="width:100px; height:100px;" alt="">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Agent</label>
                                        <select name="agent_id" class="form-select" required>
                                            <option selected disabled>Sélectionner un agent</option>
                                            @foreach($activeAgents as $agent)
                                                <option value="{{ $agent->id }}" {{ $agent->id == $property->agent_id ? 'selected' : '' }}>{{ $agent->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">Chambres</label>
                                        <input type="text" name="bedrooms" class="form-control" value="{{ $property->bedrooms }}" required>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">Salles de bain</label>
                                        <input type="text" name="bathrooms" class="form-control" value="{{ $property->bathrooms }}" required>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">Garage</label>
                                        <input type="text" name="garage" class="form-control" value="{{ $property->garage }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">Taille du garage</label>
                                        <input type="text" name="garage_size" class="form-control" value="{{ $property->garage_size }}">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">Adresse</label>
                                        <input type="text" name="address" class="form-control" value="{{ $property->address }}" required>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">Ville</label>
                                        <input type="text" name="city" class="form-control" value="{{ $property->city }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">État/Région</label>
                                        <input type="text" name="state" class="form-control" value="{{ $property->state }}">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">Code postal</label>
                                        <input type="text" name="postal_code" class="form-control" value="{{ $property->postal_code }}" required>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">Taille de la propriété</label>
                                        <input type="text" name="property_size" class="form-control" value="{{ $property->property_size }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Vidéo de la propriété (lien)</label>
                                        <input type="text" name="property_video" class="form-control" value="{{ $property->property_video }}">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Quartier</label>
                                        <input type="text" name="neighborhood" class="form-control" value="{{ $property->neighborhood }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Latitude</label>
                                        <input type="text" name="latitude" class="form-control" value="{{ $property->latitude }}">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Longitude</label>
                                        <input type="text" name="longitude" class="form-control" value="{{ $property->longitude }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">Statut de la propriété</label>
                                        <select name="property_status" class="form-select" required>
                                            <option selected disabled>Sélectionner un statut</option>
                                            <option value="à vendre" {{ $property->property_status == 'à vendre' ? 'selected' : '' }}>À vendre</option>
                                            <option value="à louer" {{ $property->property_status == 'à louer' ? 'selected' : '' }}>À louer</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-check mb-3">
                                        <input type="checkbox" name="featured" value="1" class="form-check-input" id="featured" {{ $property->featured == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="featured">
                                            Propriété en vedette
                                        </label>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-check mb-3">
                                        <input type="checkbox" name="hot" value="1" class="form-check-input" id="hot" {{ $property->hot == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="hot">
                                            Hot Deal
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">Description courte</label>
                                        <textarea class="form-control" name="short_description" rows="3" required>{{ $property->short_description }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">Description longue</label>
                                        <textarea class="form-control" name="long_description" id="tinymceExample" rows="10" required>{{ $property->long_description }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Mettre à jour</button>
                        </form>

                        <!-- Formulaire pour mettre à jour l'image principale -->
                        <hr>
                        <h6 class="card-title">Mettre à jour l'image principale</h6>
                        <form method="POST" action="{{ route('update.property.thumbnail') }}" enctype="multipart/form-data">
                            @csrf
                            
                            <input type="hidden" name="id" value="{{ $property->id }}">
                            <input type="hidden" name="old_img" value="{{ $property->property_thumbnail }}">

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Nouvelle image principale</label>
                                        <input type="file" name="property_thumbnail" class="form-control" onChange="mainThumbnailUrl(this)" required>
                                        <img src="" id="mainThumb" alt="">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Image actuelle</label>
                                        <img src="{{ asset($property->property_thumbnail) }}" style="width:100px; height:100px;" alt="">
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Mettre à jour l'image</button>
                        </form>

                        <!-- Formulaire pour mettre à jour les aménités -->
                        <hr>
                        <h6 class="card-title">Mettre à jour les aménités</h6>
                        <form method="POST" action="{{ route('update.property.amenities') }}">
                            @csrf
                            
                            <input type="hidden" name="id" value="{{ $property->id }}">

                            <div class="row">
                                @foreach($amenities as $amenity)
                                <div class="col-sm-3">
                                    <div class="form-check mb-2">
                                        <input type="checkbox" name="amenities_id[]" value="{{ $amenity->id }}" class="form-check-input" id="amenity{{ $amenity->id }}"
                                        {{ in_array($amenity->id, $property_amenities) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="amenity{{ $amenity->id }}">
                                            {{ $amenity->amenities_name }}
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <button type="submit" class="btn btn-primary">Mettre à jour les aménités</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script pour prévisualiser l'image -->
<script type="text/javascript">
    function mainThumbnailUrl(input){
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e){
                $('#mainThumb').attr('src',e.target.result).width(80).height(80);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

@endsection
