@extends('frontend.frontend_dashboard')
@section('main')

<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Notifications</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Notifications</li>
                </ol>
            </nav>
        </div>
        <div class="col-md-6 col-sm-12 text-right">
            <div class="dropdown">
                <a class="btn btn-primary dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                    Actions
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{ route('notification.mark.all.read') }}">Marquer tout comme lu</a>
                    <a class="dropdown-item" href="{{ route('notification.delete.all') }}" onclick="return confirm('Êtes-vous sûr de vouloir supprimer toutes les notifications ?')">Supprimer toutes les notifications</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card-box mb-30">
    <div class="pd-20">
        <h4 class="text-blue h4">Toutes les notifications</h4>
    </div>
    <div class="pb-20">
        <table class="data-table table stripe hover nowrap">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Message</th>
                    <th>Statut</th>
                    <th class="datatable-nosort">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($notifications as $notification)
                @php
                    $data = $notification->data;
                    $createdAt = \Carbon\Carbon::parse($notification->created_at);
                    $formattedDate = $createdAt->format('d/m/Y H:i');
                    $timeAgo = $createdAt->diffForHumans();
                    $isRead = $notification->read_at != null;
                @endphp
                <tr class="{{ $isRead ? '' : 'bg-light' }}">
                    <td>
                        <span title="{{ $formattedDate }}">{{ $timeAgo }}</span>
                    </td>
                    <td>
                        {{ $data['message'] ?? 'Notification système' }}
                        @if(isset($data['property_name']))
                        <br><small>Propriété: {{ $data['property_name'] }}</small>
                        @endif
                        @if(isset($data['appointment_date']))
                        <br><small>Date: {{ \Carbon\Carbon::parse($data['appointment_date'])->format('d/m/Y à H:i') }}</small>
                        @endif
                    </td>
                    <td>
                        @if($isRead)
                            <span class="badge badge-light">Lu</span>
                        @else
                            <span class="badge badge-primary">Non lu</span>
                        @endif
                    </td>
                    <td>
                        <div class="dropdown">
                            <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                <i class="dw dw-more"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                @if(!$isRead)
                                <a class="dropdown-item" href="{{ route('notification.mark.read', $notification->id) }}"><i class="dw dw-check"></i> Marquer comme lu</a>
                                @endif
                                
                                @if(isset($data['appointment_id']))
                                    @if(auth()->user()->role == 'user')
                                    <a class="dropdown-item" href="{{ route('user.appointments') }}"><i class="dw dw-eye"></i> Voir mes rendez-vous</a>
                                    @elseif(auth()->user()->role == 'agent')
                                    <a class="dropdown-item" href="{{ route('agent.appointments') }}"><i class="dw dw-eye"></i> Voir mes rendez-vous</a>
                                    @elseif(auth()->user()->role == 'admin')
                                    <a class="dropdown-item" href="{{ route('all.appointments') }}"><i class="dw dw-eye"></i> Voir tous les rendez-vous</a>
                                    @endif
                                @endif
                                
                                <a class="dropdown-item" href="{{ route('notification.delete', $notification->id) }}" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette notification ?')"><i class="dw dw-delete-3"></i> Supprimer</a>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">Aucune notification</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <div class="d-flex justify-content-center mt-4">
            {{ $notifications->links() }}
        </div>
    </div>
</div>

@endsection
