@extends('frontend.frontend_dashboard')
@section('content')

<!-- page-title -->
<section class="page-title centred">
    <div class="container">
        <div class="content-box">
            <h1>{{ __('Paiement') }}</h1>
            <ul class="bread-crumb clearfix">
                <li><a href="{{ route('homepage') }}">{{ __('Accueil') }}</a></li>
                <li><a href="{{ route('property.details', [$property->id, Str::slug($property->property_name)]) }}">{{ $property->property_name }}</a></li>
                <li>{{ __('Paiement') }}</li>
            </ul>
        </div>
    </div>
</section>
<!-- page-title end -->

<!-- checkout-section -->
<section class="checkout-section sec-pad">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12 col-sm-12">
                <div class="checkout-form-wrap">
                    <div class="default-form">
                        <form action="{{ route('payment.process') }}" method="POST" id="payment-form">
                            @csrf
                            <input type="hidden" name="property_id" value="{{ $property->id }}">
                            
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 column">
                                    <div class="section-title">
                                        <h3>{{ __('Informations de paiement') }}</h3>
                                    </div>
                                </div>
                                
                                <!-- Plan de paiement -->
                                <div class="col-lg-12 col-md-12 col-sm-12 column">
                                    <div class="field-input">
                                        <label>{{ __('Choisir un plan de paiement') }} <span class="required">*</span></label>
                                        <div class="payment-plans-container">
                                            @foreach($paymentPlans as $plan)
                                                <div class="payment-plan-item">
                                                    <input type="radio" name="payment_plan_id" id="plan-{{ $plan->id }}" value="{{ $plan->id }}" data-price="{{ $plan->price }}" {{ $loop->first ? 'checked' : '' }}>
                                                    <label for="plan-{{ $plan->id }}" class="payment-plan-label">
                                                        <span class="plan-name">{{ $plan->name }}</span>
                                                        <span class="plan-price">{{ number_format($plan->price, 2, ',', ' ') }} €</span>
                                                        <span class="plan-duration">{{ $plan->duration_value }} {{ __($plan->duration) }}</span>
                                                        @if($plan->featured)
                                                            <span class="plan-badge">{{ __('Recommandé') }}</span>
                                                        @endif
                                                    </label>
                                                    <p class="plan-description">{{ $plan->description }}</p>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Montant -->
                                <div class="col-lg-12 col-md-12 col-sm-12 column">
                                    <div class="field-input">
                                        <label>{{ __('Montant') }} <span class="required">*</span></label>
                                        <input type="text" name="amount" id="amount" value="{{ $paymentPlans->first()->price ?? 0 }}" readonly>
                                    </div>
                                </div>
                                
                                <!-- Méthode de paiement -->
                                <div class="col-lg-12 col-md-12 col-sm-12 column">
                                    <div class="field-input">
                                        <label>{{ __('Méthode de paiement') }} <span class="required">*</span></label>
                                        <div class="payment-methods">
                                            <div class="payment-method-item">
                                                <input type="radio" name="payment_method" id="method-credit-card" value="credit_card" checked>
                                                <label for="method-credit-card">
                                                    <i class="fas fa-credit-card"></i> {{ __('Carte de crédit') }}
                                                </label>
                                            </div>
                                            <div class="payment-method-item">
                                                <input type="radio" name="payment_method" id="method-bank-transfer" value="bank_transfer">
                                                <label for="method-bank-transfer">
                                                    <i class="fas fa-university"></i> {{ __('Virement bancaire') }}
                                                </label>
                                            </div>
                                            <div class="payment-method-item">
                                                <input type="radio" name="payment_method" id="method-paypal" value="paypal">
                                                <label for="method-paypal">
                                                    <i class="fab fa-paypal"></i> {{ __('PayPal') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Détails de la carte de crédit (affiché conditionnellement) -->
                                <div class="col-lg-12 col-md-12 col-sm-12 column" id="credit-card-details">
                                    <div class="credit-card-form">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 column">
                                                <div class="field-input">
                                                    <label>{{ __('Numéro de carte') }} <span class="required">*</span></label>
                                                    <input type="text" name="card_number" placeholder="1234 5678 9012 3456" maxlength="19">
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 column">
                                                <div class="field-input">
                                                    <label>{{ __('Titulaire de la carte') }} <span class="required">*</span></label>
                                                    <input type="text" name="card_holder" placeholder="John Doe">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 column">
                                                <div class="field-input">
                                                    <label>{{ __('Date d\'expiration') }} <span class="required">*</span></label>
                                                    <input type="text" name="expiry_date" placeholder="MM/YY" maxlength="5">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 column">
                                                <div class="field-input">
                                                    <label>{{ __('CVV') }} <span class="required">*</span></label>
                                                    <input type="text" name="cvv" placeholder="123" maxlength="4">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Détails du virement bancaire (caché par défaut) -->
                                <div class="col-lg-12 col-md-12 col-sm-12 column d-none" id="bank-transfer-details">
                                    <div class="bank-transfer-info">
                                        <h4>{{ __('Informations bancaires') }}</h4>
                                        <p>{{ __('Veuillez effectuer un virement bancaire avec les informations suivantes:') }}</p>
                                        <ul>
                                            <li><strong>{{ __('Banque') }}:</strong> Banque Immobilus</li>
                                            <li><strong>{{ __('IBAN') }}:</strong> FR76 1234 5678 9012 3456 7890 123</li>
                                            <li><strong>{{ __('BIC') }}:</strong> IMMOFR2X</li>
                                            <li><strong>{{ __('Référence') }}:</strong> IMMO-{{ $property->id }}-{{ Auth::id() }}</li>
                                        </ul>
                                        <p class="text-warning">{{ __('Votre réservation sera confirmée après réception du paiement.') }}</p>
                                    </div>
                                </div>
                                
                                <!-- Détails PayPal (caché par défaut) -->
                                <div class="col-lg-12 col-md-12 col-sm-12 column d-none" id="paypal-details">
                                    <div class="paypal-info">
                                        <p>{{ __('Vous serez redirigé vers PayPal pour finaliser votre paiement après avoir cliqué sur "Payer maintenant".') }}</p>
                                    </div>
                                </div>
                                
                                <!-- Option de rendez-vous -->
                                <div class="col-lg-12 col-md-12 col-sm-12 column mt-4">
                                    <div class="checkbox-field">
                                        <input type="checkbox" name="schedule_appointment" id="schedule_appointment" value="1">
                                        <label for="schedule_appointment">{{ __('Planifier un rendez-vous avec l\'agent') }}</label>
                                    </div>
                                </div>
                                
                                <!-- Détails du rendez-vous (caché par défaut) -->
                                <div class="col-lg-12 col-md-12 col-sm-12 column d-none" id="appointment-details">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12 column">
                                            <div class="field-input">
                                                <label>{{ __('Date du rendez-vous') }}</label>
                                                <input type="date" name="appointment_date" min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 column">
                                            <div class="field-input">
                                                <label>{{ __('Heure du rendez-vous') }}</label>
                                                <input type="time" name="appointment_time" min="09:00" max="18:00">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-lg-12 col-md-12 col-sm-12 column">
                                    <div class="field-input message-field">
                                        <label>{{ __('Notes supplémentaires') }}</label>
                                        <textarea name="notes" placeholder="{{ __('Informations complémentaires pour votre paiement ou rendez-vous...') }}"></textarea>
                                    </div>
                                </div>
                                
                                <div class="col-lg-12 col-md-12 col-sm-12 column">
                                    <div class="form-group message-btn">
                                        <button type="submit" class="theme-btn btn-one">{{ __('Payer maintenant') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Résumé de la commande -->
            <div class="col-lg-4 col-md-12 col-sm-12">
                <div class="order-summary">
                    <div class="summary-header">
                        <h3>{{ __('Résumé de la commande') }}</h3>
                    </div>
                    <div class="property-info">
                        <div class="image">
                            <img src="{{ asset(!empty($property->property_thumbnail) ? $property->property_thumbnail : 'upload/no_image.jpg') }}" alt="{{ $property->property_name }}">
                        </div>
                        <div class="title">
                            <h4>{{ $property->property_name }}</h4>
                            <p><i class="fas fa-map-marker-alt"></i> {{ $property->address }}</p>
                        </div>
                    </div>
                    <div class="summary-details">
                        <ul>
                            <li>{{ __('Type') }} <span>{{ $property->type->type_name ?? 'N/A' }}</span></li>
                            <li>{{ __('Statut') }} <span>{{ $property->property_status == 'rent' ? __('À louer') : __('À vendre') }}</span></li>
                            <li>{{ __('Prix') }} <span>{{ number_format($property->lowest_price, 0, ',', ' ') }} €</span></li>
                            <li>{{ __('Agent') }} <span>{{ $property->user->name ?? 'N/A' }}</span></li>
                        </ul>
                    </div>
                    <div class="total-amount">
                        <h4>{{ __('Total à payer') }}: <span id="total-amount">{{ number_format($paymentPlans->first()->price ?? 0, 2, ',', ' ') }} €</span></h4>
                    </div>
                </div>
                
                <div class="payment-security mt-4">
                    <div class="security-header">
                        <h4><i class="fas fa-shield-alt"></i> {{ __('Paiement sécurisé') }}</h4>
                    </div>
                    <div class="security-content">
                        <p>{{ __('Toutes les transactions sont sécurisées et cryptées. Vos informations de paiement ne sont jamais stockées.') }}</p>
                        <div class="payment-icons">
                            <i class="fab fa-cc-visa"></i>
                            <i class="fab fa-cc-mastercard"></i>
                            <i class="fab fa-cc-amex"></i>
                            <i class="fab fa-cc-paypal"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- checkout-section end -->

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Mettre à jour le montant lorsqu'un plan de paiement est sélectionné
        $('input[name="payment_plan_id"]').on('change', function() {
            const price = $(this).data('price');
            $('#amount').val(price);
            $('#total-amount').text(new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(price));
        });
        
        // Afficher/masquer les détails de paiement en fonction de la méthode choisie
        $('input[name="payment_method"]').on('change', function() {
            const method = $(this).val();
            
            // Masquer tous les détails
            $('#credit-card-details, #bank-transfer-details, #paypal-details').addClass('d-none');
            
            // Afficher les détails correspondants
            if (method === 'credit_card') {
                $('#credit-card-details').removeClass('d-none');
            } else if (method === 'bank_transfer') {
                $('#bank-transfer-details').removeClass('d-none');
            } else if (method === 'paypal') {
                $('#paypal-details').removeClass('d-none');
            }
        });
        
        // Afficher/masquer les détails du rendez-vous
        $('#schedule_appointment').on('change', function() {
            if ($(this).is(':checked')) {
                $('#appointment-details').removeClass('d-none');
            } else {
                $('#appointment-details').addClass('d-none');
            }
        });
        
        // Formater le numéro de carte
        $('input[name="card_number"]').on('input', function() {
            let value = $(this).val().replace(/\D/g, '');
            let formattedValue = '';
            
            for (let i = 0; i < value.length; i++) {
                if (i > 0 && i % 4 === 0) {
                    formattedValue += ' ';
                }
                formattedValue += value[i];
            }
            
            $(this).val(formattedValue);
        });
        
        // Formater la date d'expiration
        $('input[name="expiry_date"]').on('input', function() {
            let value = $(this).val().replace(/\D/g, '');
            let formattedValue = '';
            
            if (value.length > 0) {
                formattedValue = value.substring(0, 2);
                
                if (value.length > 2) {
                    formattedValue += '/' + value.substring(2, 4);
                }
            }
            
            $(this).val(formattedValue);
        });
        
        // Validation du formulaire
        $('#payment-form').on('submit', function(e) {
            const method = $('input[name="payment_method"]:checked').val();
            
            if (method === 'credit_card') {
                const cardNumber = $('input[name="card_number"]').val().replace(/\s/g, '');
                const cardHolder = $('input[name="card_holder"]').val();
                const expiryDate = $('input[name="expiry_date"]').val();
                const cvv = $('input[name="cvv"]').val();
                
                if (cardNumber.length < 16) {
                    alert('{{ __("Veuillez entrer un numéro de carte valide") }}');
                    e.preventDefault();
                    return false;
                }
                
                if (cardHolder.trim() === '') {
                    alert('{{ __("Veuillez entrer le nom du titulaire de la carte") }}');
                    e.preventDefault();
                    return false;
                }
                
                if (expiryDate.length < 5) {
                    alert('{{ __("Veuillez entrer une date d\'expiration valide") }}');
                    e.preventDefault();
                    return false;
                }
                
                if (cvv.length < 3) {
                    alert('{{ __("Veuillez entrer un code CVV valide") }}');
                    e.preventDefault();
                    return false;
                }
            }
        });
    });
</script>
@endpush

@push('styles')
<style>
    .payment-plans-container {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 20px;
    }
    
    .payment-plan-item {
        flex: 1;
        min-width: 200px;
        border: 1px solid #e5e5e5;
        border-radius: 5px;
        padding: 15px;
        position: relative;
        transition: all 0.3s ease;
    }
    
    .payment-plan-item:hover {
        border-color: #2dbe6c;
    }
    
    .payment-plan-item input[type="radio"] {
        position: absolute;
        opacity: 0;
    }
    
    .payment-plan-item input[type="radio"]:checked + .payment-plan-label {
        color: #2dbe6c;
    }
    
    .payment-plan-item input[type="radio"]:checked + .payment-plan-label::before {
        content: "\f058";
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        position: absolute;
        top: 10px;
        right: 10px;
        color: #2dbe6c;
    }
    
    .payment-plan-label {
        display: flex;
        flex-direction: column;
        cursor: pointer;
        font-weight: 600;
    }
    
    .plan-name {
        font-size: 18px;
        margin-bottom: 5px;
    }
    
    .plan-price {
        font-size: 22px;
        color: #2dbe6c;
        margin-bottom: 5px;
    }
    
    .plan-duration {
        font-size: 14px;
        color: #777;
    }
    
    .plan-badge {
        position: absolute;
        top: -10px;
        left: 50%;
        transform: translateX(-50%);
        background-color: #ff5a5f;
        color: white;
        padding: 3px 10px;
        border-radius: 15px;
        font-size: 12px;
    }
    
    .plan-description {
        margin-top: 10px;
        font-size: 14px;
        color: #666;
    }
    
    .payment-methods {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 20px;
    }
    
    .payment-method-item {
        flex: 1;
        min-width: 150px;
        border: 1px solid #e5e5e5;
        border-radius: 5px;
        padding: 15px;
        text-align: center;
        position: relative;
        transition: all 0.3s ease;
    }
    
    .payment-method-item:hover {
        border-color: #2dbe6c;
    }
    
    .payment-method-item input[type="radio"] {
        position: absolute;
        opacity: 0;
    }
    
    .payment-method-item input[type="radio"]:checked + label {
        color: #2dbe6c;
    }
    
    .payment-method-item input[type="radio"]:checked + label::before {
        content: "\f058";
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        position: absolute;
        top: 10px;
        right: 10px;
        color: #2dbe6c;
    }
    
    .payment-method-item label {
        display: block;
        cursor: pointer;
        font-weight: 600;
    }
    
    .payment-method-item label i {
        display: block;
        font-size: 24px;
        margin-bottom: 10px;
    }
    
    .credit-card-form {
        border: 1px solid #e5e5e5;
        border-radius: 5px;
        padding: 20px;
        margin-bottom: 20px;
    }
    
    .bank-transfer-info, .paypal-info {
        border: 1px solid #e5e5e5;
        border-radius: 5px;
        padding: 20px;
        margin-bottom: 20px;
    }
    
    .bank-transfer-info ul {
        list-style: none;
        padding: 0;
        margin: 15px 0;
    }
    
    .bank-transfer-info ul li {
        margin-bottom: 10px;
    }
    
    .order-summary {
        border: 1px solid #e5e5e5;
        border-radius: 5px;
        overflow: hidden;
    }
    
    .summary-header {
        background-color: #f8f8f8;
        padding: 15px;
        border-bottom: 1px solid #e5e5e5;
    }
    
    .summary-header h3 {
        margin: 0;
        font-size: 18px;
    }
    
    .property-info {
        padding: 15px;
        display: flex;
        align-items: center;
        border-bottom: 1px solid #e5e5e5;
    }
    
    .property-info .image {
        width: 80px;
        height: 80px;
        overflow: hidden;
        border-radius: 5px;
        margin-right: 15px;
    }
    
    .property-info .image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .property-info .title h4 {
        margin: 0 0 5px;
        font-size: 16px;
    }
    
    .property-info .title p {
        margin: 0;
        font-size: 14px;
        color: #777;
    }
    
    .summary-details {
        padding: 15px;
        border-bottom: 1px solid #e5e5e5;
    }
    
    .summary-details ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .summary-details ul li {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        font-size: 14px;
    }
    
    .total-amount {
        padding: 15px;
        background-color: #f8f8f8;
    }
    
    .total-amount h4 {
        margin: 0;
        font-size: 18px;
        display: flex;
        justify-content: space-between;
    }
    
    .payment-security {
        border: 1px solid #e5e5e5;
        border-radius: 5px;
        overflow: hidden;
    }
    
    .security-header {
        background-color: #f8f8f8;
        padding: 15px;
        border-bottom: 1px solid #e5e5e5;
    }
    
    .security-header h4 {
        margin: 0;
        font-size: 16px;
        display: flex;
        align-items: center;
    }
    
    .security-header h4 i {
        margin-right: 10px;
        color: #2dbe6c;
    }
    
    .security-content {
        padding: 15px;
    }
    
    .security-content p {
        margin: 0 0 15px;
        font-size: 14px;
    }
    
    .payment-icons {
        display: flex;
        gap: 10px;
    }
    
    .payment-icons i {
        font-size: 30px;
        color: #777;
    }
</style>
@endpush
