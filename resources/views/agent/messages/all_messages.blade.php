@extends('agent.agent_dashboard')
@section('content')

<div class="page-content">
    <div class="container-fluid">
        
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">{{ __('Mes messages') }}</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('agent.dashboard') }}">{{ __('Tableau de bord') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('Messages') }}</li>
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
                            <h4 class="card-title">{{ __('Boîte de réception') }}</h4>
                            <div class="ms-auto">
                                <div class="dropdown">
                                    <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="filterDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="ri-filter-2-line me-1"></i> {{ __('Filtrer par') }}
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="filterDropdown">
                                        <a class="dropdown-item" href="{{ route('agent.messages') }}?status=all">{{ __('Tous') }}</a>
                                        <a class="dropdown-item" href="{{ route('agent.messages') }}?status=unread">{{ __('Non lus') }}</a>
                                        <a class="dropdown-item" href="{{ route('agent.messages') }}?status=read">{{ __('Lus') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th style="width: 20px;">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="checkAll">
                                                <label class="form-check-label" for="checkAll"></label>
                                            </div>
                                        </th>
                                        <th>{{ __('Expéditeur') }}</th>
                                        <th>{{ __('Sujet') }}</th>
                                        <th>{{ __('Message') }}</th>
                                        <th>{{ __('Date') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($messages as $message)
                                    <tr class="{{ $message->is_read ? '' : 'table-light fw-bold' }}">
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="message{{ $message->id }}">
                                                <label class="form-check-label" for="message{{ $message->id }}"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($message->sender && $message->sender->photo)
                                                    <img src="{{ asset($message->sender->photo) }}" alt="" class="avatar-xs rounded-circle me-2">
                                                @else
                                                    <img src="{{ asset('upload/no_image.jpg') }}" alt="" class="avatar-xs rounded-circle me-2">
                                                @endif
                                                <div>
                                                    <h5 class="font-size-14 mb-0">{{ $message->sender->name ?? __('Utilisateur supprimé') }}</h5>
                                                    <p class="text-muted mb-0 font-size-12">{{ $message->sender->email ?? 'N/A' }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if(!$message->is_read)
                                                <span class="badge badge-soft-danger me-1">{{ __('Nouveau') }}</span>
                                            @endif
                                            {{ Str::limit($message->subject, 30) }}
                                        </td>
                                        <td>{{ Str::limit($message->message, 50) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($message->created_at)->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('agent.message.view', $message->id) }}" class="btn btn-sm btn-info" title="{{ __('Voir') }}">
                                                    <i class="ri-eye-line"></i>
                                                </a>
                                                <a href="{{ route('agent.message.delete', $message->id) }}" class="btn btn-sm btn-danger" title="{{ __('Supprimer') }}" onclick="return confirm('{{ __('Êtes-vous sûr de vouloir supprimer ce message ?') }}')">
                                                    <i class="ri-delete-bin-line"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">{{ __('Aucun message trouvé') }}</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div>
                                <button type="button" class="btn btn-danger" id="deleteSelected" disabled>
                                    <i class="ri-delete-bin-line me-1"></i> {{ __('Supprimer la sélection') }}
                                </button>
                                <button type="button" class="btn btn-secondary" id="markAsRead" disabled>
                                    <i class="ri-mail-check-line me-1"></i> {{ __('Marquer comme lu') }}
                                </button>
                            </div>
                            <div>
                                {{ $messages->links() }}
                            </div>
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
        // Datatable
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
        
        // Sélectionner/Désélectionner tous les messages
        $('#checkAll').on('change', function() {
            $('input[id^="message"]').prop('checked', $(this).prop('checked'));
            updateButtonsState();
        });
        
        // Mettre à jour l'état des boutons en fonction de la sélection
        $('input[id^="message"]').on('change', function() {
            updateButtonsState();
        });
        
        function updateButtonsState() {
            var anyChecked = $('input[id^="message"]:checked').length > 0;
            $('#deleteSelected, #markAsRead').prop('disabled', !anyChecked);
        }
        
        // Supprimer les messages sélectionnés
        $('#deleteSelected').on('click', function() {
            if (confirm("{{ __('Êtes-vous sûr de vouloir supprimer les messages sélectionnés ?') }}")) {
                var selectedIds = [];
                $('input[id^="message"]:checked').each(function() {
                    selectedIds.push($(this).attr('id').replace('message', ''));
                });
                
                // Envoyer la requête AJAX pour supprimer les messages
                $.ajax({
                    url: "{{ route('agent.message.delete.multiple') }}",
                    type: "POST",
                    data: {
                        ids: selectedIds,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            // Recharger la page
                            location.reload();
                        }
                    }
                });
            }
        });
        
        // Marquer les messages sélectionnés comme lus
        $('#markAsRead').on('click', function() {
            var selectedIds = [];
            $('input[id^="message"]:checked').each(function() {
                selectedIds.push($(this).attr('id').replace('message', ''));
            });
            
            // Envoyer la requête AJAX pour marquer les messages comme lus
            $.ajax({
                url: "{{ route('agent.message.mark.read.multiple') }}",
                type: "POST",
                data: {
                    ids: selectedIds,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.success) {
                        // Recharger la page
                        location.reload();
                    }
                }
            });
        });
    });
</script>
@endsection
