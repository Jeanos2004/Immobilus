@extends('agent.agent_dashboard')
@section('content')

<div class="page-content">
    <div class="container-fluid">
        
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">{{ __('Tous les rendez-vous') }}</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('agent.dashboard') }}">{{ __('Tableau de bord') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('Rendez-vous') }}</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->
        
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-4">
                            <h4 class="card-title">{{ __('Liste des rendez-vous') }}</h4>
                            <div class="ms-auto">
                                <div class="dropdown">
                                    <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="filterDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="ri-filter-2-line me-1"></i> {{ __('Filtrer par') }}
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="filterDropdown">
                                        <a class="dropdown-item" href="{{ route('agent.appointments.all') }}?status=all">{{ __('Tous') }}</a>
                                        <a class="dropdown-item" href="{{ route('agent.appointments.all') }}?status=pending">{{ __('En attente') }}</a>
                                        <a class="dropdown-item" href="{{ route('agent.appointments.all') }}?status=confirmed">{{ __('Confirmés') }}</a>
                                        <a class="dropdown-item" href="{{ route('agent.appointments.all') }}?status=completed">{{ __('Terminés') }}</a>
                                        <a class="dropdown-item" href="{{ route('agent.appointments.all') }}?status=cancelled">{{ __('Annulés') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>{{ __('ID') }}</th>
                                        <th>{{ __('Client') }}</th>
                                        <th>{{ __('Propriété') }}</th>
                                        <th>{{ __('Date & Heure') }}</th>
                                        <th>{{ __('Statut') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($appointments as $appointment)
                                    <tr>
                                        <td>{{ $appointment->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($appointment->user && $appointment->user->photo)
                                                    <img src="{{ asset($appointment->user->photo) }}" alt="" class="avatar-xs rounded-circle me-2">
                                                @else
                                                    <img src="{{ asset('upload/no_image.jpg') }}" alt="" class="avatar-xs rounded-circle me-2">
                                                @endif
                                                <div>
                                                    <h5 class="font-size-14 mb-0">{{ $appointment->user->name ?? 'N/A' }}</h5>
                                                    <p class="text-muted mb-0 font-size-12">{{ $appointment->user->email ?? 'N/A' }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($appointment->property)
                                                <a href="{{ route('property.details', [$appointment->property->id, Str::slug($appointment->property->property_name)]) }}" target="_blank" class="text-body fw-medium">
                                                    {{ Str::limit($appointment->property->property_name, 30) }}
                                                </a>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div>
                                                <h5 class="font-size-14 mb-0">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y') }}</h5>
                                                <p class="text-muted mb-0 font-size-12">{{ $appointment->appointment_time }}</p>
                                            </div>
                                        </td>
                                        <td>
                                            @if($appointment->status == 'confirmed')
                                                <span class="badge badge-soft-success">{{ __('Confirmé') }}</span>
                                            @elseif($appointment->status == 'cancelled')
                                                <span class="badge badge-soft-danger">{{ __('Annulé') }}</span>
                                            @elseif($appointment->status == 'completed')
                                                <span class="badge badge-soft-info">{{ __('Terminé') }}</span>
                                            @else
                                                <span class="badge badge-soft-warning">{{ __('En attente') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('agent.appointment.view', $appointment->id) }}" class="btn btn-sm btn-info">
                                                    <i class="ri-eye-line"></i>
                                                </a>
                                                
                                                @if($appointment->status == 'pending')
                                                    <a href="{{ route('agent.appointment.confirm', $appointment->id) }}" class="btn btn-sm btn-success" title="{{ __('Confirmer') }}">
                                                        <i class="ri-check-line"></i>
                                                    </a>
                                                    <a href="{{ route('agent.appointment.cancel', $appointment->id) }}" class="btn btn-sm btn-danger" title="{{ __('Annuler') }}" onclick="return confirm('{{ __('Êtes-vous sûr de vouloir annuler ce rendez-vous ?') }}')">
                                                        <i class="ri-close-line"></i>
                                                    </a>
                                                @endif
                                                
                                                @if($appointment->status == 'confirmed')
                                                    <a href="{{ route('agent.appointment.complete', $appointment->id) }}" class="btn btn-sm btn-primary" title="{{ __('Marquer comme terminé') }}">
                                                        <i class="ri-check-double-line"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">{{ __('Aucun rendez-vous trouvé') }}</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-end mt-3">
                            {{ $appointments->links() }}
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
        
    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#datatable').DataTable({
            "pageLength": 25,
            "ordering": true,
            "info": true,
            "language": {
                "search": "{{ __('Rechercher') }} :",
                "lengthMenu": "{{ __('Afficher') }} _MENU_ {{ __('entrées') }}",
                "zeroRecords": "{{ __('Aucun résultat trouvé') }}",
                "info": "{{ __('Affichage de') }} _START_ {{ __('à') }} _END_ {{ __('sur') }} _TOTAL_ {{ __('entrées') }}",
                "infoEmpty": "{{ __('Affichage de 0 à 0 sur 0 entrées') }}",
                "infoFiltered": "({{ __('filtré de') }} _MAX_ {{ __('entrées au total') }})",
                "paginate": {
                    "first": "{{ __('Premier') }}",
                    "last": "{{ __('Dernier') }}",
                    "next": "{{ __('Suivant') }}",
                    "previous": "{{ __('Précédent') }}"
                }
            }
        });
    });
</script>
@endsection
