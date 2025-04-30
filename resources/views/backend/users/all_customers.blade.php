@extends('admin.admin_dashboard')
@section('content')

<div class="page-content">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="card-title mb-0">Tous les clients</h6>
                        <a href="{{ route('add.user') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Ajouter un client
                        </a>
                    </div>
                    
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Photo</th>
                                    <th>Nom</th>
                                    <th>Email</th>
                                    <th>Téléphone</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customers as $key => $item)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>
                                        <img class="wd-30 rounded-circle" 
                                            src="{{ (!empty($item->photo)) ? asset('uploads/user_images/'.$item->photo) : asset('uploads/no_image.jpg') }}" 
                                            alt="Photo de profil">
                                    </td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->phone }}</td>
                                    <td>
                                        @if($item->status == 'active')
                                            <span class="badge bg-success">Actif</span>
                                        @else
                                            <span class="badge bg-danger">Inactif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Actions
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="{{ route('view.user', $item->id) }}">
                                                    <i class="fas fa-eye text-info"></i> Voir
                                                </a>
                                                <a class="dropdown-item" href="{{ route('edit.user', $item->id) }}">
                                                    <i class="fas fa-edit text-primary"></i> Modifier
                                                </a>
                                                <a class="dropdown-item" href="{{ route('change.status.user', $item->id) }}">
                                                    @if($item->status == 'active')
                                                        <i class="fas fa-user-slash text-warning"></i> Désactiver
                                                    @else
                                                        <i class="fas fa-user-check text-success"></i> Activer
                                                    @endif
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="{{ route('delete.user', $item->id) }}" id="delete">
                                                    <i class="fas fa-trash text-danger"></i> Supprimer
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-center mt-3">
                        {{ $customers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
