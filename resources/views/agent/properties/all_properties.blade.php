@extends('agent.agent_dashboard')
@section('content')

<div class="page-content">
    <div class="container-fluid">
        
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">{{ __('Mes propriétés') }}</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('agent.dashboard') }}">{{ __('Tableau de bord') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('Propriétés') }}</li>
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
                            <h4 class="card-title">{{ __('Liste des propriétés') }}</h4>
                            <div class="ms-auto">
                                <a href="{{ route('agent.property.create') }}" class="btn btn-primary">
                                    <i class="ri-add-line me-1"></i> {{ __('Ajouter une propriété') }}
                                </a>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="card mini-stats-wid border">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium">{{ __('Total') }}</p>
                                                <h4 class="mb-0">{{ $properties->total() }}</h4>
                                            </div>

                                            <div class="flex-shrink-0 align-self-center">
                                                <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                    <span class="avatar-title">
                                                        <i class="ri-building-line font-size-24"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card mini-stats-wid border">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium">{{ __('À vendre') }}</p>
                                                <h4 class="mb-0">{{ $properties->where('property_status', 'buy')->count() }}</h4>
                                            </div>

                                            <div class="flex-shrink-0 align-self-center">
                                                <div class="mini-stat-icon avatar-sm rounded-circle bg-success">
                                                    <span class="avatar-title">
                                                        <i class="ri-price-tag-3-line font-size-24"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card mini-stats-wid border">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium">{{ __('À louer') }}</p>
                                                <h4 class="mb-0">{{ $properties->where('property_status', 'rent')->count() }}</h4>
                                            </div>

                                            <div class="flex-shrink-0 align-self-center">
                                                <div class="mini-stat-icon avatar-sm rounded-circle bg-warning">
                                                    <span class="avatar-title">
                                                        <i class="ri-key-line font-size-24"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card mini-stats-wid border">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium">{{ __('Vues totales') }}</p>
                                                <h4 class="mb-0">{{ $properties->sum('views') }}</h4>
                                            </div>

                                            <div class="flex-shrink-0 align-self-center">
                                                <div class="mini-stat-icon avatar-sm rounded-circle bg-info">
                                                    <span class="avatar-title">
                                                        <i class="ri-eye-line font-size-24"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>{{ __('Image') }}</th>
                                        <th>{{ __('Nom') }}</th>
                                        <th>{{ __('Type') }}</th>
                                        <th>{{ __('Statut') }}</th>
                                        <th>{{ __('Prix') }}</th>
                                        <th>{{ __('Vues') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($properties as $property)
                                    <tr>
                                        <td>
                                            <img src="{{ asset(!empty($property->property_thumbnail) ? $property->property_thumbnail : 'upload/no_image.jpg') }}" alt="" class="avatar-md rounded">
                                        </td>
                                        <td>
                                            <h5 class="font-size-14 mb-1">
                                                <a href="{{ route('property.details', [$property->id, Str::slug($property->property_name)]) }}" class="text-dark">{{ Str::limit($property->property_name, 30) }}</a>
                                            </h5>
                                            <p class="text-muted mb-0">{{ Str::limit($property->address, 30) }}</p>
                                        </td>
                                        <td>{{ $property->type->type_name ?? 'N/A' }}</td>
                                        <td>
                                            @if($property->status == 1)
                                                <span class="badge badge-soft-success">{{ __('Actif') }}</span>
                                            @else
                                                <span class="badge badge-soft-danger">{{ __('Inactif') }}</span>
                                            @endif
                                            <br>
                                            <span class="badge badge-soft-info mt-1">
                                                {{ $property->property_status == 'rent' ? __('À louer') : __('À vendre') }}
                                            </span>
                                        </td>
                                        <td>{{ number_format($property->lowest_price, 0, ',', ' ') }} €</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="ri-eye-line text-muted me-1"></i>
                                                <span>{{ $property->views }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('property.details', [$property->id, Str::slug($property->property_name)]) }}" target="_blank" class="btn btn-sm btn-info" title="{{ __('Voir') }}">
                                                    <i class="ri-eye-line"></i>
                                                </a>
                                                <a href="{{ route('agent.property.edit', $property->id) }}" class="btn btn-sm btn-primary" title="{{ __('Modifier') }}">
                                                    <i class="ri-pencil-line"></i>
                                                </a>
                                                @if($property->status == 1)
                                                    <a href="{{ route('agent.property.inactive', $property->id) }}" class="btn btn-sm btn-warning" title="{{ __('Désactiver') }}">
                                                        <i class="ri-eye-off-line"></i>
                                                    </a>
                                                @else
                                                    <a href="{{ route('agent.property.active', $property->id) }}" class="btn btn-sm btn-success" title="{{ __('Activer') }}">
                                                        <i class="ri-eye-line"></i>
                                                    </a>
                                                @endif
                                                <a href="{{ route('agent.property.delete', $property->id) }}" class="btn btn-sm btn-danger" title="{{ __('Supprimer') }}" onclick="return confirm('{{ __('Êtes-vous sûr de vouloir supprimer cette propriété ?') }}')">
                                                    <i class="ri-delete-bin-line"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center">{{ __('Aucune propriété trouvée') }}</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-end mt-3">
                            {{ $properties->links() }}
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
