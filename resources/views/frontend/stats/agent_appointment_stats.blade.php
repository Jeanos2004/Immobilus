@extends('frontend.dashboard')
@section('main')

<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Statistiques de mes rendez-vous</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('agent.appointments') }}">Mes rendez-vous</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Statistiques</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="row">
    <!-- Statistiques générales -->
    <div class="col-xl-3 mb-30">
        <div class="card-box height-100-p widget-style1 bg-white">
            <div class="d-flex flex-wrap align-items-center">
                <div class="widget-data">
                    <div class="h4 mb-0">{{ $stats['total'] }}</div>
                    <div class="weight-600 font-14">Total des rendez-vous</div>
                </div>
                <div class="widget-icon">
                    <div class="icon" data-color="#00eccf"><i class="icon-copy fa fa-calendar"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 mb-30">
        <div class="card-box height-100-p widget-style1 bg-white">
            <div class="d-flex flex-wrap align-items-center">
                <div class="widget-data">
                    <div class="h4 mb-0">{{ $stats['pending'] }}</div>
                    <div class="weight-600 font-14">En attente</div>
                </div>
                <div class="widget-icon">
                    <div class="icon" data-color="#ffc107"><i class="icon-copy fa fa-clock"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 mb-30">
        <div class="card-box height-100-p widget-style1 bg-white">
            <div class="d-flex flex-wrap align-items-center">
                <div class="widget-data">
                    <div class="h4 mb-0">{{ $stats['confirmed'] }}</div>
                    <div class="weight-600 font-14">Confirmés</div>
                </div>
                <div class="widget-icon">
                    <div class="icon" data-color="#28a745"><i class="icon-copy fa fa-check-circle"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 mb-30">
        <div class="card-box height-100-p widget-style1 bg-white">
            <div class="d-flex flex-wrap align-items-center">
                <div class="widget-data">
                    <div class="h4 mb-0">{{ $stats['completed'] }}</div>
                    <div class="weight-600 font-14">Terminés</div>
                </div>
                <div class="widget-icon">
                    <div class="icon" data-color="#17a2b8"><i class="icon-copy fa fa-check-square"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-6 mb-30">
        <div class="card-box height-100-p pd-20 bg-white">
            <div class="d-flex flex-wrap align-items-center pb-2 mb-2 border-bottom">
                <div class="h5 mb-0">Taux de conversion</div>
            </div>
            <div class="d-flex align-items-center justify-content-center">
                <div class="weight-600 font-24 text-success">{{ $conversionRate }}%</div>
            </div>
            <div class="progress" style="height: 20px;">
                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $conversionRate }}%;" aria-valuenow="{{ $conversionRate }}" aria-valuemin="0" aria-valuemax="100">{{ $conversionRate }}%</div>
            </div>
            <div class="text-center mt-2">
                <small class="text-muted">Pourcentage de rendez-vous terminés avec succès</small>
            </div>
        </div>
    </div>
    <div class="col-xl-6 mb-30">
        <div class="card-box height-100-p pd-20 bg-white">
            <div class="d-flex flex-wrap align-items-center pb-2 mb-2 border-bottom">
                <div class="h5 mb-0">Taux d'annulation</div>
            </div>
            <div class="d-flex align-items-center justify-content-center">
                <div class="weight-600 font-24 text-danger">{{ $cancellationRate }}%</div>
            </div>
            <div class="progress" style="height: 20px;">
                <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $cancellationRate }}%;" aria-valuenow="{{ $cancellationRate }}" aria-valuemin="0" aria-valuemax="100">{{ $cancellationRate }}%</div>
            </div>
            <div class="text-center mt-2">
                <small class="text-muted">Pourcentage de rendez-vous annulés</small>
            </div>
        </div>
    </div>
</div>

<div class="card-box mb-30">
    <div class="pd-20">
        <h4 class="text-blue h4">Évolution des rendez-vous</h4>
    </div>
    <div class="pb-20 px-4">
        <canvas id="appointmentsByMonthChart"></canvas>
    </div>
</div>

<div class="row">
    <!-- Top propriétés -->
    <div class="col-12 mb-30">
        <div class="card-box pd-20 bg-white">
            <div class="d-flex flex-wrap align-items-center pb-2 mb-2 border-bottom">
                <div class="h5 mb-0">Top 5 des propriétés les plus demandées</div>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Propriété</th>
                        <th>Type</th>
                        <th>Visites</th>
                        <th>Terminées</th>
                        <th>Actions</th>
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
                        <td>
                            <a href="{{ route('property.details', $property->id) }}" class="btn btn-sm btn-primary">Voir</a>
                        </td>
                    </tr>
                    @endforeach
                    
                    @if($topProperties->isEmpty())
                    <tr>
                        <td colspan="5" class="text-center">Aucune propriété avec des rendez-vous</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card-box mb-30">
    <div class="pd-20">
        <h4 class="text-blue h4">Rendez-vous à venir (7 prochains jours)</h4>
    </div>
    <div class="pb-20 px-4">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Client</th>
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
                    <td>
                        <a href="{{ route('property.details', $appointment->property->id) }}" target="_blank">
                            {{ $appointment->property->property_name }}
                        </a>
                    </td>
                    <td>
                        @if($appointment->status == 'pending')
                            <span class="badge badge-warning">En attente</span>
                        @elseif($appointment->status == 'confirmed')
                            <span class="badge badge-success">Confirmé</span>
                        @endif
                    </td>
                    <td>
                        <div class="dropdown">
                            <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                <i class="dw dw-more"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                <a class="dropdown-item" href="{{ route('agent.appointment.status', [$appointment->id, 'confirmed']) }}"><i class="dw dw-check"></i> Confirmer</a>
                                <a class="dropdown-item" href="{{ route('agent.appointment.status', [$appointment->id, 'cancelled']) }}"><i class="dw dw-cancel"></i> Annuler</a>
                                <a class="dropdown-item" href="{{ route('agent.appointment.status', [$appointment->id, 'completed']) }}"><i class="dw dw-checked"></i> Terminer</a>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
                
                @if($upcomingAppointments->isEmpty())
                <tr>
                    <td colspan="5" class="text-center">Aucun rendez-vous à venir dans les 7 prochains jours</td>
                </tr>
                @endif
            </tbody>
        </table>
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
