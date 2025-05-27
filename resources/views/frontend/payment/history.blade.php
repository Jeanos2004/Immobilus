@extends('frontend.frontend_dashboard')
@section('content')

<!-- page-title -->
<section class="page-title centred">
    <div class="container">
        <div class="content-box">
            <h1>{{ __('Historique des paiements') }}</h1>
            <ul class="bread-crumb clearfix">
                <li><a href="{{ route('homepage') }}">{{ __('Accueil') }}</a></li>
                <li><a href="{{ route('dashboard') }}">{{ __('Tableau de bord') }}</a></li>
                <li>{{ __('Paiements') }}</li>
            </ul>
        </div>
    </div>
</section>
<!-- page-title end -->

<!-- history-section -->
<section class="history-section sec-pad">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-12">
                @include('frontend.dashboard.dashboard_sidebar')
            </div>
            
            <div class="col-lg-8 col-md-12">
                <div class="payments-history-content">
                    <div class="title-box">
                        <h3>{{ __('Mes paiements') }}</h3>
                    </div>
                    
                    @if($payments->count() > 0)
                        <div class="payments-table-wrap">
                            <table class="payments-table">
                                <thead>
                                    <tr>
                                        <th>{{ __('Date') }}</th>
                                        <th>{{ __('Propriété') }}</th>
                                        <th>{{ __('Montant') }}</th>
                                        <th>{{ __('Méthode') }}</th>
                                        <th>{{ __('Statut') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($payments as $payment)
                                    <tr>
                                        <td>{{ $payment->payment_date->format('d/m/Y') }}</td>
                                        <td>
                                            @if($payment->property)
                                                <a href="{{ route('property.details', [$payment->property->id, Str::slug($payment->property->property_name)]) }}" class="property-link">
                                                    {{ Str::limit($payment->property->property_name, 25) }}
                                                </a>
                                            @else
                                                {{ __('N/A') }}
                                            @endif
                                        </td>
                                        <td>{{ number_format($payment->amount, 2, ',', ' ') }} €</td>
                                        <td>
                                            @if($payment->payment_method == 'credit_card')
                                                <span class="payment-method"><i class="fas fa-credit-card"></i> {{ __('Carte') }}</span>
                                            @elseif($payment->payment_method == 'bank_transfer')
                                                <span class="payment-method"><i class="fas fa-university"></i> {{ __('Virement') }}</span>
                                            @elseif($payment->payment_method == 'paypal')
                                                <span class="payment-method"><i class="fab fa-paypal"></i> {{ __('PayPal') }}</span>
                                            @else
                                                <span class="payment-method">{{ $payment->payment_method }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($payment->status == 'completed')
                                                <span class="status-badge status-completed">{{ __('Complété') }}</span>
                                            @elseif($payment->status == 'pending')
                                                <span class="status-badge status-pending">{{ __('En attente') }}</span>
                                            @elseif($payment->status == 'failed')
                                                <span class="status-badge status-failed">{{ __('Échoué') }}</span>
                                            @elseif($payment->status == 'refunded')
                                                <span class="status-badge status-refunded">{{ __('Remboursé') }}</span>
                                            @else
                                                <span class="status-badge">{{ $payment->status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="actions-dropdown">
                                                <button class="dropdown-toggle">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a href="{{ route('payment.success', ['transaction_id' => $payment->transaction_id]) }}" class="dropdown-item">
                                                        <i class="fas fa-eye"></i> {{ __('Détails') }}
                                                    </a>
                                                    <a href="#" class="dropdown-item" onclick="window.print()">
                                                        <i class="fas fa-print"></i> {{ __('Imprimer') }}
                                                    </a>
                                                    @if($payment->status == 'completed' && $payment->created_at->diffInDays(now()) < 14)
                                                    <a href="#" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#refundModal{{ $payment->id }}">
                                                        <i class="fas fa-undo-alt"></i> {{ __('Demander remboursement') }}
                                                    </a>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <!-- Modal de demande de remboursement -->
                                            <div class="modal fade" id="refundModal{{ $payment->id }}" tabindex="-1" aria-labelledby="refundModalLabel{{ $payment->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="refundModalLabel{{ $payment->id }}">{{ __('Demande de remboursement') }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>{{ __('Êtes-vous sûr de vouloir demander un remboursement pour ce paiement ?') }}</p>
                                                            <p>{{ __('Transaction') }}: {{ $payment->transaction_id }}</p>
                                                            <p>{{ __('Montant') }}: {{ number_format($payment->amount, 2, ',', ' ') }} €</p>
                                                            <p class="text-muted">{{ __('Note: Les remboursements sont traités dans un délai de 5 à 10 jours ouvrables.') }}</p>
                                                            
                                                            <form action="{{ route('payment.refund.request') }}" method="POST" class="mt-3">
                                                                @csrf
                                                                <input type="hidden" name="payment_id" value="{{ $payment->id }}">
                                                                <div class="form-group">
                                                                    <label for="refund_reason{{ $payment->id }}">{{ __('Motif du remboursement') }}</label>
                                                                    <select name="refund_reason" id="refund_reason{{ $payment->id }}" class="form-control" required>
                                                                        <option value="">{{ __('Sélectionnez un motif') }}</option>
                                                                        <option value="change_of_mind">{{ __('Changement d\'avis') }}</option>
                                                                        <option value="property_unavailable">{{ __('Propriété non disponible') }}</option>
                                                                        <option value="duplicate_payment">{{ __('Paiement en double') }}</option>
                                                                        <option value="other">{{ __('Autre raison') }}</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group mt-3">
                                                                    <label for="refund_comments{{ $payment->id }}">{{ __('Commentaires supplémentaires') }}</label>
                                                                    <textarea name="refund_comments" id="refund_comments{{ $payment->id }}" class="form-control" rows="3"></textarea>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Annuler') }}</button>
                                                            <button type="button" class="btn btn-danger" onclick="document.getElementById('refundForm{{ $payment->id }}').submit()">{{ __('Demander remboursement') }}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="pagination-wrapper">
                            {{ $payments->links() }}
                        </div>
                    @else
                        <div class="empty-payments">
                            <div class="empty-icon">
                                <i class="fas fa-file-invoice-dollar"></i>
                            </div>
                            <h4>{{ __('Aucun paiement trouvé') }}</h4>
                            <p>{{ __('Vous n\'avez pas encore effectué de paiement sur notre plateforme.') }}</p>
                            <a href="{{ route('property.list') }}" class="theme-btn btn-one">{{ __('Explorer les propriétés') }}</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
<!-- history-section end -->

@endsection

@push('styles')
<style>
    .payments-history-content {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        padding: 30px;
    }
    
    .title-box {
        margin-bottom: 25px;
        border-bottom: 1px solid #e5e5e5;
        padding-bottom: 15px;
    }
    
    .title-box h3 {
        font-size: 22px;
        margin: 0;
    }
    
    .payments-table-wrap {
        overflow-x: auto;
    }
    
    .payments-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .payments-table th, .payments-table td {
        padding: 15px;
        text-align: left;
        border-bottom: 1px solid #e5e5e5;
    }
    
    .payments-table th {
        background-color: #f8f8f8;
        font-weight: 600;
        color: #333;
    }
    
    .payments-table tr:hover {
        background-color: #f9f9f9;
    }
    
    .property-link {
        color: #2dbe6c;
        text-decoration: none;
        font-weight: 500;
    }
    
    .property-link:hover {
        text-decoration: underline;
    }
    
    .payment-method {
        display: flex;
        align-items: center;
        gap: 5px;
    }
    
    .status-badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 15px;
        font-size: 12px;
        font-weight: 500;
    }
    
    .status-completed {
        background-color: rgba(45, 190, 108, 0.1);
        color: #2dbe6c;
    }
    
    .status-pending {
        background-color: rgba(255, 193, 7, 0.1);
        color: #ffc107;
    }
    
    .status-failed {
        background-color: rgba(255, 90, 95, 0.1);
        color: #ff5a5f;
    }
    
    .status-refunded {
        background-color: rgba(108, 117, 125, 0.1);
        color: #6c757d;
    }
    
    .actions-dropdown {
        position: relative;
    }
    
    .dropdown-toggle {
        background: none;
        border: none;
        cursor: pointer;
        padding: 5px;
        color: #555;
    }
    
    .dropdown-menu {
        position: absolute;
        right: 0;
        top: 100%;
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        padding: 5px 0;
        min-width: 150px;
        z-index: 10;
        display: none;
    }
    
    .actions-dropdown:hover .dropdown-menu {
        display: block;
    }
    
    .dropdown-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 15px;
        color: #333;
        text-decoration: none;
        font-size: 14px;
    }
    
    .dropdown-item:hover {
        background-color: #f8f8f8;
    }
    
    .dropdown-item.text-danger {
        color: #ff5a5f;
    }
    
    .empty-payments {
        text-align: center;
        padding: 50px 0;
    }
    
    .empty-icon {
        font-size: 60px;
        color: #e5e5e5;
        margin-bottom: 20px;
    }
    
    .empty-payments h4 {
        margin-bottom: 10px;
        font-size: 20px;
    }
    
    .empty-payments p {
        margin-bottom: 25px;
        color: #777;
    }
    
    .pagination-wrapper {
        margin-top: 30px;
        display: flex;
        justify-content: center;
    }
    
    @media (max-width: 767px) {
        .payments-table th, .payments-table td {
            padding: 10px;
        }
        
        .payments-table th:nth-child(4), .payments-table td:nth-child(4),
        .payments-table th:nth-child(6), .payments-table td:nth-child(6) {
            display: none;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Fermer le dropdown lorsqu'on clique ailleurs
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.actions-dropdown').length) {
                $('.dropdown-menu').hide();
            }
        });
        
        // Ouvrir/fermer le dropdown au clic
        $('.dropdown-toggle').on('click', function(e) {
            e.stopPropagation();
            $(this).next('.dropdown-menu').toggle();
        });
    });
</script>
@endpush
