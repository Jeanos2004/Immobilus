@extends('admin.admin_dashboard')
@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Tableau de bord</a></li>
        <li class="breadcrumb-item"><a href="{{ route('all.appointments') }}">Tous les rendez-vous</a></li>
        <li class="breadcrumb-item active" aria-current="page">Rendez-vous terminés</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Rendez-vous terminés</h6>
                
                <div class="table-responsive">
                    <table id="dataTableExample" class="table">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Propriété</th>
                                <th>Client</th>
                                <th>Agent</th>
                                <th>Date</th>
                                <th>Message</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($appointments as $key => $item)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>
                                    <a href="{{ route('property.details', [$item->property->id, $item->property->property_slug]) }}" target="_blank">
                                        {{ $item->property->property_name }}
                                    </a>
                                </td>
                                <td>{{ $item->user->name }}</td>
                                <td>{{ $item->agent->name }}</td>
                                <td>{{ Carbon\Carbon::parse($item->appointment_date)->format('d/m/Y H:i') }}</td>
                                <td>{{ Str::limit($item->message, 30) }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Actions
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item text-danger" href="{{ route('delete.appointment', $item->id) }}" id="delete">Supprimer</a>
                                        </div>
                                    </div>
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
