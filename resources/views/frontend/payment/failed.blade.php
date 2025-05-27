@extends('frontend.frontend_dashboard')
@section('content')

<!-- page-title -->
<section class="page-title centred">
    <div class="container">
        <div class="content-box">
            <h1>{{ __('Paiement échoué') }}</h1>
            <ul class="bread-crumb clearfix">
                <li><a href="{{ route('homepage') }}">{{ __('Accueil') }}</a></li>
                <li>{{ __('Paiement') }}</li>
                <li>{{ __('Échec') }}</li>
            </ul>
        </div>
    </div>
</section>
<!-- page-title end -->

<!-- failed-section -->
<section class="failed-section sec-pad">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12 col-sm-12 offset-lg-2">
                <div class="failed-content text-center">
                    <div class="failed-icon">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <h2>{{ __('Le paiement a échoué') }}</h2>
                    <p>{{ __('Nous n\'avons pas pu traiter votre paiement. Veuillez vérifier vos informations et réessayer.') }}</p>
                    
                    <div class="error-details">
                        <h4>{{ __('Raisons possibles de l\'échec') }}</h4>
                        <ul>
                            <li>{{ __('Informations de carte incorrectes ou incomplètes') }}</li>
                            <li>{{ __('Fonds insuffisants sur votre compte') }}</li>
                            <li>{{ __('Problème temporaire avec votre banque') }}</li>
                            <li>{{ __('Problème de connexion avec notre système de paiement') }}</li>
                            <li>{{ __('Transaction refusée par votre banque pour des raisons de sécurité') }}</li>
                        </ul>
                    </div>
                    
                    <div class="help-section">
                        <h4>{{ __('Besoin d\'aide ?') }}</h4>
                        <p>{{ __('Si vous continuez à rencontrer des problèmes avec votre paiement, n\'hésitez pas à nous contacter :') }}</p>
                        <div class="contact-options">
                            <div class="contact-option">
                                <i class="fas fa-phone-alt"></i>
                                <p>+224 620 327 906</p>
                            </div>
                            <div class="contact-option">
                                <i class="fas fa-envelope"></i>
                                <p>support@immobilus.com</p>
                            </div>
                            <div class="contact-option">
                                <i class="fas fa-comment-dots"></i>
                                <p>{{ __('Chat en direct') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="action-buttons">
                        <a href="javascript:history.back()" class="theme-btn btn-one">{{ __('Réessayer') }}</a>
                        <a href="{{ route('homepage') }}" class="theme-btn btn-two">{{ __('Retour à l\'accueil') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- failed-section end -->

@endsection

@push('styles')
<style>
    .failed-content {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        padding: 40px;
    }
    
    .failed-icon {
        font-size: 80px;
        color: #ff5a5f;
        margin-bottom: 20px;
    }
    
    .failed-content h2 {
        margin-bottom: 15px;
        color: #ff5a5f;
    }
    
    .failed-content p {
        font-size: 16px;
        margin-bottom: 30px;
    }
    
    .error-details, .help-section {
        margin-top: 40px;
        padding-top: 30px;
        border-top: 1px solid #e5e5e5;
    }
    
    .error-details h4, .help-section h4 {
        margin-bottom: 20px;
        font-size: 20px;
    }
    
    .error-details ul {
        list-style: none;
        padding: 0;
        margin: 0;
        background-color: #f8f8f8;
        border-radius: 5px;
        padding: 20px;
    }
    
    .error-details ul li {
        padding: 10px 0;
        border-bottom: 1px solid #e5e5e5;
        color: #555;
    }
    
    .error-details ul li:last-child {
        border-bottom: none;
    }
    
    .error-details ul li:before {
        content: "\f071";
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        margin-right: 10px;
        color: #ff5a5f;
    }
    
    .contact-options {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
        margin-top: 20px;
    }
    
    .contact-option {
        flex: 1;
        min-width: 150px;
        max-width: 200px;
        background-color: #f8f8f8;
        border-radius: 5px;
        padding: 20px;
        text-align: center;
    }
    
    .contact-option i {
        font-size: 30px;
        color: #2dbe6c;
        margin-bottom: 10px;
    }
    
    .contact-option p {
        margin: 0;
        font-size: 14px;
    }
    
    .action-buttons {
        margin-top: 40px;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 15px;
    }
    
    @media (max-width: 767px) {
        .contact-options {
            flex-direction: column;
            align-items: center;
        }
        
        .contact-option {
            width: 100%;
        }
    }
</style>
@endpush
