@extends('agent.agent_dashboard')
@section('content')

<div class="page-content">
    <div class="container-fluid">
        
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">{{ __('Détails du rendez-vous') }}</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('agent.dashboard') }}">{{ __('Tableau de bord') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('agent.appointments.all') }}">{{ __('Rendez-vous') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('Détails') }}</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->
        
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header bg-transparent border-bottom d-flex">
                        <h5 class="card-title mb-0">{{ __('Rendez-vous') }} #{{ $appointment->id }}</h5>
                        <div class="ms-auto">
                            @if($appointment->status == 'pending')
                                <a href="{{ route('agent.appointment.confirm', $appointment->id) }}" class="btn btn-success btn-sm me-1">
                                    <i class="ri-check-line me-1"></i> {{ __('Confirmer') }}
                                </a>
                                <a href="{{ route('agent.appointment.cancel', $appointment->id) }}" class="btn btn-danger btn-sm me-1" onclick="return confirm('{{ __('Êtes-vous sûr de vouloir annuler ce rendez-vous ?') }}')">
                                    <i class="ri-close-line me-1"></i> {{ __('Annuler') }}
                                </a>
                            @endif
                            
                            @if($appointment->status == 'confirmed')
                                <a href="{{ route('agent.appointment.complete', $appointment->id) }}" class="btn btn-primary btn-sm me-1">
                                    <i class="ri-check-double-line me-1"></i> {{ __('Marquer comme terminé') }}
                                </a>
                            @endif
                            
                            <a href="{{ route('agent.appointments.all') }}" class="btn btn-secondary btn-sm">
                                <i class="ri-arrow-left-line me-1"></i> {{ __('Retour') }}
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card border shadow-none">
                                    <div class="card-header bg-transparent border-bottom">
                                        <h5 class="card-title mb-0">{{ __('Informations du rendez-vous') }}</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-nowrap mb-0">
                                                <tbody>
                                                    <tr>
                                                        <th scope="row">{{ __('Statut') }}</th>
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
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">{{ __('Date') }}</th>
                                                        <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">{{ __('Heure') }}</th>
                                                        <td>{{ $appointment->appointment_time }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">{{ __('Type de visite') }}</th>
                                                        <td>{{ $appointment->visit_type }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">{{ __('Créé le') }}</th>
                                                        <td>{{ \Carbon\Carbon::parse($appointment->created_at)->format('d/m/Y H:i') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">{{ __('Dernière mise à jour') }}</th>
                                                        <td>{{ \Carbon\Carbon::parse($appointment->updated_at)->format('d/m/Y H:i') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">{{ __('Message') }}</th>
                                                        <td>{{ $appointment->message ?? __('Aucun message') }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xl-6">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card border shadow-none">
                                            <div class="card-header bg-transparent border-bottom">
                                                <h5 class="card-title mb-0">{{ __('Informations du client') }}</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-3">
                                                    @if($appointment->user && $appointment->user->photo)
                                                        <img src="{{ asset($appointment->user->photo) }}" alt="" class="avatar-md rounded-circle me-3">
                                                    @else
                                                        <img src="{{ asset('upload/no_image.jpg') }}" alt="" class="avatar-md rounded-circle me-3">
                                                    @endif
                                                    <div>
                                                        <h5 class="font-size-16 mb-1">{{ $appointment->user->name ?? 'N/A' }}</h5>
                                                        <p class="text-muted mb-0">{{ $appointment->user->email ?? 'N/A' }}</p>
                                                    </div>
                                                </div>
                                                
                                                <div class="table-responsive">
                                                    <table class="table table-nowrap mb-0">
                                                        <tbody>
                                                            <tr>
                                                                <th scope="row">{{ __('Téléphone') }}</th>
                                                                <td>{{ $appointment->user->phone ?? 'N/A' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">{{ __('Adresse') }}</th>
                                                                <td>{{ $appointment->user->address ?? 'N/A' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">{{ __('Membre depuis') }}</th>
                                                                <td>{{ $appointment->user ? \Carbon\Carbon::parse($appointment->user->created_at)->format('d/m/Y') : 'N/A' }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                
                                                <div class="mt-3">
                                                    <a href="mailto:{{ $appointment->user->email ?? '' }}" class="btn btn-primary btn-sm me-1">
                                                        <i class="ri-mail-line me-1"></i> {{ __('Envoyer un email') }}
                                                    </a>
                                                    @if($appointment->user && $appointment->user->phone)
                                                        <a href="tel:{{ $appointment->user->phone }}" class="btn btn-info btn-sm">
                                                            <i class="ri-phone-line me-1"></i> {{ __('Appeler') }}
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12 mt-4">
                                        <div class="card border shadow-none">
                                            <div class="card-header bg-transparent border-bottom">
                                                <h5 class="card-title mb-0">{{ __('Propriété concernée') }}</h5>
                                            </div>
                                            <div class="card-body">
                                                @if($appointment->property)
                                                    <div class="d-flex align-items-center mb-3">
                                                        <img src="{{ asset(!empty($appointment->property->property_thumbnail) ? $appointment->property->property_thumbnail : 'upload/no_image.jpg') }}" alt="" class="avatar-lg rounded me-3">
                                                        <div>
                                                            <h5 class="font-size-16 mb-1">{{ $appointment->property->property_name }}</h5>
                                                            <p class="text-muted mb-0">{{ $appointment->property->address }}</p>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="table-responsive">
                                                        <table class="table table-nowrap mb-0">
                                                            <tbody>
                                                                <tr>
                                                                    <th scope="row">{{ __('Type') }}</th>
                                                                    <td>{{ $appointment->property->type->type_name ?? 'N/A' }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">{{ __('Statut') }}</th>
                                                                    <td>{{ $appointment->property->property_status == 'rent' ? __('À louer') : __('À vendre') }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">{{ __('Prix') }}</th>
                                                                    <td>{{ number_format($appointment->property->lowest_price, 0, ',', ' ') }} €</td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">{{ __('Caractéristiques') }}</th>
                                                                    <td>
                                                                        {{ $appointment->property->bedrooms }} {{ __('Ch.') }} • 
                                                                        {{ $appointment->property->bathrooms }} {{ __('SdB') }} • 
                                                                        {{ $appointment->property->property_size }} m²
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    
                                                    <div class="mt-3">
                                                        <a href="{{ route('property.details', [$appointment->property->id, Str::slug($appointment->property->property_name)]) }}" target="_blank" class="btn btn-primary btn-sm">
                                                            <i class="ri-eye-line me-1"></i> {{ __('Voir la propriété') }}
                                                        </a>
                                                    </div>
                                                @else
                                                    <div class="text-center py-4">
                                                        <p class="text-muted mb-0">{{ __('Propriété non disponible ou supprimée') }}</p>
                                                    </div>
                                                @endif
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
        <!-- end row -->
        
    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->

@endsection
