@extends('frontend.frontend_dashboard')
@section('content')

<!-- page-title -->
<section class="page-title centred">
    <div class="container">
        <div class="content-box">
            <h1>{{ __('Calculatrice de prêt immobilier') }}</h1>
            <ul class="bread-crumb clearfix">
                <li><a href="{{ route('homepage') }}">{{ __('Accueil') }}</a></li>
                <li>{{ __('Calculatrice de prêt') }}</li>
            </ul>
        </div>
    </div>
</section>
<!-- page-title end -->

<!-- mortgage-calculator-section -->
<section class="mortgage-calculator-section sec-pad">
    <div class="container">
        <div class="sec-title centred">
            <h5>{{ __('Calculatrice') }}</h5>
            <h2>{{ __('Estimez vos mensualités de prêt immobilier') }}</h2>
            <p>{{ __('Utilisez notre calculatrice pour estimer vos mensualités et planifier votre budget') }}</p>
        </div>
        <div class="row clearfix">
            <div class="col-lg-8 col-md-12 col-sm-12 offset-lg-2">
                <div class="calculator-content">
                    <div class="calculator-form">
                        <div class="form-group">
                            <label>{{ __('Prix de la propriété (€)') }}</label>
                            <input type="number" id="property-price" class="form-control" value="250000">
                        </div>
                        <div class="form-group">
                            <label>{{ __('Apport personnel (€)') }}</label>
                            <input type="number" id="down-payment" class="form-control" value="50000">
                        </div>
                        <div class="form-group">
                            <label>{{ __('Taux d\'intérêt annuel (%)') }}</label>
                            <input type="number" id="interest-rate" class="form-control" value="2.5" step="0.1">
                        </div>
                        <div class="form-group">
                            <label>{{ __('Durée du prêt (années)') }}</label>
                            <input type="number" id="loan-term" class="form-control" value="25">
                        </div>
                        <div class="form-group">
                            <label>{{ __('Frais de notaire estimés (%)') }}</label>
                            <input type="number" id="notary-fees" class="form-control" value="7" step="0.1">
                        </div>
                        <div class="btn-box">
                            <button type="button" id="calculate-btn" class="theme-btn btn-one">{{ __('Calculer') }}</button>
                        </div>
                    </div>
                    <div class="result-box mt-5" style="display: none;">
                        <h3 class="mb-4">{{ __('Résultats du calcul') }}</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-box mb-4">
                                    <h5>{{ __('Montant du prêt') }}</h5>
                                    <p id="loan-amount">€ 0</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box mb-4">
                                    <h5>{{ __('Mensualité estimée') }}</h5>
                                    <p id="monthly-payment">€ 0</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box mb-4">
                                    <h5>{{ __('Frais de notaire estimés') }}</h5>
                                    <p id="notary-fees-amount">€ 0</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box mb-4">
                                    <h5>{{ __('Coût total du crédit') }}</h5>
                                    <p id="total-cost">€ 0</p>
                                </div>
                            </div>
                        </div>
                        <div class="amortization-table-container mt-4">
                            <h4>{{ __('Tableau d\'amortissement') }}</h4>
                            <p>{{ __('Les premières années du remboursement') }}</p>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Année') }}</th>
                                            <th>{{ __('Paiement annuel') }}</th>
                                            <th>{{ __('Principal') }}</th>
                                            <th>{{ __('Intérêts') }}</th>
                                            <th>{{ __('Capital restant') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody id="amortization-table">
                                        <!-- Le tableau sera rempli par JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- mortgage-calculator-section end -->

<!-- info-section -->
<section class="info-section bg-color-1 sec-pad">
    <div class="container">
        <div class="row clearfix">
            <div class="col-lg-4 col-md-6 col-sm-12 info-block">
                <div class="info-block-one">
                    <div class="inner-box">
                        <div class="icon-box"><i class="icon-19"></i></div>
                        <h4>{{ __('Comprendre votre prêt') }}</h4>
                        <p>{{ __('Le montant que vous pouvez emprunter dépend de vos revenus, de votre apport personnel et de votre capacité de remboursement. En général, les mensualités ne devraient pas dépasser 33% de vos revenus nets.') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 info-block">
                <div class="info-block-one">
                    <div class="inner-box">
                        <div class="icon-box"><i class="icon-20"></i></div>
                        <h4>{{ __('Taux fixe vs variable') }}</h4>
                        <p>{{ __('Un taux fixe reste le même pendant toute la durée du prêt, offrant une stabilité dans vos paiements. Un taux variable peut changer en fonction des conditions du marché, ce qui peut être avantageux si les taux baissent.') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 info-block">
                <div class="info-block-one">
                    <div class="inner-box">
                        <div class="icon-box"><i class="icon-21"></i></div>
                        <h4>{{ __('Besoin de conseils ?') }}</h4>
                        <p>{{ __('Nos conseillers immobiliers sont disponibles pour vous aider à comprendre vos options de financement et à trouver la meilleure solution pour votre projet immobilier.') }}</p>
                        <div class="btn-box mt-4">
                            <a href="{{ route('contact') }}" class="theme-btn btn-one">{{ __('Contactez-nous') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- info-section end -->

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Fonction pour formater les nombres en devise
        function formatCurrency(value) {
            return new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(value);
        }
        
        // Fonction pour calculer la mensualité du prêt
        function calculateMonthlyPayment(loanAmount, annualInterestRate, loanTermYears) {
            const monthlyInterestRate = annualInterestRate / 100 / 12;
            const numberOfPayments = loanTermYears * 12;
            
            if (monthlyInterestRate === 0) {
                return loanAmount / numberOfPayments;
            }
            
            return loanAmount * monthlyInterestRate * Math.pow(1 + monthlyInterestRate, numberOfPayments) / (Math.pow(1 + monthlyInterestRate, numberOfPayments) - 1);
        }
        
        // Fonction pour générer le tableau d'amortissement
        function generateAmortizationTable(loanAmount, annualInterestRate, loanTermYears) {
            const monthlyInterestRate = annualInterestRate / 100 / 12;
            const monthlyPayment = calculateMonthlyPayment(loanAmount, annualInterestRate, loanTermYears);
            const numberOfPayments = loanTermYears * 12;
            
            let remainingBalance = loanAmount;
            let amortizationTable = '';
            
            // Afficher seulement les 5 premières années pour ne pas surcharger la page
            const yearsToShow = Math.min(5, loanTermYears);
            
            for (let year = 1; year <= yearsToShow; year++) {
                let yearlyPrincipal = 0;
                let yearlyInterest = 0;
                
                for (let month = 1; month <= 12; month++) {
                    const interestPayment = remainingBalance * monthlyInterestRate;
                    const principalPayment = monthlyPayment - interestPayment;
                    
                    yearlyPrincipal += principalPayment;
                    yearlyInterest += interestPayment;
                    remainingBalance -= principalPayment;
                }
                
                amortizationTable += `
                    <tr>
                        <td>${year}</td>
                        <td>${formatCurrency(monthlyPayment * 12)}</td>
                        <td>${formatCurrency(yearlyPrincipal)}</td>
                        <td>${formatCurrency(yearlyInterest)}</td>
                        <td>${formatCurrency(Math.max(0, remainingBalance))}</td>
                    </tr>
                `;
            }
            
            return amortizationTable;
        }
        
        // Fonction principale de calcul
        $('#calculate-btn').on('click', function() {
            const propertyPrice = parseFloat($('#property-price').val()) || 0;
            const downPayment = parseFloat($('#down-payment').val()) || 0;
            const interestRate = parseFloat($('#interest-rate').val()) || 0;
            const loanTerm = parseFloat($('#loan-term').val()) || 0;
            const notaryFeesPercent = parseFloat($('#notary-fees').val()) || 0;
            
            // Calculer le montant du prêt
            const loanAmount = propertyPrice - downPayment;
            
            // Calculer la mensualité
            const monthlyPayment = calculateMonthlyPayment(loanAmount, interestRate, loanTerm);
            
            // Calculer les frais de notaire
            const notaryFeesAmount = propertyPrice * (notaryFeesPercent / 100);
            
            // Calculer le coût total du crédit
            const totalCost = (monthlyPayment * loanTerm * 12) + downPayment + notaryFeesAmount;
            
            // Afficher les résultats
            $('#loan-amount').text(formatCurrency(loanAmount));
            $('#monthly-payment').text(formatCurrency(monthlyPayment));
            $('#notary-fees-amount').text(formatCurrency(notaryFeesAmount));
            $('#total-cost').text(formatCurrency(totalCost));
            
            // Générer et afficher le tableau d'amortissement
            $('#amortization-table').html(generateAmortizationTable(loanAmount, interestRate, loanTerm));
            
            // Afficher la boîte de résultats
            $('.result-box').show();
        });
        
        // Déclencher le calcul au chargement de la page
        $('#calculate-btn').trigger('click');
    });
</script>
@endsection
