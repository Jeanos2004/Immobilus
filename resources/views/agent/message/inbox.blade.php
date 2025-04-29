@extends('agent.agent_dashboard')
@section('agent')

<div class="page-content">
    <div class="container-fluid">
        
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Boîte de réception</h4>
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
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="mail-list">
                            <a href="{{ route('agent.inbox') }}" class="active"><i class="fas fa-inbox me-2"></i> Boîte de réception <span class="badge bg-primary float-end">{{ count($messages->where('read', false)) }}</span></a>
                            <a href="{{ route('agent.sent') }}"><i class="fas fa-paper-plane me-2"></i> Messages envoyés</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Mes messages reçus</h4>
                        
                        @if(count($messages) > 0)
                        <div class="table-responsive">
                            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Expéditeur</th>
                                        <th>Propriété</th>
                                        <th>Sujet</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($messages as $message)
                                    <tr class="{{ $message->read ? '' : 'table-primary' }}">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ !empty($message->sender->photo) ? asset($message->sender->photo) : url('upload/no_image.jpg') }}" alt="{{ $message->sender->name }}" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                                <div class="ms-2">
                                                    <h6 class="mb-0">{{ $message->sender->name }}</h6>
                                                    <small>{{ $message->sender->email }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($message->property)
                                            <a href="{{ url('property/details/'.$message->property->id.'/'.$message->property->property_slug) }}" target="_blank">
                                                {{ Str::limit($message->property->property_name, 30) }}
                                            </a>
                                            @else
                                            <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('agent.message.view', $message->id) }}">
                                                {{ Str::limit($message->subject, 30) }}
                                                @if(!$message->read)
                                                <span class="badge bg-danger">Nouveau</span>
                                                @endif
                                            </a>
                                        </td>
                                        <td>{{ $message->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('agent.message.view', $message->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a>
                                            <a href="{{ route('agent.message.delete', $message->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce message ?')"><i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="alert alert-info text-center p-5">
                            <h4>Vous n'avez pas de messages</h4>
                            <p class="mt-3">Votre boîte de réception est vide.</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>

@endsection
