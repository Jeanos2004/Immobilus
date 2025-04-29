@php
    $user = Auth::user();
    $notifications = $user->unreadNotifications()->latest()->take(5)->get();
    $notificationCount = $user->unreadNotifications()->count();
@endphp

<a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i data-feather="bell"></i>
    @if($notificationCount > 0)
    <div class="indicator">
        <div class="circle"></div>
    </div>
    @endif
</a>
<div class="dropdown-menu p-0" aria-labelledby="notificationDropdown">
    <div class="px-3 py-2 d-flex align-items-center justify-content-between border-bottom">
        <p>{{ $notificationCount }} {{ $notificationCount > 1 ? 'Nouvelles notifications' : 'Nouvelle notification' }}</p>
        <a href="{{ route('notification.mark.all.read') }}" class="text-muted">Tout marquer comme lu</a>
    </div>
    <div class="p-1">
        @forelse($notifications as $notification)
            @php
                $data = $notification->data;
                $createdAt = \Carbon\Carbon::parse($notification->created_at);
                $timeAgo = $createdAt->diffForHumans();
                
                // Déterminer l'icône en fonction du type de notification
                $icon = 'bell';
                if (isset($data['status'])) {
                    switch($data['status']) {
                        case 'confirmed':
                            $icon = 'check-circle';
                            $bgColor = 'bg-success';
                            break;
                        case 'cancelled':
                            $icon = 'x-circle';
                            $bgColor = 'bg-danger';
                            break;
                        case 'completed':
                            $icon = 'check-square';
                            $bgColor = 'bg-info';
                            break;
                        default:
                            $icon = 'clock';
                            $bgColor = 'bg-warning';
                            break;
                    }
                } else {
                    $icon = 'calendar';
                    $bgColor = 'bg-primary';
                }
            @endphp
            
            <a href="{{ route('notification.mark.read', $notification->id) }}" class="dropdown-item d-flex align-items-center py-2">
                <div class="wd-30 ht-30 d-flex align-items-center justify-content-center {{ $bgColor }} rounded-circle me-3">
                    <i class="icon-sm text-white" data-feather="{{ $icon }}"></i>
                </div>
                <div class="flex-grow-1 me-2">
                    <p>{{ $data['message'] ?? 'Nouvelle notification' }}</p>
                    <p class="tx-12 text-muted">{{ $timeAgo }}</p>
                </div>	
            </a>
        @empty
            <div class="text-center py-4">
                <p>Aucune notification non lue</p>
            </div>
        @endforelse
    </div>
    <div class="px-3 py-2 d-flex align-items-center justify-content-center border-top">
        <a href="{{ route('all.notifications') }}">Voir toutes les notifications</a>
    </div>
</div>
