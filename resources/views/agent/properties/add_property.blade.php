@extends('agent.agent_dashboard')
@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<div class="page-content">
    <div class="row profile-body">
        <div class="col-md-12 col-xl-12 middle-wrapper">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Ajouter une nouvelle propriété</h6>

                        <form method="POST" action="{{ route('agent.property.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Nom de la propriété</label>
                                        <input type="text" name="property_name" class="form-control" value="{{ old('property_name') }}" required>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Type de propriété</label>
                                        <select name="ptype_id" class="form-select" required>
                                            <option selected disabled>Sélectionner un type</option>
                                            @foreach($propertyTypes as $type)
                                                <option value="{{ $type->id }}" @selected(old('ptype_id') == $type->id)>{{ $type->type_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Prix minimum</label>
                                        <input type="text" name="lowest_price" class="form-control" value="{{ old('lowest_price') }}" required>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Prix maximum</label>
                                        <input type="text" name="max_price" class="form-control" value="{{ old('max_price') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Image principale</label>
                                        <input type="file" name="property_thumbnail" class="form-control" onChange="mainThumbnailUrl(this)" required>
                                        <img src="" id="mainThumb" alt="" class="mt-2 rounded" style="display:none;">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Statut de la propriété</label>
                                        <select name="property_status" class="form-select" required>
                                            <option value="à vendre" @selected(old('property_status') == 'à vendre')>À vendre</option>
                                            <option value="à louer" @selected(old('property_status') == 'à louer')>À louer</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">Chambres</label>
                                        <input type="number" name="bedrooms" class="form-control" value="{{ old('bedrooms') }}" required>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">Salles de bain</label>
                                        <input type="number" name="bathrooms" class="form-control" value="{{ old('bathrooms') }}" required>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">Garage</label>
                                        <input type="number" name="garage" class="form-control" value="{{ old('garage') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">Taille du garage</label>
                                        <input type="text" name="garage_size" class="form-control" value="{{ old('garage_size') }}">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">Adresse</label>
                                        <input type="text" name="address" class="form-control" value="{{ old('address') }}" required>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">Ville</label>
                                        <input type="text" name="city" class="form-control" value="{{ old('city') }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">État/Région</label>
                                        <input type="text" name="state" class="form-control" value="{{ old('state') }}">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">Code postal</label>
                                        <input type="text" name="postal_code" class="form-control" value="{{ old('postal_code') }}" required>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">Taille de la propriété</label>
                                        <input type="text" name="property_size" class="form-control" value="{{ old('property_size') }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Vidéo (lien)</label>
                                        <input type="text" name="property_video" class="form-control" value="{{ old('property_video') }}">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Quartier</label>
                                        <input type="text" name="neighborhood" class="form-control" value="{{ old('neighborhood') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Latitude</label>
                                        <input type="text" name="latitude" class="form-control" value="{{ old('latitude') }}">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Longitude</label>
                                        <input type="text" name="longitude" class="form-control" value="{{ old('longitude') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-check mb-3">
                                        <input type="checkbox" name="featured" value="1" class="form-check-input" id="featured" @checked(old('featured'))>
                                        <label class="form-check-label" for="featured">Propriété en vedette</label>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-check mb-3">
                                        <input type="checkbox" name="hot" value="1" class="form-check-input" id="hot" @checked(old('hot'))>
                                        <label class="form-check-label" for="hot">Hot Deal</label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description courte</label>
                                <textarea class="form-control" name="short_description" rows="3" required>{{ old('short_description') }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description longue</label>
                                <textarea class="form-control" name="long_description" rows="8" required>{{ old('long_description') }}</textarea>
                            </div>

                            <hr>

                            <div class="mb-3">
                                <label class="form-label">Aménités</label>
                                <div class="row">
                                    @foreach($amenities as $amenity)
                                    <div class="col-sm-3">
                                        <div class="form-check mb-2">
                                            <input type="checkbox" name="amenities_id[]" value="{{ $amenity->id }}" class="form-check-input" id="amenity{{ $amenity->id }}" @checked(collect(old('amenities_id'))->contains($amenity->id))>
                                            <label class="form-check-label" for="amenity{{ $amenity->id }}">
                                                {{ $amenity->amenities_name }}
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function mainThumbnailUrl(input){
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e){
                $('#mainThumb').attr('src',e.target.result).width(80).height(80).show();
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

@endsection

