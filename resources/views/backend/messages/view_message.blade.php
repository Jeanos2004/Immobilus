@extends('admin.admin_dashboard')
@section('admin')

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">View Message</h4>
                        
                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <a href="{{ route('all.messages') }}" class="btn btn-primary">Back to Messages</a>
                            </div>
                            <div class="col-lg-6 text-end">
                                <span class="badge bg-{{ $message->status == 'read' ? 'success' : 'danger' }}">
                                    {{ ucfirst($message->status) }}
                                </span>
                                <span class="ms-2">
                                    {{ $message->created_at->format('d/m/Y H:i') }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="message-details mt-4">
                            <div class="row mb-3">
                                <div class="col-lg-2 fw-bold">From:</div>
                                <div class="col-lg-10">{{ $message->name }} ({{ $message->email }})</div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-lg-2 fw-bold">Phone:</div>
                                <div class="col-lg-10">{{ $message->phone }}</div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-lg-2 fw-bold">Subject:</div>
                                <div class="col-lg-10">{{ $message->subject }}</div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-lg-2 fw-bold">Message:</div>
                                <div class="col-lg-10">
                                    <div class="card">
                                        <div class="card-body">
                                            {{ $message->message }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mt-4">
                                <div class="col-12 text-end">
                                    <a href="mailto:{{ $message->email }}" class="btn btn-success">Reply by Email</a>
                                    <a href="{{ route('admin.message.delete', $message->id) }}" class="btn btn-danger" id="delete">Delete Message</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
