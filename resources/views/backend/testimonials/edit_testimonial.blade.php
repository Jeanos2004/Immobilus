@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">
        
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Modifier un témoignage</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Témoignages</a></li>
                            <li class="breadcrumb-item active">Modifier</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Formulaire de modification de témoignage</h4>
                        
                        <form method="post" action="{{ route('update.testimonial') }}" enctype="multipart/form-data">
                            @csrf
                            
                            <input type="hidden" name="id" value="{{ $testimonial->id }}">
                            
                            <div class="row mb-3">
                                <label for="name" class="col-sm-2 col-form-label">Nom</label>
                                <div class="col-sm-10">
                                    <input name="name" class="form-control" type="text" id="name" placeholder="Nom du client" value="{{ $testimonial->name }}" required>
                                    @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- end row -->
                            
                            <div class="row mb-3">
                                <label for="position" class="col-sm-2 col-form-label">Position</label>
                                <div class="col-sm-10">
                                    <input name="position" class="form-control" type="text" id="position" placeholder="Poste ou fonction" value="{{ $testimonial->position }}" required>
                                    @error('position')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- end row -->
                            
                            <div class="row mb-3">
                                <label for="message" class="col-sm-2 col-form-label">Message</label>
                                <div class="col-sm-10">
                                    <textarea name="message" class="form-control" id="message" rows="5" placeholder="Témoignage du client" required>{{ $testimonial->message }}</textarea>
                                    @error('message')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- end row -->
                            
                            <div class="row mb-3">
                                <label for="rating" class="col-sm-2 col-form-label">Évaluation</label>
                                <div class="col-sm-10">
                                    <select name="rating" class="form-select" id="rating" required>
                                        <option value="" disabled>Sélectionnez une évaluation</option>
                                        <option value="1" {{ $testimonial->rating == 1 ? 'selected' : '' }}>1 étoile</option>
                                        <option value="2" {{ $testimonial->rating == 2 ? 'selected' : '' }}>2 étoiles</option>
                                        <option value="3" {{ $testimonial->rating == 3 ? 'selected' : '' }}>3 étoiles</option>
                                        <option value="4" {{ $testimonial->rating == 4 ? 'selected' : '' }}>4 étoiles</option>
                                        <option value="5" {{ $testimonial->rating == 5 ? 'selected' : '' }}>5 étoiles</option>
                                    </select>
                                    @error('rating')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- end row -->
                            
                            <div class="row mb-3">
                                <label for="photo" class="col-sm-2 col-form-label">Photo</label>
                                <div class="col-sm-10">
                                    <input name="photo" class="form-control" type="file" id="photo" accept="image/*">
                                    @error('photo')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <div class="mt-3">
                                        <img id="showImage" class="rounded avatar-lg" src="{{ !empty($testimonial->photo) ? url($testimonial->photo) : url('upload/no_image.jpg') }}" alt="Photo du client">
                                    </div>
                                </div>
                            </div>
                            <!-- end row -->
                            
                            <div class="row mb-3">
                                <label for="status" class="col-sm-2 col-form-label">Statut</label>
                                <div class="col-sm-10">
                                    <div class="form-check form-switch form-switch-lg" dir="ltr">
                                        <input type="checkbox" class="form-check-input" id="status" name="status" value="1" {{ $testimonial->status == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status">Actif</label>
                                    </div>
                                </div>
                            </div>
                            <!-- end row -->
                            
                            <div class="row">
                                <div class="col-sm-10 offset-sm-2">
                                    <button type="submit" class="btn btn-primary">Mettre à jour le témoignage</button>
                                    <a href="{{ route('all.testimonials') }}" class="btn btn-secondary">Annuler</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
        
    </div> <!-- container-fluid -->
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#photo').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e){
                $('#showImage').attr('src',e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        });
    });
</script>

@endsection
