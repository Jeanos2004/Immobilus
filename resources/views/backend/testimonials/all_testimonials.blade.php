@extends('admin.admin_dashboard')
@section('admin')

<div class="page-content">
    <div class="container-fluid">
        
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Tous les témoignages</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item active">Témoignages</li>
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
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h4 class="card-title">Liste des témoignages</h4>
                            <a href="{{ route('add.testimonial') }}" class="btn btn-primary"><i class="ri-add-line align-middle me-1"></i> Ajouter un témoignage</a>
                        </div>
                        
                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th width="5%">ID</th>
                                    <th width="10%">Photo</th>
                                    <th>Nom</th>
                                    <th>Position</th>
                                    <th>Message</th>
                                    <th>Évaluation</th>
                                    <th>Statut</th>
                                    <th width="15%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($testimonials as $key => $item)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>
                                        @if($item->photo)
                                            <img src="{{ asset($item->photo) }}" alt="{{ $item->name }}" class="rounded-circle avatar-sm">
                                        @else
                                            <img src="{{ asset('frontend/assets/images/resource/testimonial-1.jpg') }}" alt="{{ $item->name }}" class="rounded-circle avatar-sm">
                                        @endif
                                    </td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->position }}</td>
                                    <td>{{ Str::limit($item->message, 50) }}</td>
                                    <td>
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $item->rating)
                                                <i class="ri-star-fill text-warning"></i>
                                            @else
                                                <i class="ri-star-line text-muted"></i>
                                            @endif
                                        @endfor
                                    </td>
                                    <td>
                                        @if($item->status == 1)
                                            <a href="{{ route('testimonial.status', $item->id) }}" class="btn btn-success btn-sm">Actif</a>
                                        @else
                                            <a href="{{ route('testimonial.status', $item->id) }}" class="btn btn-danger btn-sm">Inactif</a>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('edit.testimonial', $item->id) }}" class="btn btn-info btn-sm" title="Modifier"><i class="fas fa-edit"></i></a>
                                        <a href="{{ route('delete.testimonial', $item->id) }}" class="btn btn-danger btn-sm" id="delete" title="Supprimer"><i class="fas fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
        
    </div> <!-- container-fluid -->
</div>

@endsection
