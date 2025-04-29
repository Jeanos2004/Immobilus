@extends('admin.admin_dashboard')
@section('admin')

<div class="page-content">
    <div class="container-fluid">
        
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Tous les messages</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Immobilus</a></li>
                            <li class="breadcrumb-item active">Messages</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Liste des messages</h4>
                        
                        <div class="table-responsive">
                            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Expéditeur</th>
                                        <th>Destinataire</th>
                                        <th>Propriété</th>
                                        <th>Sujet</th>
                                        <th>Statut</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($messages as $key => $message)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ !empty($message->sender->photo) ? asset($message->sender->photo) : url('upload/no_image.jpg') }}" alt="{{ $message->sender->name }}" class="rounded-circle avatar-xs">
                                                <div class="ms-2">
                                                    <h6 class="mb-0 font-size-14">{{ $message->sender->name }}</h6>
                                                    <small>{{ $message->sender->email }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ !empty($message->receiver->photo) ? asset($message->receiver->photo) : url('upload/no_image.jpg') }}" alt="{{ $message->receiver->name }}" class="rounded-circle avatar-xs">
                                                <div class="ms-2">
                                                    <h6 class="mb-0 font-size-14">{{ $message->receiver->name }}</h6>
                                                    <small>{{ $message->receiver->email }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($message->property)
                                            <a href="{{ url('property/details/'.$message->property->id.'/'.$message->property->property_slug) }}" target="_blank">
                                                {{ Str::limit($message->property->property_name, 20) }}
                                            </a>
                                            @else
                                            <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.message.view', $message->id) }}">
                                                {{ Str::limit($message->subject, 30) }}
                                                @if($message->parent_id)
                                                <span class="badge bg-info">Réponse</span>
                                                @endif
                                            </a>
                                        </td>
                                        <td>
                                            @if($message->read)
                                            <span class="badge bg-success">Lu</span>
                                            @else
                                            <span class="badge bg-warning">Non lu</span>
                                            @endif
                                        </td>
                                        <td>{{ $message->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('admin.message.view', $message->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a>
                                            <a href="{{ route('admin.message.delete', $message->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce message ?')"><i class="fas fa-trash"></i></a>
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
</div>

@endsection
