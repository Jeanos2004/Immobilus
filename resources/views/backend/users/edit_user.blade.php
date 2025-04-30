@extends('admin.admin_dashboard')
@section('content')

<div class="page-content">
    <div class="row profile-body">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Modifier l'utilisateur</h6>
                    
                    <form method="POST" action="{{ route('update.user', $user->id) }}" class="forms-sample" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nom complet</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $user->name }}" placeholder="Nom complet">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Nom d'utilisateur</label>
                                    <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ $user->username }}" placeholder="Nom d'utilisateur">
                                    @error('username')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $user->email }}" placeholder="Email">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Téléphone</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ $user->phone }}" placeholder="Téléphone">
                                    @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Mot de passe <small class="text-muted">(Laisser vide pour conserver l'actuel)</small></label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Nouveau mot de passe">
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="address" class="form-label">Adresse</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ $user->address }}" placeholder="Adresse">
                                    @error('address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="role" class="form-label">Rôle</label>
                                    <select class="form-select @error('role') is-invalid @enderror" id="role" name="role">
                                        <option value="">Sélectionner un rôle</option>
                                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="agent" {{ $user->role == 'agent' ? 'selected' : '' }}>Agent</option>
                                        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Utilisateur</option>
                                    </select>
                                    @error('role')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Statut</label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                        <option value="">Sélectionner un statut</option>
                                        <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Actif</option>
                                        <option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>Inactif</option>
                                    </select>
                                    @error('status')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="photo" class="form-label">Photo de profil</label>
                                    <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo" onchange="previewImage(this)">
                                    @error('photo')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <img id="showImage" class="rounded-circle" style="width:100px; height:100px; object-fit:cover;" 
                                    src="{{ (!empty($user->photo)) ? asset('uploads/user_images/'.$user->photo) : asset('uploads/no_image.jpg') }}" 
                                    alt="Photo de profil">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary me-2">Mettre à jour</button>
                                <a href="{{ route('all.users') }}" class="btn btn-secondary">Annuler</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#showImage').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

@endsection
