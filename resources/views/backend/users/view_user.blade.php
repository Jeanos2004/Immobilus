@extends('admin.admin_dashboard')
@section('content')

<div class="page-content">
    <div class="row profile-body">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h6 class="card-title mb-0">Détails de l'utilisateur</h6>
                        <div>
                            <a href="{{ route('edit.user', $user->id) }}" class="btn btn-primary btn-sm me-1">
                                <i class="fas fa-edit"></i> Modifier
                            </a>
                            <a href="{{ route('all.users') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Retour
                            </a>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 text-center mb-4">
                            <img class="rounded-circle mb-3" style="width:150px; height:150px; object-fit:cover;" 
                                src="{{ (!empty($user->photo)) ? asset('uploads/user_images/'.$user->photo) : asset('uploads/no_image.jpg') }}" 
                                alt="Photo de profil">
                            
                            <h4>{{ $user->name }}</h4>
                            <p class="text-muted">{{ $user->username }}</p>
                            
                            <div class="mt-3">
                                @if($user->role == 'admin')
                                    <span class="badge bg-danger">Administrateur</span>
                                @elseif($user->role == 'agent')
                                    <span class="badge bg-success">Agent immobilier</span>
                                @else
                                    <span class="badge bg-info">Utilisateur</span>
                                @endif
                                
                                @if($user->status == 'active')
                                    <span class="badge bg-success">Compte actif</span>
                                @else
                                    <span class="badge bg-danger">Compte inactif</span>
                                @endif
                            </div>
                            
                            <div class="mt-3">
                                <a href="{{ route('change.status.user', $user->id) }}" class="btn btn-outline-primary btn-sm">
                                    @if($user->status == 'active')
                                        <i class="fas fa-user-slash"></i> Désactiver le compte
                                    @else
                                        <i class="fas fa-user-check"></i> Activer le compte
                                    @endif
                                </a>
                            </div>
                        </div>
                        
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Informations personnelles</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <th width="30%">Nom complet</th>
                                                <td>{{ $user->name }}</td>
                                            </tr>
                                            <tr>
                                                <th>Nom d'utilisateur</th>
                                                <td>{{ $user->username }}</td>
                                            </tr>
                                            <tr>
                                                <th>Email</th>
                                                <td>{{ $user->email }}</td>
                                            </tr>
                                            <tr>
                                                <th>Téléphone</th>
                                                <td>{{ $user->phone ?? 'Non renseigné' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Adresse</th>
                                                <td>{{ $user->address ?? 'Non renseignée' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Rôle</th>
                                                <td>
                                                    @if($user->role == 'admin')
                                                        <span class="badge bg-danger">Administrateur</span>
                                                    @elseif($user->role == 'agent')
                                                        <span class="badge bg-success">Agent immobilier</span>
                                                    @else
                                                        <span class="badge bg-info">Utilisateur</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Statut</th>
                                                <td>
                                                    @if($user->status == 'active')
                                                        <span class="badge bg-success">Compte actif</span>
                                                    @else
                                                        <span class="badge bg-danger">Compte inactif</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Date d'inscription</th>
                                                <td>{{ $user->created_at->format('d/m/Y à H:i') }}</td>
                                            </tr>
                                            <tr>
                                                <th>Dernière mise à jour</th>
                                                <td>{{ $user->updated_at->format('d/m/Y à H:i') }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                            <div class="card mt-3">
                                <div class="card-header">
                                    <h5>Changer le rôle de l'utilisateur</h5>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('change.role.user', $user->id) }}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-8">
                                                <select class="form-select" name="role" required>
                                                    <option value="">Sélectionner un rôle</option>
                                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Administrateur</option>
                                                    <option value="agent" {{ $user->role == 'agent' ? 'selected' : '' }}>Agent immobilier</option>
                                                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Utilisateur</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <button type="submit" class="btn btn-primary">Changer le rôle</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
