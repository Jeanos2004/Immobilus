@extends('frontend.frontend_dashboard')
@section('content')

<!--Page Title-->
<section class="page-title-two bg-color-1 centred">
    <div class="pattern-layer">
        <div class="pattern-1" style="background-image: url({{ asset('frontend/assets/images/shape/shape-9.png') }});"></div>
        <div class="pattern-2" style="background-image: url({{ asset('frontend/assets/images/shape/shape-10.png') }});"></div>
    </div>
    <div class="auto-container">
        <div class="content-box clearfix">
            <h1>Détail du message</h1>
            <ul class="bread-crumb clearfix">
                <li><a href="/">Accueil</a></li>
                <li><a href="{{ route('user.inbox') }}">Messages</a></li>
                <li>Détail</li>
            </ul>
        </div>
    </div>
</section>
<!--End Page Title-->

<!-- messaging-section -->
<section class="messaging-section sec-pad">
    <div class="auto-container">
        <div class="row clearfix">
            <!-- Sidebar -->
            <div class="col-lg-3 col-md-12 col-sm-12 sidebar-side">
                <div class="default-sidebar messaging-sidebar">
                    <div class="sidebar-widget category-widget">
                        <ul class="category-list clearfix">
                            <li class="{{ $message->receiver_id == Auth::id() ? 'current' : '' }}"><a href="{{ route('user.inbox') }}"><i class="fas fa-inbox"></i> Boîte de réception</a></li>
                            <li class="{{ $message->sender_id == Auth::id() ? 'current' : '' }}"><a href="{{ route('user.sent') }}"><i class="fas fa-paper-plane"></i> Messages envoyés</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Message Detail -->
            <div class="col-lg-9 col-md-12 col-sm-12 content-side">
                <div class="messaging-content">
                    <div class="upper-box">
                        <div class="title-box d-flex justify-content-between align-items-center">
                            <h3>{{ $message->subject }}</h3>
                            <a href="{{ URL::previous() }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Retour</a>
                        </div>
                    </div>
                    
                    <div class="message-details p-4 mb-4 border rounded">
                        <div class="message-header d-flex justify-content-between border-bottom pb-3 mb-3">
                            <div class="sender-info d-flex">
                                @if($message->sender_id == Auth::id())
                                    <!-- Si l'utilisateur est l'expéditeur, afficher le destinataire -->
                                    <img src="{{ !empty($message->receiver->photo) ? asset($message->receiver->photo) : url('upload/no_image.jpg') }}" alt="{{ $message->receiver->name }}" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                    <div class="ms-3">
                                        <h5 class="mb-0">À: {{ $message->receiver->name }}</h5>
                                        <small>{{ $message->receiver->email }}</small>
                                    </div>
                                @else
                                    <!-- Si l'utilisateur est le destinataire, afficher l'expéditeur -->
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
                        
                        <!-- Réponse au message (seulement si l'utilisateur est le destinataire) -->
                        @if($message->receiver_id == Auth::id() && $message->parent_id === null)
                        <div class="reply-form mt-4">
                            <h5 class="border-bottom pb-2 mb-3">Répondre</h5>
                            <form action="{{ route('message.reply') }}" method="post">
                                @csrf
                                <input type="hidden" name="parent_id" value="{{ $message->id }}">
                                <input type="hidden" name="property_id" value="{{ $message->property_id }}">
                                <input type="hidden" name="agent_id" value="{{ $message->sender_id }}">
                                
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
                                    <button type="submit" class="theme-btn btn-one">Envoyer la réponse</button>
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
                        <a href="{{ URL::previous() }}" class="theme-btn btn-one">Retour</a>
                        <a href="{{ route('message.delete', $message->id) }}" class="theme-btn btn-two" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce message ?')">Supprimer</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- messaging-section end -->

@endsection
