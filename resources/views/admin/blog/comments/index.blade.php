@extends('admin.admin_dashboard')
@section('admin')

<div class="page-content">
    <div class="container-fluid">
        
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Commentaires du blog</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Blog</a></li>
                            <li class="breadcrumb-item active">Commentaires</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Liste des commentaires</h4>
                        
                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th width="5%">ID</th>
                                    <th>Article</th>
                                    <th>Utilisateur</th>
                                    <th>Commentaire</th>
                                    <th>Date</th>
                                    <th>Statut</th>
                                    <th width="15%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($comments as $key => $comment)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>
                                        <a href="{{ route('blog.show', $comment->post->slug) }}" target="_blank">
                                            {{ Str::limit($comment->post->title, 30) }}
                                        </a>
                                    </td>
                                    <td>{{ $comment->user->name }}</td>
                                    <td>{{ Str::limit($comment->comment, 50) }}</td>
                                    <td>{{ $comment->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        @if($comment->status == 1)
                                            <span class="badge rounded-pill bg-success">Approuvé</span>
                                        @else
                                            <span class="badge rounded-pill bg-danger">Non approuvé</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.blog.comment.toggle', $comment->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('PUT')
                                            @if($comment->status == 1)
                                                <button type="submit" class="btn btn-warning btn-sm" title="Désapprouver">
                                                    <i class="ri-eye-off-line"></i>
                                                </button>
                                            @else
                                                <button type="submit" class="btn btn-success btn-sm" title="Approuver">
                                                    <i class="ri-eye-line"></i>
                                                </button>
                                            @endif
                                        </form>
                                        
                                        <button type="button" class="btn btn-info btn-sm view-btn" data-bs-toggle="modal" data-bs-target="#viewModal" 
                                            data-comment="{{ $comment->comment }}" 
                                            data-user="{{ $comment->user->name }}" 
                                            data-post="{{ $comment->post->title }}" 
                                            data-date="{{ $comment->created_at->format('d/m/Y H:i') }}">
                                            <i class="ri-search-line"></i>
                                        </button>
                                        
                                        <a href="#" class="btn btn-danger btn-sm delete-btn" title="Supprimer" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $comment->id }}">
                                            <i class="ri-delete-bin-line"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>

<!-- Modal de visualisation -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewModalLabel">Détails du commentaire</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <h6>Article :</h6>
                    <p id="postTitle"></p>
                </div>
                <div class="mb-3">
                    <h6>Utilisateur :</h6>
                    <p id="userName"></p>
                </div>
                <div class="mb-3">
                    <h6>Date :</h6>
                    <p id="commentDate"></p>
                </div>
                <div class="mb-3">
                    <h6>Commentaire :</h6>
                    <p id="commentText"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de suppression -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirmation de suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Êtes-vous sûr de vouloir supprimer ce commentaire ? Cette action est irréversible.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form id="deleteForm" action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Afficher les détails du commentaire
        $('.view-btn').on('click', function() {
            var comment = $(this).data('comment');
            var user = $(this).data('user');
            var post = $(this).data('post');
            var date = $(this).data('date');
            
            $('#commentText').text(comment);
            $('#userName').text(user);
            $('#postTitle').text(post);
            $('#commentDate').text(date);
        });
        
        // Supprimer un commentaire
        $('.delete-btn').on('click', function() {
            var id = $(this).data('id');
            $('#deleteForm').attr('action', '{{ route("admin.blog.comment.destroy", "") }}/' + id);
        });
    });
</script>
@endsection
