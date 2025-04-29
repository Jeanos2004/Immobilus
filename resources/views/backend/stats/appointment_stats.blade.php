@extends('admin.admin_dashboard')
@section('admin')

<div class="page-content">
    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Tableau de bord des rendez-vous</h4>
                    <p class="card-description">Vue d'ensemble des statistiques de rendez-vous</p>
                    
                    <!-- Statistiques générales -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total des rendez-vous</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total'] }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                En attente</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['pending'] }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Confirmés</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['confirmed'] }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                Annulés</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['cancelled'] }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Terminés</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['completed'] }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-check-square fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Taux de conversion</div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $conversionRate }}%</div>
                                                </div>
                                                <div class="col">
                                                    <div class="progress progress-sm mr-2">
                                                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $conversionRate }}%" aria-valuenow="{{ $conversionRate }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                Taux d'annulation</div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $cancellationRate }}%</div>
                                                </div>
                                                <div class="col">
                                                    <div class="progress progress-sm mr-2">
                                                        <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $cancellationRate }}%" aria-valuenow="{{ $cancellationRate }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Graphique des rendez-vous par mois -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Rendez-vous par mois</h6>
                                </div>
                                <div class="card-body">
                                    <div class="chart-area">
                                        <canvas id="appointmentsByMonthChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <!-- Top agents -->
                        <div class="col-md-6">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Top 5 des agents</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Agent</th>
                                                    <th>Total</th>
                                                    <th>Terminés</th>
                                                    <th>Taux</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($topAgents as $agent)
                                                <tr>
                                                    <td>{{ $agent->name }}</td>
                                                    <td>{{ $agent->total_appointments }}</td>
                                                    <td>{{ $agent->completed_appointments }}</td>
                                                    <td>
                                                        @php
                                                            $rate = $agent->total_appointments > 0 ? round(($agent->completed_appointments / $agent->total_appointments) * 100, 2) : 0;
                                                        @endphp
                                                        {{ $rate }}%
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Top propriétés -->
                        <div class="col-md-6">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Top 5 des propriétés</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Propriété</th>
                                                    <th>Type</th>
                                                    <th>Visites</th>
                                                    <th>Terminées</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($topProperties as $property)
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('property.details', $property->id) }}" target="_blank">
                                                            {{ $property->property_name }}
                                                        </a>
                                                    </td>
                                                    <td>{{ $property->propertyType->type_name }}</td>
                                                    <td>{{ $property->total_appointments }}</td>
                                                    <td>{{ $property->completed_appointments }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Rendez-vous à venir -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Rendez-vous à venir (7 prochains jours)</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Client</th>
                                                    <th>Agent</th>
                                                    <th>Propriété</th>
                                                    <th>Statut</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($upcomingAppointments as $appointment)
                                                <tr>
                                                    <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y H:i') }}</td>
                                                    <td>{{ $appointment->user->name }}</td>
                                                    <td>{{ $appointment->agent->name }}</td>
                                                    <td>
                                                        <a href="{{ route('property.details', $appointment->property->id) }}" target="_blank">
                                                            {{ $appointment->property->property_name }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        @if($appointment->status == 'pending')
                                                            <span class="badge bg-warning">En attente</span>
                                                        @elseif($appointment->status == 'confirmed')
                                                            <span class="badge bg-success">Confirmé</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('change.status.appointment', [$appointment->id, 'confirmed']) }}" class="btn btn-sm btn-success">Confirmer</a>
                                                        <a href="{{ route('change.status.appointment', [$appointment->id, 'cancelled']) }}" class="btn btn-sm btn-danger">Annuler</a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                
                                                @if($upcomingAppointments->isEmpty())
                                                <tr>
                                                    <td colspan="6" class="text-center">Aucun rendez-vous à venir dans les 7 prochains jours</td>
                                                </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
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

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Données pour le graphique des rendez-vous par mois
    const appointmentsByMonthData = {
        labels: @json($appointmentsByMonth['months']),
        datasets: [
            {
                label: 'En attente',
                backgroundColor: '#ffc107',
                borderColor: '#ffc107',
                data: @json($appointmentsByMonth['pending']),
            },
            {
                label: 'Confirmés',
                backgroundColor: '#28a745',
                borderColor: '#28a745',
                data: @json($appointmentsByMonth['confirmed']),
            },
            {
                label: 'Annulés',
                backgroundColor: '#dc3545',
                borderColor: '#dc3545',
                data: @json($appointmentsByMonth['cancelled']),
            },
            {
                label: 'Terminés',
                backgroundColor: '#17a2b8',
                borderColor: '#17a2b8',
                data: @json($appointmentsByMonth['completed']),
            }
        ]
    };

    // Configuration du graphique
    const appointmentsByMonthConfig = {
        type: 'bar',
        data: appointmentsByMonthData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Rendez-vous par mois'
                }
            },
            scales: {
                x: {
                    stacked: false,
                },
                y: {
                    stacked: false,
                    beginAtZero: true
                }
            }
        }
    };

    // Création du graphique
    window.addEventListener('load', function() {
        const appointmentsByMonthCtx = document.getElementById('appointmentsByMonthChart').getContext('2d');
        new Chart(appointmentsByMonthCtx, appointmentsByMonthConfig);
    });
</script>
@endsection
