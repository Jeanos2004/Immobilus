@extends('agent.agent_dashboard')
@section('content')

<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h4 class="mb-3 mb-md-0">{{ __('agent.agent_dashboard') }}</h4>
    </div>
    <div class="d-flex align-items-center flex-wrap text-nowrap">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:;">Immobilus</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('agent.dashboard') }}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-12 col-xl-12 stretch-card">
        <div class="row flex-grow-1 justify-content-center">
            <div class="col-md-4 col-xl-3 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <h6 class="card-title mb-0">{{ __('agent.my_properties') }}</h6>
                            <div class="dropdown mb-2">
                                <a class="btn btn-sm btn-outline-light dropdown-toggle" href="{{ route('agent.properties.all') }}" role="button">
                                    <i data-feather="eye"></i>
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-12 col-xl-5">
                                <h3 class="mb-2">{{ $totalProperties }}</h3>
                                <div class="d-flex align-items-baseline">
                                    <p class="text-success">
                                        <span>{{ $activeProperties }} {{ __('agent.active') }}</span>
                                        <i data-feather="arrow-up" class="icon-sm mb-1"></i>
                                    </p>
                                </div>
                            </div>
                            <div class="col-6 col-md-12 col-xl-7">
                                <div class="mt-md-3 mt-xl-0">
                                    <div class="d-flex align-items-center">
                                        <span class="bg-primary-transparent icon-md rounded-circle text-primary">
                                            <i data-feather="home"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-xl-3 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <h6 class="card-title mb-0">{{ __('agent.appointments') }}</h6>
                            <div class="dropdown mb-2">
                                <a class="btn btn-sm btn-outline-light dropdown-toggle" href="{{ route('agent.appointments.all') }}" role="button">
                                    <i data-feather="eye"></i>
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-12 col-xl-5">
                                <h3 class="mb-2">{{ $totalAppointments }}</h3>
                                <div class="d-flex align-items-baseline">
                                    <p class="text-warning">
                                        <span>{{ $pendingAppointments }} {{ __('agent.pending') }}</span>
                                        <i data-feather="clock" class="icon-sm mb-1"></i>
                                    </p>
                                </div>
                            </div>
                            <div class="col-6 col-md-12 col-xl-7">
                                <div class="mt-md-3 mt-xl-0">
                                    <div class="d-flex align-items-center">
                                        <span class="bg-warning-transparent icon-md rounded-circle text-warning">
                                            <i data-feather="calendar"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-xl-3 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <h6 class="card-title mb-0">{{ __('agent.messages') }}</h6>
                            <div class="dropdown mb-2">
                                <a class="btn btn-sm btn-outline-light dropdown-toggle" href="{{ route('agent.inbox') }}" role="button">
                                    <i data-feather="eye"></i>
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-12 col-xl-5">
                                <h3 class="mb-2">{{ $totalMessages }}</h3>
                                <div class="d-flex align-items-baseline">
                                    <p class="text-danger">
                                        <span>{{ $unreadMessages }} {{ __('agent.unread') }}</span>
                                        <i data-feather="mail" class="icon-sm mb-1"></i>
                                    </p>
                                </div>
                            </div>
                            <div class="col-6 col-md-12 col-xl-7">
                                <div class="mt-md-3 mt-xl-0">
                                    <div class="d-flex align-items-center">
                                        <span class="bg-danger-transparent icon-md rounded-circle text-danger">
                                            <i data-feather="message-square"></i>
                                        </span>
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

<div class="row">
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-3">
                    <h6 class="card-title mb-0">{{ __('agent.recent_appointments') }}</h6>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-light dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ __('agent.date') }}
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#">{{ __('agent.recent_date') }}</a>
                            <a class="dropdown-item" href="#">{{ __('agent.old_date') }}</a>
                            <a class="dropdown-item" href="#">{{ __('agent.status') }}</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="pt-0">{{ __('agent.client') }}</th>
                                <th class="pt-0">{{ __('agent.property') }}</th>
                                <th class="pt-0">{{ __('agent.date') }}</th>
                                <th class="pt-0">{{ __('agent.status') }}</th>
                                <th class="pt-0">{{ __('agent.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentAppointments as $appointment)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-2">
                                            @if($appointment->user && $appointment->user->photo)
                                                <img src="{{ url('upload/user_images/'.$appointment->user->photo) }}" alt="" class="rounded-circle wd-30 ht-30">
                                            @else
                                                <img src="{{ url('upload/no_image.jpg') }}" alt="" class="rounded-circle wd-30 ht-30">
                                            @endif
                                        </div>
                                        <div>
                                            @if($appointment->user)
                                                <span>{{ $appointment->user->name }}</span>
                                            @else
                                                <span class="text-muted">{{ __('agent.deleted_user') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($appointment->property)
                                        <a href="{{ route('property.details', [$appointment->property->id, Str::slug($appointment->property->property_name)]) }}" class="text-body">
                                            {{ Str::limit($appointment->property->property_name, 30) }}
                                        </a>
                                    @else
                                        <span class="text-muted">{{ __('agent.deleted_property') }}</span>
                                    @endif
                                </td>
                                <td>{{ $appointment->appointment_date }} {{ $appointment->appointment_time }}</td>
                                <td>
                                    @if($appointment->status == 'pending')
                                        <span class="badge bg-warning">{{ __('agent.pending') }}</span>
                                    @elseif($appointment->status == 'confirmed')
                                        <span class="badge bg-success">{{ __('agent.confirmed') }}</span>
                                    @elseif($appointment->status == 'cancelled')
                                        <span class="badge bg-danger">{{ __('agent.cancelled') }}</span>
                                    @elseif($appointment->status == 'completed')
                                        <span class="badge bg-info">{{ __('agent.completed') }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-light dropdown-toggle" type="button" id="dropdownMenuButton{{ $appointment->id }}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i data-feather="more-horizontal"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton{{ $appointment->id }}">
                                            <a class="dropdown-item" href="{{ route('agent.appointment.view', $appointment->id) }}">{{ __('agent.view_details') }}</a>
                                            @if($appointment->status == 'pending')
                                                <a class="dropdown-item" href="{{ route('agent.appointment.confirm', $appointment->id) }}">{{ __('agent.confirm') }}</a>
                                                <a class="dropdown-item" href="{{ route('agent.appointment.cancel', $appointment->id) }}">{{ __('agent.cancel') }}</a>
                                            @elseif($appointment->status == 'confirmed')
                                                <a class="dropdown-item" href="{{ route('agent.appointment.complete', $appointment->id) }}">{{ __('agent.mark_completed') }}</a>
                                                <a class="dropdown-item" href="{{ route('agent.appointment.cancel', $appointment->id) }}">{{ __('agent.cancel') }}</a>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">{{ __('agent.no_appointments') }}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end mt-3">
                    <a href="{{ route('agent.appointments.all') }}" class="btn btn-primary btn-sm">{{ __('agent.view_all_appointments') }} <i data-feather="arrow-right" class="icon-sm"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">{{ __('Activité récente') }}</h6>
                <div class="d-flex flex-column">
                    @forelse($recentActivities as $activity)
                    <div class="d-flex align-items-center border-bottom pb-3 mb-3">
                        <div class="me-3">
                            <div class="avatar-sm">
                                <span class="avatar-title rounded-circle bg-{{ $activity->type == 'property' ? 'primary' : ($activity->type == 'appointment' ? 'success' : 'info') }}-light text-{{ $activity->type == 'property' ? 'primary' : ($activity->type == 'appointment' ? 'success' : 'info') }}">
                                    <i data-feather="{{ $activity->type == 'property' ? 'home' : ($activity->type == 'appointment' ? 'calendar' : 'message-square') }}"></i>
                                </span>
                            </div>
                        </div>
                        <div class="w-100">
                            <div class="d-flex justify-content-between">
                                <h6 class="fw-normal text-body mb-1">{!! $activity->description !!}</h6>
                                <p class="text-muted tx-12">{{ \Carbon\Carbon::parse($activity->created_at)->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="d-flex align-items-center border-bottom pb-3 mb-3">
                        <div class="w-100 text-center">
                            <p class="text-muted">{{ __('Aucune activité récente') }}</p>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-3">
                    <h6 class="card-title mb-0">{{ __('Propriétés populaires') }}</h6>
                    <div class="dropdown">
                        <a class="btn btn-sm btn-outline-light" href="{{ route('agent.properties.all') }}">
                            <i data-feather="eye"></i>
                        </a>
                    </div>
                </div>
                <div class="d-flex flex-column">
                    @forelse($popularProperties as $property)
                    <div class="d-flex align-items-center border-bottom pb-3 mb-3">
                        <div class="me-3">
                            <img src="{{ asset(!empty($property->property_thumbnail) ? $property->property_thumbnail : 'upload/no_image.jpg') }}" class="rounded wd-100 ht-70" alt="property">
                        </div>
                        <div class="w-100">
                            <div class="d-flex justify-content-between">
                                <h6 class="fw-normal text-body mb-1">
                                    <a href="{{ route('property.details', [$property->id, Str::slug($property->property_name)]) }}" class="text-reset">
                                        {{ Str::limit($property->property_name, 30) }}
                                    </a>
                                </h6>
                                <p class="text-muted tx-12">{{ number_format($property->lowest_price, 0, ',', ' ') }} €</p>
                            </div>
                            <p class="text-muted tx-12 mb-0">
                                <i data-feather="map-pin" class="icon-xs me-1"></i> {{ Str::limit($property->address, 30) }}
                            </p>
                            <div class="d-flex justify-content-between align-items-center mt-1">
                                <div>
                                    <span class="badge bg-light text-secondary me-1">{{ $property->bedrooms }} {{ __('Ch.') }}</span>
                                    <span class="badge bg-light text-secondary me-1">{{ $property->bathrooms }} {{ __('SdB') }}</span>
                                    <span class="badge bg-light text-secondary">{{ $property->property_size }} m²</span>
                                </div>
                                <div>
                                    <span class="badge bg-primary-light text-primary">{{ $property->views }} {{ __('vues') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="d-flex align-items-center border-bottom pb-3 mb-3">
                        <div class="w-100 text-center">
                            <p class="text-muted">{{ __('Aucune propriété populaire') }}</p>
                        </div>
                    </div>
                    @endforelse
                </div>
                <div class="d-flex justify-content-end mt-3">
                    <a href="{{ route('agent.properties.all') }}" class="btn btn-primary btn-sm">{{ __('Gérer mes propriétés') }} <i data-feather="arrow-right" class="icon-sm"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-3">
                    <h6 class="card-title mb-0">{{ __('Messages récents') }}</h6>
                    <div class="dropdown">
                        <a class="btn btn-sm btn-outline-light" href="{{ route('agent.inbox') }}">
                            <i data-feather="eye"></i>
                        </a>
                    </div>
                </div>
                <div class="d-flex flex-column">
                    @forelse($recentMessages as $message)
                    <div class="d-flex align-items-center border-bottom pb-3 mb-3">
                        <div class="me-3">
                            <div class="avatar">
                                @if($message->sender && $message->sender->photo)
                                    <img src="{{ url('upload/user_images/'.$message->sender->photo) }}" class="rounded-circle wd-35 ht-35" alt="user">
                                @else
                                    <img src="{{ url('upload/no_image.jpg') }}" class="rounded-circle wd-35 ht-35" alt="user">
                                @endif
                            </div>
                        </div>
                        <div class="w-100">
                            <div class="d-flex justify-content-between">
                                <h6 class="fw-normal text-body mb-1">
                                    {{ $message->sender ? $message->sender->name : __('Utilisateur supprimé') }}
                                </h6>
                                <p class="text-muted tx-12">{{ \Carbon\Carbon::parse($message->created_at)->diffForHumans() }}</p>
                            </div>
                            <p class="text-muted tx-12 mb-0">
                                {{ Str::limit($message->message, 50) }}
                            </p>
                            @if($message->read_at === null)
                                <span class="badge bg-danger">{{ __('Non lu') }}</span>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="d-flex align-items-center border-bottom pb-3 mb-3">
                        <div class="w-100 text-center">
                            <p class="text-muted">{{ __('Aucun message récent') }}</p>
                        </div>
                    </div>
                    @endforelse
                </div>
                <div class="d-flex justify-content-end mt-3">
                    <a href="{{ route('agent.inbox') }}" class="btn btn-primary btn-sm">{{ __('Voir tous les messages') }} <i data-feather="arrow-right" class="icon-sm"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Initialisation des DataTables
        if ($('.datatable').length) {
            $('.datatable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/French.json"
                }
            });
        }
    });
</script>
@endsection
