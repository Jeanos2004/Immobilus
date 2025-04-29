@extends('admin.admin_dashboard')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

<div class="page-content">
    <div class="row profile-body">
        <!-- Contenu principal -->
        <div class="col-md-12 col-xl-12 middle-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Gestion des images de la propriété : {{ $property->property_name }}</h6>
                            
                            <!-- Formulaire d'ajout d'images -->
                            <form method="post" action="{{ route('store.multi.image') }}" enctype="multipart/form-data">
                                @csrf
                                
                                <input type="hidden" name="property_id" value="{{ $property->id }}">
                                
                                <div class="mb-3">
                                    <label class="form-label">Ajouter des images à la galerie :</label>
                                    <input type="file" name="multi_img[]" class="form-control" multiple accept="image/*">
                                    @error('multi_img.*')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary">Ajouter les images</button>
                                </div>
                            </form>
                            
                            <!-- Affichage des images existantes -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <h6 class="card-title">Images existantes ({{ count($multiImages) }})</h6>
                                </div>
                                
                                @foreach($multiImages as $img)
                                <div class="col-md-3 mt-3">
                                    <div class="card">
                                        <img src="{{ asset($img->photo_name) }}" class="card-img-top" alt="Property Image" style="height: 200px; object-fit: cover;">
                                        <div class="card-body">
                                            <h5 class="card-title">Image #{{ $loop->iteration }}</h5>
                                            <a href="{{ route('delete.multi.image', $img->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette image ?')">Supprimer</a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                
                                @if(count($multiImages) == 0)
                                <div class="col-12 mt-3">
                                    <div class="alert alert-info">
                                        Aucune image supplémentaire n'a été ajoutée à cette propriété.
                                    </div>
                                </div>
                                @endif
                            </div>
                            
                            <!-- Bouton de retour -->
                            <div class="mt-4">
                                <a href="{{ route('all.property') }}" class="btn btn-secondary">Retour à la liste des propriétés</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        // Prévisualisation des images avant upload (fonctionnalité optionnelle)
        $('input[name="multi_img[]"]').on('change', function(e){
            var files = e.target.files;
            var previewContainer = $('<div class="row mt-3 preview-container"></div>');
            
            // Supprimer les prévisualisations précédentes
            $('.preview-container').remove();
            
            // Créer les prévisualisations pour chaque fichier
            for(var i = 0; i < files.length; i++){
                var reader = new FileReader();
                reader.onload = function(e){
                    previewContainer.append('<div class="col-md-2 mb-2"><img src="' + e.target.result + '" class="img-fluid" style="height: 100px; object-fit: cover;"></div>');
                }
                reader.readAsDataURL(files[i]);
            }
            
            // Ajouter les prévisualisations après l'input
            $(this).after(previewContainer);
        });
    });
</script>

@endsection
