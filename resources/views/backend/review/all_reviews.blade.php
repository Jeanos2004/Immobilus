@extends('admin.admin_dashboard')
@section('content')

<div class="page-content">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Gestion des avis</h6>
                    <p class="text-muted mb-3">Vous pouvez approuver, rejeter ou supprimer les avis des utilisateurs sur les propriétés.</p>
                    
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Propriété</th>
                                    <th>Utilisateur</th>
                                    <th>Note</th>
                                    <th>Commentaire</th>
                                    <th>Date</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reviews as $key => $item)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>
                                        <a href="{{ url('property/details/'.$item->property->id.'/'.$item->property->property_slug) }}" target="_blank">
                                            {{ $item->property->property_name }}
                                        </a>
                                    </td>
                                    <td>{{ $item->user->name }}</td>
                                    <td>
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $item->rating)
                                                <i class="fas fa-star text-warning"></i>
                                            @else
                                                <i class="far fa-star text-warning"></i>
                                            @endif
                                        @endfor
                                        ({{ $item->rating }}/5)
                                    </td>
                                    <td>{{ Str::limit($item->comment, 50) }}</td>
                                    <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        @if($item->status == 'pending')
                                            <span class="badge bg-warning">En attente</span>
                                        @elseif($item->status == 'approved')
                                            <span class="badge bg-success">Approuvé</span>
                                        @else
                                            <span class="badge bg-danger">Rejeté</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->status == 'pending')
                                            <a href="{{ route('review.approve', $item->id) }}" class="btn btn-inverse-success btn-sm" title="Approuver">
                                                <i data-feather="check-circle"></i>
                                            </a>
                                            <a href="{{ route('review.reject', $item->id) }}" class="btn btn-inverse-warning btn-sm" title="Rejeter">
                                                <i data-feather="x-circle"></i>
                                            </a>
                                        @elseif($item->status == 'approved')
                                            <a href="{{ route('review.reject', $item->id) }}" class="btn btn-inverse-warning btn-sm" title="Rejeter">
                                                <i data-feather="x-circle"></i>
                                            </a>
                                        @else
                                            <a href="{{ route('review.approve', $item->id) }}" class="btn btn-inverse-success btn-sm" title="Approuver">
                                                <i data-feather="check-circle"></i>
                                            </a>
                                        @endif
                                        
                                        <a href="{{ route('review.delete', $item->id) }}" id="delete" class="btn btn-inverse-danger btn-sm" title="Supprimer">
                                            <i data-feather="trash-2"></i>
                                        </a>
                                        
                                        <!-- Bouton pour voir le commentaire complet -->
                                        <button type="button" class="btn btn-inverse-info btn-sm" data-bs-toggle="modal" data-bs-target="#reviewModal{{ $item->id }}" title="Voir le commentaire">
                                            <i data-feather="eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                
                                <!-- Modal pour afficher le commentaire complet -->
                                <div class="modal fade" id="reviewModal{{ $item->id }}" tabindex="-1" aria-labelledby="reviewModalLabel{{ $item->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="reviewModalLabel{{ $item->id }}">Avis de {{ $item->user->name }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h6>Propriété : {{ $item->property->property_name }}</h6>
                                                <p><strong>Note : </strong>
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $item->rating)
                                                            <i class="fas fa-star text-warning"></i>
                                                        @else
                                                            <i class="far fa-star text-warning"></i>
                                                        @endif
                                                    @endfor
                                                    ({{ $item->rating }}/5)
                                                </p>
                                                <p><strong>Commentaire : </strong></p>
                                                <p>{{ $item->comment }}</p>
                                                <p><strong>Date : </strong>{{ $item->created_at->format('d/m/Y H:i') }}</p>
                                                <p><strong>Statut : </strong>
                                                    @if($item->status == 'pending')
                                                        <span class="badge bg-warning">En attente</span>
                                                    @elseif($item->status == 'approved')
                                                        <span class="badge bg-success">Approuvé</span>
                                                    @else
                                                        <span class="badge bg-danger">Rejeté</span>
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                @if($item->status == 'pending')
                                                    <a href="{{ route('review.approve', $item->id) }}" class="btn btn-success">Approuver</a>
                                                    <a href="{{ route('review.reject', $item->id) }}" class="btn btn-warning">Rejeter</a>
                                                @elseif($item->status == 'approved')
                                                    <a href="{{ route('review.reject', $item->id) }}" class="btn btn-warning">Rejeter</a>
                                                @else
                                                    <a href="{{ route('review.approve', $item->id) }}" class="btn btn-success">Approuver</a>
                                                @endif
                                                <a href="{{ route('review.delete', $item->id) }}" id="delete" class="btn btn-danger">Supprimer</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
