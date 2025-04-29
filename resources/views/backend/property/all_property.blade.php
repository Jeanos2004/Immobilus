@extends('admin.admin_dashboard')
@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <a href="{{ route('add.property') }}" class="btn btn-inverse-info">Ajouter une propriété</a>
    </ol>
</nav>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Liste des propriétés</h6>

                <div class="table-responsive">
                    <table id="dataTableExample" class="table">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Image</th>
                                <th>Nom</th>
                                <th>Type</th>
                                <th>Statut</th>
                                <th>Ville</th>
                                <th>Code</th>
                                <th>Agent</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($properties as $key => $item)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>
                                    <img src="{{ asset($item->property_thumbnail) }}" style="width:70px; height:40px;">
                                </td>
                                <td>{{ $item->property_name }}</td>
                                <td>{{ $item->type->type_name }}</td>
                                <td>
                                    @if($item->status == 1)
                                        <span class="badge rounded-pill bg-success">Active</span>
                                    @else
                                        <span class="badge rounded-pill bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ $item->city }}</td>
                                <td>{{ $item->property_code }}</td>
                                <td>{{ $item->user->name }}</td>
                                <td>
                                    <a href="{{ route('edit.property', $item->id) }}" class="btn btn-inverse-warning" title="Modifier"><i data-feather="edit"></i></a>
                                    
                                    <a href="{{ route('property.multi.image', $item->id) }}" class="btn btn-inverse-info" title="Gérer les images"><i data-feather="image"></i></a>
                                    
                                    <a href="{{ route('delete.property', $item->id) }}" id="delete" class="btn btn-inverse-danger" title="Supprimer"><i data-feather="trash-2"></i></a>
                                    
                                    @if($item->status == 1)
                                        <a href="{{ route('change.status.property', $item->id) }}" class="btn btn-inverse-primary" title="Désactiver"><i data-feather="thumbs-down"></i></a>
                                    @else
                                        <a href="{{ route('change.status.property', $item->id) }}" class="btn btn-inverse-success" title="Activer"><i data-feather="thumbs-up"></i></a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
