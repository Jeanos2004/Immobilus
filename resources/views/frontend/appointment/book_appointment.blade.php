@extends('frontend.frontend_dashboard')
@section('content')

<!-- Inner Banner -->
<div class="inner-banner">
    <div class="container">
        <div class="inner-title text-center">
            <h3>Prendre rendez-vous</h3>
            <ul>
                <li>
                    <a href="{{ url('/') }}">Accueil</a>
                </li>
                <li>
                    <a href="{{ route('property.details', [$property->id, $property->property_slug]) }}">{{ $property->property_name }}</a>
                </li>
                <li>Rendez-vous</li>
            </ul>
        </div>
    </div>
</div>
<!-- Inner Banner End -->

<!-- Appointment Form Area -->
<div class="contact-area pt-100 pb-70">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="contact-form">
                    <div class="contact-title">
                        <h2>Prendre rendez-vous pour visiter cette propriété</h2>
                        <p>Remplissez le formulaire ci-dessous pour demander une visite de la propriété <strong>{{ $property->property_name }}</strong> avec l'agent <strong>{{ $property->agent->name }}</strong>.</p>
                    </div>

                    <form method="POST" action="{{ route('store.appointment') }}">
                        @csrf
                        <input type="hidden" name="property_id" value="{{ $property->id }}">
                        <input type="hidden" name="agent_id" value="{{ $property->agent_id }}">
                        
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Date et heure souhaitées</label>
                                    <input type="datetime-local" name="appointment_date" class="form-control @error('appointment_date') is-invalid @enderror" required min="{{ date('Y-m-d\TH:i') }}">
                                    @error('appointment_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <label>Message (facultatif)</label>
                                    <textarea name="message" class="form-control @error('message') is-invalid @enderror" rows="4" placeholder="Précisez vos disponibilités ou toute information utile pour la visite..."></textarea>
                                    @error('message')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12 text-center">
                                <button type="submit" class="default-btn">
                                    Demander un rendez-vous
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="contact-info">
                    <h3>Informations sur la propriété</h3>
                    <div class="contact-info-item">
                        <div class="contact-info-text">
                            <h4>Adresse</h4>
                            <p>{{ $property->property_address }}</p>
                        </div>
                    </div>
                    <div class="contact-info-item">
                        <div class="contact-info-text">
                            <h4>Prix</h4>
                            <p>{{ number_format($property->prix, 0, ',', ' ') }} €</p>
                        </div>
                    </div>
                    <div class="contact-info-item">
                        <div class="contact-info-text">
                            <h4>Agent</h4>
                            <p>{{ $property->agent->name }}</p>
                            <p>{{ $property->agent->email }}</p>
                            @if($property->agent->phone)
                                <p>{{ $property->agent->phone }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Appointment Form Area End -->

@endsection
