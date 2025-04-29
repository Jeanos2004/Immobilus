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
            <h1>Mes messages envoyés</h1>
            <ul class="bread-crumb clearfix">
                <li><a href="/">Accueil</a></li>
                <li>Messages</li>
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
                            <li><a href="{{ route('user.inbox') }}"><i class="fas fa-inbox"></i> Boîte de réception</a></li>
                            <li class="current"><a href="{{ route('user.sent') }}"><i class="fas fa-paper-plane"></i> Messages envoyés</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Messages -->
            <div class="col-lg-9 col-md-12 col-sm-12 content-side">
                <div class="messaging-content">
                    <div class="upper-box">
                        <div class="title-box">
                            <h3>Messages envoyés</h3>
                        </div>
                    </div>
                    
                    <div class="messages-box">
                        @if(count($messages) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Destinataire</th>
                                        <th>Propriété</th>
                                        <th>Sujet</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($messages as $message)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ !empty($message->receiver->photo) ? asset($message->receiver->photo) : url('upload/no_image.jpg') }}" alt="{{ $message->receiver->name }}" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                                <div class="ms-2">
                                                    <h6 class="mb-0">{{ $message->receiver->name }}</h6>
                                                    <small>{{ $message->receiver->email }}</small>
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
                                            <a href="{{ route('message.view', $message->id) }}">
                                                {{ Str::limit($message->subject, 30) }}
                                                @if($message->read)
                                                <span class="badge bg-success">Lu</span>
                                                @else
                                                <span class="badge bg-warning">Non lu</span>
                                                @endif
                                            </a>
                                        </td>
                                        <td>{{ $message->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('message.view', $message->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a>
                                            <a href="{{ route('message.delete', $message->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce message ?')"><i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="alert alert-info text-center p-5">
                            <h4>Vous n'avez pas envoyé de messages</h4>
                            <p class="mt-3">Vous n'avez pas encore envoyé de messages aux agents immobiliers.</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- messaging-section end -->

@endsection
