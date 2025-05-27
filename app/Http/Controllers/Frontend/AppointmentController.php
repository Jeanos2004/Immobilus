<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    /**
     * Affiche le formulaire de prise de rendez-vous pour une propriété
     * 
     * @param int $property_id ID de la propriété
     * @return \Illuminate\View\View
     */
    public function BookAppointment($property_id)
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            $notification = [
                'message' => 'Vous devez être connecté pour prendre un rendez-vous',
                'alert-type' => 'error'
            ];
            return redirect()->route('login')->with($notification);
        }
        
        // Récupérer la propriété et son agent
        $property = Property::with('agent')->findOrFail($property_id);
        
        return view('frontend.appointment.book_appointment', compact('property'));
    }
    
    /**
     * Enregistre un nouveau rendez-vous
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function StoreAppointment(Request $request)
    {
        // Validation des données
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'agent_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date|after:today',
            'message' => 'nullable|string|max:500'
        ]);
        
        // Création du rendez-vous
        $appointment = Appointment::create([
            'user_id' => Auth::id(),
            'agent_id' => $request->agent_id,
            'property_id' => $request->property_id,
            'appointment_date' => $request->appointment_date,
            'message' => $request->message,
            'status' => 'pending'
        ]);
        
        // Charger les relations pour les notifications
        $appointment->load(['user', 'agent', 'property']);
        
        // Envoyer une notification à l'agent
        try {
            // Créer une notification spécifique pour la nouvelle demande de rendez-vous
            $agent = User::find($request->agent_id);
            $agent->notify(new \App\Notifications\NewAppointmentRequest($appointment));
        } catch (\Exception $e) {
            // Log l'erreur mais continuer l'exécution
            \Log::error('Erreur lors de l\'envoi de la notification: ' . $e->getMessage());
        }
        
        $notification = [
            'message' => 'Votre demande de rendez-vous a été envoyée avec succès',
            'alert-type' => 'success'
        ];
        
        return redirect()->back()->with($notification);
    }
    
    /**
     * Affiche la liste des rendez-vous de l'utilisateur connecté
     * 
     * @return \Illuminate\View\View
     */
    public function UserAppointments()
    {
        $appointments = Appointment::with(['property', 'agent'])
                                ->where('user_id', Auth::id())
                                ->latest()
                                ->get();
        
        return view('frontend.appointment.user_appointments', compact('appointments'));
    }
    
    /**
     * Annule un rendez-vous de l'utilisateur
     * 
     * @param int $id ID du rendez-vous
     * @return \Illuminate\Http\RedirectResponse
     */
    public function CancelAppointment($id)
    {
        $appointment = Appointment::where('user_id', Auth::id())
                                ->with(['agent', 'property'])
                                ->findOrFail($id);
        
        $oldStatus = $appointment->status;
        $appointment->status = 'cancelled';
        $appointment->save();
        
        // Envoyer une notification à l'agent
        try {
            $appointment->agent->notify(new \App\Notifications\AppointmentStatusChanged($appointment, $oldStatus));
        } catch (\Exception $e) {
            // Log l'erreur mais continuer l'exécution
            \Log::error('Erreur lors de l\'envoi de la notification: ' . $e->getMessage());
        }
        
        $notification = [
            'message' => 'Rendez-vous annulé avec succès',
            'alert-type' => 'success'
        ];
        
        return redirect()->back()->with($notification);
    }
    
    /**
     * Affiche la liste des rendez-vous pour l'agent connecté
     * 
     * @return \Illuminate\View\View
     */
    public function AgentAppointments()
    {
        $appointments = Appointment::with(['property', 'user'])
                                ->where('agent_id', Auth::id())
                                ->latest()
                                ->get();
        
        return view('frontend.appointment.agent_appointments', compact('appointments'));
    }
    
    /**
     * Change le statut d'un rendez-vous (pour l'agent)
     * 
     * @param int $id ID du rendez-vous
     * @param string $status Nouveau statut à appliquer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function AgentChangeStatus($id, $status)
    {
        // Vérifier que le statut est valide
        if (!in_array($status, ['confirmed', 'cancelled', 'completed'])) {
            $notification = [
                'message' => 'Statut invalide',
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($notification);
        }
        
        // Vérifier que le rendez-vous appartient à l'agent connecté
        $appointment = Appointment::where('agent_id', Auth::id())
                                ->with(['user', 'property'])
                                ->findOrFail($id);
        
        $oldStatus = $appointment->status;
        $appointment->status = $status;
        $appointment->save();
        
        // Envoyer une notification à l'utilisateur
        try {
            $appointment->user->notify(new \App\Notifications\AppointmentStatusChanged($appointment, $oldStatus));
        } catch (\Exception $e) {
            // Log l'erreur mais continuer l'exécution
            \Log::error('Erreur lors de l\'envoi de la notification: ' . $e->getMessage());
        }
        
        $notification = [
            'message' => 'Statut du rendez-vous mis à jour avec succès',
            'alert-type' => 'success'
        ];
        
        return redirect()->back()->with($notification);
    }
    
    /**
     * Affiche les détails d'un rendez-vous pour l'agent
     * 
     * @param int $id ID du rendez-vous
     * @return \Illuminate\View\View
     */
    public function AgentViewAppointment($id)
    {
        // Vérifier que le rendez-vous appartient à l'agent connecté
        $appointment = Appointment::where('agent_id', Auth::id())
                                ->with(['user', 'property'])
                                ->findOrFail($id);
        
        return view('agent.appointments.view_appointment', compact('appointment'));
    }
    
    /**
     * Confirme un rendez-vous (pour l'agent)
     * 
     * @param int $id ID du rendez-vous
     * @return \Illuminate\Http\RedirectResponse
     */
    public function AgentConfirmAppointment($id)
    {
        // Vérifier que le rendez-vous appartient à l'agent connecté
        $appointment = Appointment::where('agent_id', Auth::id())
                                ->with(['user', 'property'])
                                ->findOrFail($id);
        
        $oldStatus = $appointment->status;
        $appointment->status = 'confirmed';
        $appointment->save();
        
        // Envoyer une notification à l'utilisateur
        try {
            $appointment->user->notify(new \App\Notifications\AppointmentStatusChanged($appointment, $oldStatus));
        } catch (\Exception $e) {
            // Log l'erreur mais continuer l'exécution
            \Log::error('Erreur lors de l\'envoi de la notification: ' . $e->getMessage());
        }
        
        $notification = [
            'message' => 'Rendez-vous confirmé avec succès',
            'alert-type' => 'success'
        ];
        
        return redirect()->back()->with($notification);
    }
    
    /**
     * Annule un rendez-vous (pour l'agent)
     * 
     * @param int $id ID du rendez-vous
     * @return \Illuminate\Http\RedirectResponse
     */
    public function AgentCancelAppointment($id)
    {
        // Vérifier que le rendez-vous appartient à l'agent connecté
        $appointment = Appointment::where('agent_id', Auth::id())
                                ->with(['user', 'property'])
                                ->findOrFail($id);
        
        $oldStatus = $appointment->status;
        $appointment->status = 'cancelled';
        $appointment->save();
        
        // Envoyer une notification à l'utilisateur
        try {
            $appointment->user->notify(new \App\Notifications\AppointmentStatusChanged($appointment, $oldStatus));
        } catch (\Exception $e) {
            // Log l'erreur mais continuer l'exécution
            \Log::error('Erreur lors de l\'envoi de la notification: ' . $e->getMessage());
        }
        
        $notification = [
            'message' => 'Rendez-vous annulé avec succès',
            'alert-type' => 'success'
        ];
        
        return redirect()->back()->with($notification);
    }
    
    /**
     * Marque un rendez-vous comme terminé (pour l'agent)
     * 
     * @param int $id ID du rendez-vous
     * @return \Illuminate\Http\RedirectResponse
     */
    public function AgentCompleteAppointment($id)
    {
        // Vérifier que le rendez-vous appartient à l'agent connecté
        $appointment = Appointment::where('agent_id', Auth::id())
                                ->with(['user', 'property'])
                                ->findOrFail($id);
        
        $oldStatus = $appointment->status;
        $appointment->status = 'completed';
        $appointment->save();
        
        // Envoyer une notification à l'utilisateur
        try {
            $appointment->user->notify(new \App\Notifications\AppointmentStatusChanged($appointment, $oldStatus));
        } catch (\Exception $e) {
            // Log l'erreur mais continuer l'exécution
            \Log::error('Erreur lors de l\'envoi de la notification: ' . $e->getMessage());
        }
        
        $notification = [
            'message' => 'Rendez-vous marqué comme terminé avec succès',
            'alert-type' => 'success'
        ];
        
        return redirect()->back()->with($notification);
    }
}
