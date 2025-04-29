<?php

namespace App\Http\Controllers\Backend;

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
     * Affiche la liste de tous les rendez-vous
     * 
     * @return \Illuminate\View\View
     */
    public function AllAppointments()
    {
        // Récupérer tous les rendez-vous avec leurs relations
        $appointments = Appointment::with(['user', 'agent', 'property'])
                                ->latest()
                                ->get();
        
        return view('backend.appointment.all_appointments', compact('appointments'));
    }
    
    /**
     * Affiche les rendez-vous en attente
     * 
     * @return \Illuminate\View\View
     */
    public function PendingAppointments()
    {
        // Récupérer les rendez-vous avec statut 'pending'
        $appointments = Appointment::with(['user', 'agent', 'property'])
                                ->where('status', 'pending')
                                ->latest()
                                ->get();
        
        return view('backend.appointment.pending_appointments', compact('appointments'));
    }
    
    /**
     * Affiche les rendez-vous confirmés
     * 
     * @return \Illuminate\View\View
     */
    public function ConfirmedAppointments()
    {
        // Récupérer les rendez-vous avec statut 'confirmed'
        $appointments = Appointment::with(['user', 'agent', 'property'])
                                ->where('status', 'confirmed')
                                ->latest()
                                ->get();
        
        return view('backend.appointment.confirmed_appointments', compact('appointments'));
    }
    
    /**
     * Affiche les rendez-vous annulés
     * 
     * @return \Illuminate\View\View
     */
    public function CancelledAppointments()
    {
        // Récupérer les rendez-vous avec statut 'cancelled'
        $appointments = Appointment::with(['user', 'agent', 'property'])
                                ->where('status', 'cancelled')
                                ->latest()
                                ->get();
        
        return view('backend.appointment.cancelled_appointments', compact('appointments'));
    }
    
    /**
     * Affiche les rendez-vous terminés
     * 
     * @return \Illuminate\View\View
     */
    public function CompletedAppointments()
    {
        // Récupérer les rendez-vous avec statut 'completed'
        $appointments = Appointment::with(['user', 'agent', 'property'])
                                ->where('status', 'completed')
                                ->latest()
                                ->get();
        
        return view('backend.appointment.completed_appointments', compact('appointments'));
    }
    
    /**
     * Change le statut d'un rendez-vous
     * 
     * @param int $id ID du rendez-vous
     * @param string $status Nouveau statut à appliquer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function ChangeStatus($id, $status)
    {
        // Vérifier que le statut est valide
        if (!in_array($status, ['pending', 'confirmed', 'cancelled', 'completed'])) {
            $notification = [
                'message' => 'Statut invalide',
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($notification);
        }
        
        // Mettre à jour le statut du rendez-vous
        $appointment = Appointment::with(['user', 'agent', 'property'])->findOrFail($id);
        $oldStatus = $appointment->status;
        $appointment->status = $status;
        $appointment->save();
        
        // Envoyer une notification à l'utilisateur et à l'agent
        try {
            // Notification à l'utilisateur
            $appointment->user->notify(new \App\Notifications\AppointmentStatusChanged($appointment, $oldStatus));
            
            // Notification à l'agent
            $appointment->agent->notify(new \App\Notifications\AppointmentStatusChanged($appointment, $oldStatus));
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
     * Supprime un rendez-vous
     * 
     * @param int $id ID du rendez-vous à supprimer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function DeleteAppointment($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();
        
        $notification = [
            'message' => 'Rendez-vous supprimé avec succès',
            'alert-type' => 'success'
        ];
        
        return redirect()->back()->with($notification);
    }
}
