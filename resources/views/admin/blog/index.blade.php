@extends('admin.admin_dashboard')
@section('admin')

<div class="page-content">
    <div class="container-fluid">
        
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Articles de blog</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item active">Articles de blog</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h4 class="card-title">Liste des articles</h4>
                            <a href="{{ route('admin.blog.create') }}" class="btn btn-primary waves-effect waves-light"><i class="ri-add-line align-middle me-1"></i> Ajouter un article</a>
                        </div>
                        
                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th width="5%">ID</th>
                                    <th width="15%">Image</th>
                                    <th>Titre</th>
                                    <th>Catégorie</th>
                                    <th>Auteur</th>
                                    <th>Statut</th>
                                    <th>Vues</th>
                                    <th width="15%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($posts as $key => $post)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>
                                        <img src="{{ asset($post->featured_image) }}" alt="{{ $post->title }}" class="rounded" width="100">
                                    </td>
                                    <td>{{ Str::limit($post->title, 30) }}</td>
                                    <td>{{ $post->category->name }}</td>
                                    <td>{{ $post->user->name }}</td>
                                    <td>
                                        @if($post->status == 1)
                                            <span class="badge rounded-pill bg-success">Publié</span>
                                        @else
                                            <span class="badge rounded-pill bg-danger">Brouillon</span>
                                        @endif
                                    </td>
                                    <td>{{ $post->views }}</td>
                                    <td>
                                        <a href="{{ route('admin.blog.show', $post->id) }}" class="btn btn-info btn-sm" title="Voir">
                                            <i class="ri-eye-line"></i>
                                        </a>
                                        <a href="{{ route('admin.blog.edit', $post->id) }}" class="btn btn-warning btn-sm" title="Modifier">
                                            <i class="ri-edit-line"></i>
                                        </a>
                                        <a href="#" class="btn btn-danger btn-sm delete-btn" title="Supprimer" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $post->id }}">
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

<!-- Modal de suppression -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirmation de suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Êtes-vous sûr de vouloir supprimer cet article ? Cette action est irréversible.
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
        $('.delete-btn').on('click', function() {
            var id = $(this).data('id');
            $('#deleteForm').attr('action', '{{ route("admin.blog.destroy", "") }}/' + id);
        });
    });
</script>
@endsection
