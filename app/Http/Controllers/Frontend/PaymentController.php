<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Payment;
use App\Models\PaymentPlan;
use App\Models\User;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    /**
     * Affiche la page de paiement pour une propriété spécifique
     */
    public function checkout($id)
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('message', 'Veuillez vous connecter pour effectuer un paiement')
                ->with('alert-type', 'error');
        }

        // Récupérer la propriété
        $property = Property::with(['type', 'user'])->findOrFail($id);
        
        // Récupérer les plans de paiement disponibles
        $paymentPlans = PaymentPlan::where('status', 1)->get();
        
        return view('frontend.payment.checkout', compact('property', 'paymentPlans'));
    }
    
    /**
     * Traite la demande de paiement
     */
    public function processPayment(Request $request)
    {
        // Valider les données du formulaire
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'payment_plan_id' => 'required|exists:payment_plans,id',
            'payment_method' => 'required|in:credit_card,bank_transfer,paypal',
            'amount' => 'required|numeric|min:1',
            'card_number' => 'required_if:payment_method,credit_card',
            'card_holder' => 'required_if:payment_method,credit_card',
            'expiry_date' => 'required_if:payment_method,credit_card',
            'cvv' => 'required_if:payment_method,credit_card',
        ]);
        
        try {
            DB::beginTransaction();
            
            // Simuler le traitement du paiement
            // Dans un environnement de production, vous intégreriez ici un service de paiement réel
            $paymentSuccessful = true; // Simuler un paiement réussi
            $transactionId = 'TRX-' . strtoupper(Str::random(10));
            
            if ($paymentSuccessful) {
                // Créer un enregistrement de paiement
                $payment = new Payment();
                $payment->user_id = Auth::id();
                $payment->property_id = $request->property_id;
                $payment->payment_plan_id = $request->payment_plan_id;
                $payment->transaction_id = $transactionId;
                $payment->amount = $request->amount;
                $payment->payment_method = $request->payment_method;
                $payment->status = 'completed';
                $payment->payment_date = Carbon::now();
                $payment->save();
                
                // Créer un rendez-vous automatiquement si demandé
                if ($request->has('schedule_appointment') && $request->schedule_appointment) {
                    $appointment = new Appointment();
                    $appointment->user_id = Auth::id();
                    $appointment->property_id = $request->property_id;
                    $appointment->agent_id = Property::find($request->property_id)->agent_id;
                    $appointment->appointment_date = $request->appointment_date ?? Carbon::now()->addDays(3)->format('Y-m-d');
                    $appointment->appointment_time = $request->appointment_time ?? '10:00';
                    $appointment->message = 'Rendez-vous automatique suite à un paiement';
                    $appointment->status = 'pending';
                    $appointment->save();
                }
                
                DB::commit();
                
                return redirect()->route('payment.success', ['transaction_id' => $transactionId])
                    ->with('message', 'Paiement effectué avec succès')
                    ->with('alert-type', 'success');
            } else {
                DB::rollBack();
                
                return redirect()->route('payment.failed')
                    ->with('message', 'Le paiement a échoué. Veuillez réessayer.')
                    ->with('alert-type', 'error');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('message', 'Une erreur est survenue lors du traitement du paiement: ' . $e->getMessage())
                ->with('alert-type', 'error');
        }
    }
    
    /**
     * Affiche la page de succès de paiement
     */
    public function success(Request $request)
    {
        $transactionId = $request->transaction_id;
        $payment = Payment::where('transaction_id', $transactionId)
            ->with(['property', 'user', 'paymentPlan'])
            ->firstOrFail();
        
        return view('frontend.payment.success', compact('payment'));
    }
    
    /**
     * Affiche la page d'échec de paiement
     */
    public function failed()
    {
        return view('frontend.payment.failed');
    }
    
    /**
     * Affiche l'historique des paiements de l'utilisateur
     */
    public function history()
    {
        $payments = Payment::where('user_id', Auth::id())
            ->with(['property', 'paymentPlan'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('frontend.payment.history', compact('payments'));
    }
}
