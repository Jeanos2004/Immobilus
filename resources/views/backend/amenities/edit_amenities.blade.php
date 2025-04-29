@extends('admin.admin_dashboard')
@section('content')
<!-- middle wrapper start -->
<div class="col-md-8 col-xl-8 middle-wrapper">
    <div class="row">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Modifier une aménité</h6>

                <form action="{{ route('update.amenitie') }}" method="POST" class="forms-sample">
                    @csrf
                    <input type="hidden" name="id" value="{{ $amenity->id }}">
                    
                    <div class="mb-3">
                        <label for="amenities_name" class="form-label">Nom de l'aménité</label>
                        <input type="text" name="amenities_name" class="form-control @error('amenities_name') is-invalid @enderror" value="{{ $amenity->amenities_name }}">
                        @error('amenities_name')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary me-2">Enregistrer les modifications</button>
                    <a href="{{ route('all.amenitie') }}" class="btn btn-secondary">Annuler</a>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- middle wrapper end -->
@endsection
