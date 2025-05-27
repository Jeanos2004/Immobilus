@extends('agent.agent_dashboard')
@section('content')

<div class="page-content">
    <div class="container-fluid">
        
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">{{ __('agent.agent_dashboard') }}</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Immobilus</a></li>
                            <li class="breadcrumb-item active">{{ __('agent.dashboard') }}</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">{{ __('agent.my_properties') }}</p>
                                <h4 class="mb-2">{{ $totalProperties }}</h4>
                                <p class="text-muted mb-0">
                                    <span class="text-success fw-bold font-size-12 me-2">
                                        <i class="ri-arrow-right-up-line me-1 align-middle"></i>{{ $activeProperties }}
                                    </span> {{ __('agent.active') }}
                                </p>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-primary rounded-3">
                                    <i class="ri-home-3-line font-size-24"></i>
                                </span>
                            </div>
                        </div>                                            
                    </div><!-- end cardbody -->
                </div><!-- end card -->
            </div><!-- end col -->
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">{{ __('agent.appointments') }}</p>
                                <h4 class="mb-2">{{ $totalAppointments }}</h4>
                                <p class="text-muted mb-0">
                                    <span class="text-warning fw-bold font-size-12 me-2">
                                        <i class="ri-time-line me-1 align-middle"></i>{{ $pendingAppointments }}
                                    </span> {{ __('agent.pending') }}
                                </p>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-success rounded-3">
                                    <i class="ri-calendar-check-line font-size-24"></i>
                                </span>
                            </div>
                        </div>                                              
                    </div><!-- end cardbody -->
                </div><!-- end card -->
            </div><!-- end col -->
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">{{ __('agent.messages') }}</p>
                                <h4 class="mb-2">{{ $totalMessages }}</h4>
                                <p class="text-muted mb-0">
                                    <span class="text-danger fw-bold font-size-12 me-2">
                                        <i class="ri-mail-unread-line me-1 align-middle"></i>{{ $unreadMessages }}
                                    </span> {{ __('agent.unread') }}
                                </p>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-primary rounded-3">
                                    <i class="ri-message-2-line font-size-24"></i>
                                </span>
                            </div>
                        </div>                                              
                    </div><!-- end cardbody -->
                </div><!-- end card -->
            </div><!-- end col -->
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">{{ __('agent.payments') }}</p>
                                <h4 class="mb-2">{{ number_format($totalRevenue, 0, ',', ' ') }} €</h4>
                                <p class="text-muted mb-0">
                                    <span class="text-success fw-bold font-size-12 me-2">
                                        <i class="ri-arrow-right-up-line me-1 align-middle"></i>{{ $paymentsThisMonth }}
                                    </span> {{ __('agent.this_month') }}
                                </p>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-success rounded-3">
                                    <i class="ri-currency-line font-size-24"></i>
                                </span>
                            </div>
                        </div>                                              
                    </div><!-- end cardbody -->
                </div><!-- end card -->
            </div><!-- end col -->
        </div><!-- end row -->

        <div class="row">
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h4 class="card-title">{{ __('agent.recent_appointments') }}</h4>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="dropdown">
                                    <a class="dropdown-toggle text-reset" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="fw-semibold">{{ __('agent.sort_by') }}:</span> 
                                        <span class="text-muted">{{ __('agent.date') }}<i class="mdi mdi-chevron-down ms-1"></i></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="#">{{ __('agent.recent_date') }}</a>
                                        <a class="dropdown-item" href="#">{{ __('agent.old_date') }}</a>
                                        <a class="dropdown-item" href="#">{{ __('agent.status') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive mt-3">
                            <table class="table table-hover table-nowrap mb-0 align-middle">
                                <thead>
                                    <tr>
                                        <th scope="col">{{ __('agent.id') }}</th>
                                        <th scope="col">{{ __('agent.client') }}</th>
                                        <th scope="col">{{ __('agent.property') }}</th>
                                        <th scope="col">{{ __('agent.date') }}</th>
                                        <th scope="col">{{ __('agent.status') }}</th>
                                        <th scope="col">{{ __('agent.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentAppointments as $appointment)
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
                                                <span class="badge badge-soft-success">{{ __('agent.confirmed') }}</span>
                                            @elseif($appointment->status == 'cancelled')
                                                <span class="badge badge-soft-danger">{{ __('agent.cancelled') }}</span>
                                            @elseif($appointment->status == 'completed')
                                                <span class="badge badge-soft-info">{{ __('agent.completed') }}</span>
                                            @else
                                                <span class="badge badge-soft-warning">{{ __('agent.pending') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <a class="text-muted dropdown-toggle font-size-18" role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                                                    <i class="mdi mdi-dots-horizontal"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="{{ route('agent.appointment.view', $appointment->id) }}">{{ __('Voir détails') }}</a>
                                                    @if($appointment->status == 'pending')
                                                        <a class="dropdown-item" href="{{ route('agent.appointment.confirm', $appointment->id) }}">{{ __('Confirmer') }}</a>
                                                        <a class="dropdown-item" href="{{ route('agent.appointment.cancel', $appointment->id) }}">{{ __('Annuler') }}</a>
                                                    @endif
                                                    @if($appointment->status == 'confirmed')
                                                        <a class="dropdown-item" href="{{ route('agent.appointment.complete', $appointment->id) }}">{{ __('Marquer comme terminé') }}</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">{{ __('agent.no_appointments') }}</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            <a href="{{ route('agent.appointments.all') }}" class="btn btn-primary btn-sm">{{ __('agent.view_all_appointments') }} <i class="mdi mdi-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start">
                            <div class="flex-grow-1">
                                <h4 class="card-title mb-3">{{ __('Activité récente') }}</h4>
                            </div>
                        </div>

                        <div class="activity-feed mb-0 ps-2" data-simplebar style="max-height: 336px;">
                            @forelse($recentActivities as $activity)
                            <div class="feed-item">
                                <div class="feed-item-list">
                                    <div class="date">
                                        <p class="text-muted mb-0 font-size-12">{{ \Carbon\Carbon::parse($activity->created_at)->diffForHumans() }}</p>
                                    </div>
                                    <div class="activity-avatar">
                                        <div class="avatar-xs">
                                            <div class="avatar-title rounded-circle bg-soft-{{ $activity->type == 'property' ? 'primary' : ($activity->type == 'appointment' ? 'success' : 'info') }} text-{{ $activity->type == 'property' ? 'primary' : ($activity->type == 'appointment' ? 'success' : 'info') }}">
                                                <i class="{{ $activity->type == 'property' ? 'ri-home-3-line' : ($activity->type == 'appointment' ? 'ri-calendar-check-line' : 'ri-message-2-line') }}"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="activity-content">
                                        <p class="text-muted mb-0">
                                            {!! $activity->description !!}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="feed-item">
                                <div class="feed-item-list">
                                    <div class="activity-content">
                                        <p class="text-muted mb-0">{{ __('Aucune activité récente') }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start">
                            <div class="flex-grow-1">
                                <h4 class="card-title mb-3">{{ __('Propriétés populaires') }}</h4>
                            </div>
                        </div>

                        <div class="popular-properties" data-simplebar style="max-height: 336px;">
                            @forelse($popularProperties as $property)
                            <div class="property-item mb-3">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <img src="{{ asset(!empty($property->property_thumbnail) ? $property->property_thumbnail : 'upload/no_image.jpg') }}" alt="" class="avatar-md rounded">
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5 class="font-size-14 mb-1">
                                            <a href="{{ route('property.details', [$property->id, Str::slug($property->property_name)]) }}" class="text-dark">{{ Str::limit($property->property_name, 30) }}</a>
                                        </h5>
                                        <p class="text-muted font-size-13 mb-1">
                                            <i class="ri-map-pin-line me-1"></i> {{ Str::limit($property->address, 30) }}
                                        </p>
                                        <p class="text-muted font-size-13 mb-0">
                                            <span class="text-primary font-weight-bold">{{ number_format($property->lowest_price, 0, ',', ' ') }} €</span> • 
                                            <span>{{ $property->bedrooms }} {{ __('Ch.') }}</span> • 
                                            <span>{{ $property->bathrooms }} {{ __('SdB') }}</span> • 
                                            <span>{{ $property->property_size }} m²</span>
                                        </p>
                                        <div class="mt-2">
                                            <span class="badge badge-soft-primary">{{ $property->views }} {{ __('vues') }}</span>
                                            <span class="badge badge-soft-warning">{{ $property->wishlist_count ?? 0 }} {{ __('favoris') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-4">
                                <p class="text-muted mb-0">{{ __('Aucune propriété populaire') }}</p>
                            </div>
                            @endforelse
                        </div>

                        <div class="mt-3">
                            <a href="{{ route('agent.properties.all') }}" class="btn btn-primary btn-sm">{{ __('Gérer mes propriétés') }} <i class="mdi mdi-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start">
                            <div class="flex-grow-1">
                                <h4 class="card-title mb-3">{{ __('Messages récents') }}</h4>
                            </div>
                        </div>

                        <div class="messages-list" data-simplebar style="max-height: 336px;">
                            @forelse($recentMessages as $message)
                            <div class="message-item {{ $message->is_read ? '' : 'unread' }} mb-3">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        @if($message->sender && $message->sender->photo)
                                            <img src="{{ asset($message->sender->photo) }}" alt="" class="avatar-xs rounded-circle">
                                        @else
                                            <img src="{{ asset('upload/no_image.jpg') }}" alt="" class="avatar-xs rounded-circle">
                                        @endif
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5 class="font-size-14 mb-1">
                                            {{ $message->sender->name ?? 'Utilisateur supprimé' }}
                                            @if(!$message->is_read)
                                                <span class="badge badge-soft-danger font-size-10 float-end">{{ __('Nouveau') }}</span>
                                            @endif
                                        </h5>
                                        <p class="text-muted font-size-13 mb-1">{{ Str::limit($message->subject, 40) }}</p>
                                        <p class="text-muted font-size-12 mb-0">{{ \Carbon\Carbon::parse($message->created_at)->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-4">
                                <p class="text-muted mb-0">{{ __('Aucun message récent') }}</p>
                            </div>
                            @endforelse
                        </div>

                        <div class="mt-3">
                            <a href="{{ route('agent.messages') }}" class="btn btn-primary btn-sm">{{ __('Voir tous les messages') }} <i class="mdi mdi-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start">
                            <div class="flex-grow-1">
                                <h4 class="card-title mb-3">{{ __('Ajouter une propriété') }}</h4>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <div class="avatar-lg mx-auto">
                                <div class="avatar-title bg-light text-primary rounded-circle font-size-24">
                                    <i class="ri-add-line"></i>
                                </div>
                            </div>
                            <h5 class="mt-4">{{ __('Nouvelle propriété') }}</h5>
                            <p class="text-muted">{{ __('Ajoutez une nouvelle propriété à votre portefeuille pour attirer plus de clients.') }}</p>
                            
                            <div class="mt-4">
                                <a href="{{ route('agent.property.create') }}" class="btn btn-primary btn-rounded waves-effect waves-light">{{ __('Ajouter une propriété') }}</a>
                            </div>
                        </div>

                        <div class="mt-4 pt-2">
                            <div class="text-muted text-center mb-4">
                                <h5 class="font-size-15 mb-3">{{ __('Statistiques de vos propriétés') }}</h5>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-centered mb-0 align-middle">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <h5 class="font-size-14 mb-0">{{ __('À vendre') }}</h5>
                                            </td>
                                            <td>
                                                <div class="progress" style="height: 5px;">
                                                    <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $salePercentage }}%;" aria-valuenow="{{ $salePercentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </td>
                                            <td><p class="text-muted mb-0 text-end">{{ $saleProperties }}</p></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h5 class="font-size-14 mb-0">{{ __('À louer') }}</h5>
                                            </td>
                                            <td>
                                                <div class="progress" style="height: 5px;">
                                                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $rentPercentage }}%;" aria-valuenow="{{ $rentPercentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </td>
                                            <td><p class="text-muted mb-0 text-end">{{ $rentProperties }}</p></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h5 class="font-size-14 mb-0">{{ __('Vues totales') }}</h5>
                                            </td>
                                            <td>
                                                <div class="progress" style="height: 5px;">
                                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </td>
                                            <td><p class="text-muted mb-0 text-end">{{ $totalViews }}</p></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div>
    
</div>
<!-- End Page-content -->

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Code JavaScript pour le tableau de bord agent
    });
</script>
@endsection
