@extends('dashboard')
@section('content')

<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">Mes rendez-vous</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
                <li class="breadcrumb-item active">Rendez-vous</li>
            </ul>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Mes demandes de rendez-vous</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-center mb-0">
                        <thead>
                            <tr>
                                <th>Propriété</th>
                                <th>Agent</th>
                                <th>Date</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($appointments as $appointment)
                            <tr>
                                <td>
                                    <a href="{{ route('property.details', [$appointment->property->id, $appointment->property->property_slug]) }}" target="_blank">
                                        {{ $appointment->property->property_name }}
                                    </a>
                                </td>
                                <td>{{ $appointment->agent->name }}</td>
                                <td>{{ Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y H:i') }}</td>
                                <td>
                                    @if($appointment->status == 'pending')
                                        <span class="badge bg-warning">En attente</span>
                                    @elseif($appointment->status == 'confirmed')
                                        <span class="badge bg-success">Confirmé</span>
                                    @elseif($appointment->status == 'cancelled')
                                        <span class="badge bg-danger">Annulé</span>
                                    @else
                                        <span class="badge bg-info">Terminé</span>
                                    @endif
                                </td>
                                <td>
                                    @if($appointment->status == 'pending' || $appointment->status == 'confirmed')
                                    <a href="{{ route('cancel.appointment', $appointment->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir annuler ce rendez-vous ?')">
                                        Annuler
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Vous n'avez pas encore de rendez-vous.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
