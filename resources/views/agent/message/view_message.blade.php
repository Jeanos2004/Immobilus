@extends('agent.agent_dashboard')
@section('agent')

<div class="page-content">
    <div class="container-fluid">
        
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Détail du message</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Immobilus</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('agent.inbox') }}">Messages</a></li>
                            <li class="breadcrumb-item active">Détail</li>
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
                            <a href="{{ route('agent.inbox') }}" class="{{ $message->receiver_id == Auth::id() ? 'active' : '' }}"><i class="fas fa-inbox me-2"></i> Boîte de réception</a>
                            <a href="{{ route('agent.sent') }}" class="{{ $message->sender_id == Auth::id() ? 'active' : '' }}"><i class="fas fa-paper-plane me-2"></i> Messages envoyés</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="card-title">{{ $message->subject }}</h4>
                            <a href="{{ URL::previous() }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i> Retour</a>
                        </div>
                        
                        <div class="message-details p-4 mb-4 border rounded">
                            <div class="message-header d-flex justify-content-between border-bottom pb-3 mb-3">
                                <div class="sender-info d-flex">
                                    @if($message->sender_id == Auth::id())
                                        <!-- Si l'agent est l'expéditeur, afficher le destinataire -->
                                        <img src="{{ !empty($message->receiver->photo) ? asset($message->receiver->photo) : url('upload/no_image.jpg') }}" alt="{{ $message->receiver->name }}" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                        <div class="ms-3">
                                            <h5 class="mb-0">À: {{ $message->receiver->name }}</h5>
                                            <small>{{ $message->receiver->email }}</small>
                                        </div>
                                    @else
                                        <!-- Si l'agent est le destinataire, afficher l'expéditeur -->
                                        <img src="{{ !empty($message->sender->photo) ? asset($message->sender->photo) : url('upload/no_image.jpg') }}" alt="{{ $message->sender->name }}" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                        <div class="ms-3">
                                            <h5 class="mb-0">De: {{ $message->sender->name }}</h5>
                                            <small>{{ $message->sender->email }}</small>
                                        </div>
                                    @endif
                                </div>
                                <div class="message-date">
                                    <span class="text-muted">{{ $message->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>
                            
                            @if($message->property)
                            <div class="property-info border-bottom pb-3 mb-3">
                                <h6>Propriété concernée:</h6>
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset($message->property->property_thumbnail) }}" alt="{{ $message->property->property_name }}" class="rounded" style="width: 80px; height: 60px; object-fit: cover;">
                                    <div class="ms-3">
                                        <h5 class="mb-1">
                                            <a href="{{ url('property/details/'.$message->property->id.'/'.$message->property->property_slug) }}" target="_blank">
                                                {{ $message->property->property_name }}
                                            </a>
                                        </h5>
                                        <p class="mb-0 text-muted">{{ $message->property->property_address }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            <div class="message-content mb-4">
                                <h6>Message:</h6>
                                <div class="p-3 bg-light rounded">
                                    {!! nl2br(e($message->message)) !!}
                                </div>
                            </div>
                            
                            <!-- Réponse au message (seulement si l'agent est le destinataire) -->
                            @if($message->receiver_id == Auth::id() && $message->parent_id === null)
                            <div class="reply-form mt-4">
                                <h5 class="border-bottom pb-2 mb-3">Répondre</h5>
                                <form action="{{ route('agent.message.reply') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="parent_id" value="{{ $message->id }}">
                                    <input type="hidden" name="property_id" value="{{ $message->property_id }}">
                                    <input type="hidden" name="user_id" value="{{ $message->sender_id }}">
                                    
                                    <div class="form-group mb-3">
                                        <label for="subject" class="form-label">Sujet</label>
                                        <input type="text" name="subject" id="subject" class="form-control" value="RE: {{ $message->subject }}" required>
                                        @error('subject')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group mb-3">
                                        <label for="reply_message" class="form-label">Message</label>
                                        <textarea name="message" id="reply_message" class="form-control" rows="5" required></textarea>
                                        @error('message')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Envoyer la réponse</button>
                                    </div>
                                </form>
                            </div>
                            @endif
                            
                            <!-- Afficher les réponses à ce message -->
                            @if($replies->count() > 0)
                            <div class="replies mt-5">
                                <h5 class="border-bottom pb-2 mb-3">Réponses ({{ $replies->count() }})</h5>
                                
                                @foreach($replies as $reply)
                                <div class="reply-item mb-3 p-3 border rounded {{ $reply->sender_id == Auth::id() ? 'bg-light' : 'bg-white' }}">
                                    <div class="reply-header d-flex justify-content-between border-bottom pb-2 mb-2">
                                        <div class="sender-info d-flex">
                                            <img src="{{ !empty($reply->sender->photo) ? asset($reply->sender->photo) : url('upload/no_image.jpg') }}" alt="{{ $reply->sender->name }}" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                            <div class="ms-2">
                                                <h6 class="mb-0">{{ $reply->sender->name }}</h6>
                                                <small>{{ $reply->created_at->format('d/m/Y H:i') }}</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="reply-content">
                                        <p class="mb-0">{!! nl2br(e($reply->message)) !!}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </div>
                        
                        <div class="actions-box d-flex justify-content-between">
                            <a href="{{ URL::previous() }}" class="btn btn-secondary">Retour</a>
                            <a href="{{ route('agent.message.delete', $message->id) }}" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce message ?')">Supprimer</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>

@endsection
