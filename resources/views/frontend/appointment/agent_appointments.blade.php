@extends('agent.agent_dashboard')
@section('content')

<div class="page-content">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="card-title mb-0">Mes rendez-vous</h6>
                        <a href="{{ route('agent.appointment.statistics') }}" class="btn btn-primary">
                            <i class="fas fa-chart-bar"></i> Voir les statistiques
                        </a>
                    </div>
                    
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Propriété</th>
                                    <th>Client</th>
                                    <th>Date</th>
                                    <th>Message</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($appointments as $key => $item)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>
                                        <a href="{{ route('property.details', [$item->property->id, $item->property->property_slug]) }}" target="_blank">
                                            {{ $item->property->property_name }}
                                        </a>
                                    </td>
                                    <td>{{ $item->user->name }}</td>
                                    <td>{{ Carbon\Carbon::parse($item->appointment_date)->format('d/m/Y H:i') }}</td>
                                    <td>{{ Str::limit($item->message, 30) }}</td>
                                    <td>
                                        @if($item->status == 'pending')
                                            <span class="badge bg-warning">En attente</span>
                                        @elseif($item->status == 'confirmed')
                                            <span class="badge bg-success">Confirmé</span>
                                        @elseif($item->status == 'cancelled')
                                            <span class="badge bg-danger">Annulé</span>
                                        @else
                                            <span class="badge bg-info">Terminé</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Actions
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                @if($item->status == 'pending')
                                                <a class="dropdown-item text-success" href="{{ route('agent.appointment.status', [$item->id, 'confirmed']) }}">Confirmer</a>
                                                <a class="dropdown-item text-danger" href="{{ route('agent.appointment.status', [$item->id, 'cancelled']) }}">Annuler</a>
                                                @elseif($item->status == 'confirmed')
                                                <a class="dropdown-item text-info" href="{{ route('agent.appointment.status', [$item->id, 'completed']) }}">Marquer comme terminé</a>
                                                <a class="dropdown-item text-danger" href="{{ route('agent.appointment.status', [$item->id, 'cancelled']) }}">Annuler</a>
                                                @endif
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
</div>

@endsection
