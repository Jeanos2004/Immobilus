@extends('admin.admin_dashboard')
@section('admin')

<div class="page-content">
    <div class="container-fluid">
        
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Modifier un article</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Blog</a></li>
                            <li class="breadcrumb-item active">Modifier un article</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Modifier l'article</h4>
                        
                        <form method="post" action="{{ route('admin.blog.update', $post->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="row mb-3">
                                <label for="title" class="col-sm-2 col-form-label">Titre</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" id="title" name="title" value="{{ old('title', $post->title) }}" required>
                                    @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <label for="category_id" class="col-sm-2 col-form-label">Catégorie</label>
                                <div class="col-sm-10">
                                    <select class="form-select" id="category_id" name="category_id" required>
                                        <option value="">Sélectionner une catégorie</option>
                                        @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <label for="short_description" class="col-sm-2 col-form-label">Description courte</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" id="short_description" name="short_description" rows="3" required>{{ old('short_description', $post->short_description) }}</textarea>
                                    @error('short_description')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <label for="content" class="col-sm-2 col-form-label">Contenu</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" id="elm1" name="content">{{ old('content', $post->content) }}</textarea>
                                    @error('content')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <label for="featured_image" class="col-sm-2 col-form-label">Image à la une</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="file" id="featured_image" name="featured_image" accept="image/*">
                                    <small class="text-muted">Laissez vide pour conserver l'image actuelle</small>
                                    @error('featured_image')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <div class="mt-2">
                                        <img id="showImage" class="rounded" src="{{ asset($post->featured_image) }}" alt="Image à la une" width="200">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <label for="tags" class="col-sm-2 col-form-label">Tags</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" id="tags" name="tags" value="{{ old('tags', $post->tags) }}" placeholder="Séparez les tags par des virgules">
                                    <small class="text-muted">Exemple: immobilier, conseils, financement</small>
                                    @error('tags')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Statut</label>
                                <div class="col-sm-10">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="status1" value="1" {{ old('status', $post->status) == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status1">Publié</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="status0" value="0" {{ old('status', $post->status) == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status0">Brouillon</label>
                                    </div>
                                    @error('status')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Mettre en avant</label>
                                <div class="col-sm-10">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="featured" id="featured1" value="1" {{ old('featured', $post->featured) == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="featured1">Oui</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="featured" id="featured0" value="0" {{ old('featured', $post->featured) == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="featured0">Non</label>
                                    </div>
                                    @error('featured')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-sm-10 offset-sm-2">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">Mettre à jour l'article</button>
                                    <a href="{{ route('admin.blog.index') }}" class="btn btn-secondary waves-effect waves-light">Annuler</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function(){
        $('#featured_image').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e){
                $('#showImage').attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files[0]);
        });
    });
</script>
@endsection
