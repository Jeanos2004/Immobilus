@extends('frontend.frontend_dashboard')
@section('content')

<!-- page-title -->
<section class="page-title centred">
    <div class="container">
        <div class="content-box">
            <h1>{{ __('Paiement réussi') }}</h1>
            <ul class="bread-crumb clearfix">
                <li><a href="{{ route('homepage') }}">{{ __('Accueil') }}</a></li>
                <li>{{ __('Paiement') }}</li>
                <li>{{ __('Succès') }}</li>
            </ul>
        </div>
    </div>
</section>
<!-- page-title end -->

<!-- success-section -->
<section class="success-section sec-pad">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12 col-sm-12 offset-lg-2">
                <div class="success-content text-center">
                    <div class="success-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h2>{{ __('Paiement effectué avec succès !') }}</h2>
                    <p>{{ __('Votre transaction a été traitée avec succès. Vous recevrez un email de confirmation dans les prochaines minutes.') }}</p>
                    
                    <div class="transaction-details">
                        <h4>{{ __('Détails de la transaction') }}</h4>
                        <ul>
                            <li>
                                <span class="detail-label">{{ __('Transaction ID') }}:</span>
                                <span class="detail-value">{{ $payment->transaction_id }}</span>
                            </li>
                            <li>
                                <span class="detail-label">{{ __('Date') }}:</span>
                                <span class="detail-value">{{ $payment->payment_date->format('d/m/Y H:i') }}</span>
                            </li>
                            <li>
                                <span class="detail-label">{{ __('Montant') }}:</span>
                                <span class="detail-value">{{ number_format($payment->amount, 2, ',', ' ') }} €</span>
                            </li>
                            <li>
                                <span class="detail-label">{{ __('Méthode') }}:</span>
                                <span class="detail-value">
                                    @if($payment->payment_method == 'credit_card')
                                        <i class="fas fa-credit-card"></i> {{ __('Carte de crédit') }}
                                    @elseif($payment->payment_method == 'bank_transfer')
                                        <i class="fas fa-university"></i> {{ __('Virement bancaire') }}
                                    @elseif($payment->payment_method == 'paypal')
                                        <i class="fab fa-paypal"></i> {{ __('PayPal') }}
                                    @else
                                        {{ $payment->payment_method }}
                                    @endif
                                </span>
                            </li>
                            <li>
                                <span class="detail-label">{{ __('Statut') }}:</span>
                                <span class="detail-value status-completed">{{ __('Complété') }}</span>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="property-summary">
                        <h4>{{ __('Détails de la propriété') }}</h4>
                        <div class="property-card">
                            <div class="property-image">
                                <img src="{{ asset(!empty($payment->property->property_thumbnail) ? $payment->property->property_thumbnail : 'upload/no_image.jpg') }}" alt="{{ $payment->property->property_name }}">
                            </div>
                            <div class="property-info">
                                <h5>{{ $payment->property->property_name }}</h5>
                                <p><i class="fas fa-map-marker-alt"></i> {{ $payment->property->address }}</p>
                                <div class="property-meta">
                                    <span><i class="fas fa-bed"></i> {{ $payment->property->bedrooms }} {{ __('Chambres') }}</span>
                                    <span><i class="fas fa-bath"></i> {{ $payment->property->bathrooms }} {{ __('SdB') }}</span>
                                    <span><i class="fas fa-ruler-combined"></i> {{ $payment->property->property_size }} m²</span>
                                </div>
                                <div class="property-price">
                                    <span>{{ number_format($payment->property->lowest_price, 0, ',', ' ') }} €</span>
                                    <span class="property-status">{{ $payment->property->property_status == 'rent' ? __('À louer') : __('À vendre') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @if($payment->paymentPlan)
                    <div class="plan-summary">
                        <h4>{{ __('Plan de paiement') }}</h4>
                        <div class="plan-card">
                            <h5>{{ $payment->paymentPlan->name }}</h5>
                            <p>{{ $payment->paymentPlan->description }}</p>
                            <div class="plan-details">
                                <span class="plan-price">{{ number_format($payment->paymentPlan->price, 2, ',', ' ') }} €</span>
                                <span class="plan-duration">{{ $payment->paymentPlan->duration_value }} {{ __($payment->paymentPlan->duration) }}</span>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <div class="next-steps">
                        <h4>{{ __('Prochaines étapes') }}</h4>
                        <div class="steps-container">
                            <div class="step-item">
                                <div class="step-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="step-content">
                                    <h5>{{ __('Email de confirmation') }}</h5>
                                    <p>{{ __('Vous recevrez un email détaillant votre transaction.') }}</p>
                                </div>
                            </div>
                            <div class="step-item">
                                <div class="step-icon">
                                    <i class="fas fa-phone-alt"></i>
                                </div>
                                <div class="step-content">
                                    <h5>{{ __('Contact de l\'agent') }}</h5>
                                    <p>{{ __('L\'agent immobilier vous contactera prochainement.') }}</p>
                                </div>
                            </div>
                            <div class="step-item">
                                <div class="step-icon">
                                    <i class="fas fa-file-contract"></i>
                                </div>
                                <div class="step-content">
                                    <h5>{{ __('Documents') }}</h5>
                                    <p>{{ __('Préparez vos documents pour la prochaine étape.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="action-buttons">
                        <a href="{{ route('payment.history') }}" class="theme-btn btn-one">{{ __('Voir mes paiements') }}</a>
                        <a href="{{ route('property.details', [$payment->property->id, Str::slug($payment->property->property_name)]) }}" class="theme-btn btn-two">{{ __('Retour à la propriété') }}</a>
                        <a href="{{ route('homepage') }}" class="theme-btn btn-three">{{ __('Retour à l\'accueil') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- success-section end -->

@endsection

@push('styles')
<style>
    .success-content {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        padding: 40px;
    }
    
    .success-icon {
        font-size: 80px;
        color: #2dbe6c;
        margin-bottom: 20px;
    }
    
    .success-content h2 {
        margin-bottom: 15px;
        color: #2dbe6c;
    }
    
    .success-content p {
        font-size: 16px;
        margin-bottom: 30px;
    }
    
    .transaction-details, .property-summary, .plan-summary, .next-steps {
        margin-top: 40px;
        padding-top: 30px;
        border-top: 1px solid #e5e5e5;
    }
    
    .transaction-details h4, .property-summary h4, .plan-summary h4, .next-steps h4 {
        margin-bottom: 20px;
        font-size: 20px;
    }
    
    .transaction-details ul {
        list-style: none;
        padding: 0;
        margin: 0;
        text-align: left;
        background-color: #f8f8f8;
        border-radius: 5px;
        padding: 20px;
    }
    
    .transaction-details ul li {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #e5e5e5;
    }
    
    .transaction-details ul li:last-child {
        border-bottom: none;
    }
    
    .detail-label {
        font-weight: 600;
        color: #333;
    }
    
    .status-completed {
        color: #2dbe6c;
        font-weight: 600;
    }
    
    .property-card {
        display: flex;
        background-color: #f8f8f8;
        border-radius: 5px;
        overflow: hidden;
        text-align: left;
    }
    
    .property-image {
        width: 150px;
        height: 150px;
        overflow: hidden;
    }
    
    .property-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .property-info {
        flex: 1;
        padding: 15px;
    }
    
    .property-info h5 {
        margin: 0 0 5px;
        font-size: 18px;
    }
    
    .property-info p {
        margin: 0 0 10px;
        font-size: 14px;
        color: #777;
    }
    
    .property-meta {
        display: flex;
        gap: 15px;
        margin-bottom: 10px;
    }
    
    .property-meta span {
        font-size: 14px;
        color: #555;
    }
    
    .property-meta span i {
        margin-right: 5px;
        color: #2dbe6c;
    }
    
    .property-price {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .property-price span:first-child {
        font-size: 18px;
        font-weight: 600;
        color: #2dbe6c;
    }
    
    .property-status {
        background-color: #2dbe6c;
        color: white;
        padding: 3px 10px;
        border-radius: 3px;
        font-size: 12px;
    }
    
    .plan-card {
        background-color: #f8f8f8;
        border-radius: 5px;
        padding: 20px;
        text-align: left;
    }
    
    .plan-card h5 {
        margin: 0 0 10px;
        font-size: 18px;
    }
    
    .plan-card p {
        margin: 0 0 15px;
        font-size: 14px;
        color: #666;
    }
    
    .plan-details {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .plan-price {
        font-size: 18px;
        font-weight: 600;
        color: #2dbe6c;
    }
    
    .plan-duration {
        color: #777;
    }
    
    .steps-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-top: 20px;
    }
    
    .step-item {
        flex: 1;
        min-width: 200px;
        background-color: #f8f8f8;
        border-radius: 5px;
        padding: 20px;
        text-align: center;
    }
    
    .step-icon {
        font-size: 30px;
        color: #2dbe6c;
        margin-bottom: 15px;
    }
    
    .step-content h5 {
        margin: 0 0 10px;
        font-size: 16px;
    }
    
    .step-content p {
        margin: 0;
        font-size: 14px;
        color: #666;
    }
    
    .action-buttons {
        margin-top: 40px;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 15px;
    }
    
    @media (max-width: 767px) {
        .property-card {
            flex-direction: column;
        }
        
        .property-image {
            width: 100%;
            height: 200px;
        }
        
        .steps-container {
            flex-direction: column;
        }
    }
</style>
@endpush
