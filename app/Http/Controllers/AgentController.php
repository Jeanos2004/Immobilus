<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Property;
use App\Models\Appointment;
use App\Models\Message;
use App\Models\Payment;
use App\Models\AgentActivity;
use Carbon\Carbon;
use Illuminate\Support\Str;

class AgentController extends Controller
{
    public function AgentDashboard(){
        $id = Auth::user()->id;
        $agent = User::find($id);
        
        // Statistiques des propriétés
        $totalProperties = Property::where('agent_id', $id)->count();
        $activeProperties = Property::where('agent_id', $id)->where('status', 1)->count();
        $saleProperties = Property::where('agent_id', $id)->where('property_status', 'buy')->count();
        $rentProperties = Property::where('agent_id', $id)->where('property_status', 'rent')->count();
        
        // Calcul des pourcentages pour les graphiques
        $salePercentage = $totalProperties > 0 ? ($saleProperties / $totalProperties) * 100 : 0;
        $rentPercentage = $totalProperties > 0 ? ($rentProperties / $totalProperties) * 100 : 0;
        
        // Nombre total de vues de propriétés
        $totalViews = Property::where('agent_id', $id)->sum('views');
        
        // Statistiques des rendez-vous
        $totalAppointments = Appointment::whereHas('property', function($query) use ($id) {
            $query->where('agent_id', $id);
        })->count();
        
        $pendingAppointments = Appointment::whereHas('property', function($query) use ($id) {
            $query->where('agent_id', $id);
        })->where('status', 'pending')->count();
        
        // Rendez-vous récents
        $recentAppointments = Appointment::whereHas('property', function($query) use ($id) {
            $query->where('agent_id', $id);
        })
        ->with(['property', 'user'])
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();
        
        // Statistiques des messages
        $totalMessages = Message::where('receiver_id', $id)->count();
        $unreadMessages = Message::where('receiver_id', $id)->where('is_read', 0)->count();
        
        // Messages récents
        $recentMessages = Message::where('receiver_id', $id)
            ->with('sender')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Statistiques des paiements
        $totalRevenue = Payment::whereHas('property', function($query) use ($id) {
            $query->where('agent_id', $id);
        })->where('status', 'completed')->sum('amount');
        
        $paymentsThisMonth = Payment::whereHas('property', function($query) use ($id) {
            $query->where('agent_id', $id);
        })
        ->where('status', 'completed')
        ->whereMonth('created_at', Carbon::now()->month)
        ->count();
        
        // Propriétés populaires
        $popularProperties = Property::where('agent_id', $id)
            ->where('status', 1)
            ->orderBy('views', 'desc')
            ->take(5)
            ->get();
        
        // Activités récentes
        $recentActivities = AgentActivity::where('agent_id', $id)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        
        return view('agent.dashboard', compact(
            'agent',
            'totalProperties',
            'activeProperties',
            'saleProperties',
            'rentProperties',
            'salePercentage',
            'rentPercentage',
            'totalViews',
            'totalAppointments',
            'pendingAppointments',
            'recentAppointments',
            'totalMessages',
            'unreadMessages',
            'recentMessages',
            'totalRevenue',
            'paymentsThisMonth',
            'popularProperties',
            'recentActivities'
        ));
    } // End Method
    
    // Méthode pour afficher tous les rendez-vous de l'agent
    public function AllAppointments() {
        $id = Auth::user()->id;
        
        $appointments = Appointment::whereHas('property', function($query) use ($id) {
            $query->where('agent_id', $id);
        })
        ->with(['property', 'user'])
        ->orderBy('appointment_date', 'desc')
        ->paginate(10);
        
        return view('agent.appointments.all_appointments', compact('appointments'));
    }
    
    // Méthode pour afficher les détails d'un rendez-vous
    public function ViewAppointment($id) {
        $appointment = Appointment::with(['property', 'user'])->findOrFail($id);
        
        // Vérifier que le rendez-vous appartient à une propriété de l'agent connecté
        if ($appointment->property->agent_id != Auth::user()->id) {
            return redirect()->route('agent.dashboard')
                ->with('error', 'Vous n\'êtes pas autorisé à voir ce rendez-vous');
        }
        
        return view('agent.appointments.view_appointment', compact('appointment'));
    }
    
    // Méthode pour confirmer un rendez-vous
    public function ConfirmAppointment($id) {
        $appointment = Appointment::findOrFail($id);
        
        // Vérifier que le rendez-vous appartient à une propriété de l'agent connecté
        if ($appointment->property->agent_id != Auth::user()->id) {
            return redirect()->route('agent.dashboard')
                ->with('error', 'Vous n\'êtes pas autorisé à modifier ce rendez-vous');
        }
        
        $appointment->status = 'confirmed';
        $appointment->save();
        
        // Enregistrer l'activité
        $this->logActivity('appointment', 'Rendez-vous #' . $appointment->id . ' confirmé pour la propriété <strong>' . $appointment->property->property_name . '</strong>');
        
        // Notification à l'utilisateur (à implémenter)
        
        return redirect()->back()
            ->with('message', 'Rendez-vous confirmé avec succès')
            ->with('alert-type', 'success');
    }
    
    // Méthode pour annuler un rendez-vous
    public function CancelAppointment($id) {
        $appointment = Appointment::findOrFail($id);
        
        // Vérifier que le rendez-vous appartient à une propriété de l'agent connecté
        if ($appointment->property->agent_id != Auth::user()->id) {
            return redirect()->route('agent.dashboard')
                ->with('error', 'Vous n\'êtes pas autorisé à modifier ce rendez-vous');
        }
        
        $appointment->status = 'cancelled';
        $appointment->save();
        
        // Enregistrer l'activité
        $this->logActivity('appointment', 'Rendez-vous #' . $appointment->id . ' annulé pour la propriété <strong>' . $appointment->property->property_name . '</strong>');
        
        // Notification à l'utilisateur (à implémenter)
        
        return redirect()->back()
            ->with('message', 'Rendez-vous annulé avec succès')
            ->with('alert-type', 'success');
    }
    
    // Méthode pour marquer un rendez-vous comme terminé
    public function CompleteAppointment($id) {
        $appointment = Appointment::findOrFail($id);
        
        // Vérifier que le rendez-vous appartient à une propriété de l'agent connecté
        if ($appointment->property->agent_id != Auth::user()->id) {
            return redirect()->route('agent.dashboard')
                ->with('error', 'Vous n\'êtes pas autorisé à modifier ce rendez-vous');
        }
        
        $appointment->status = 'completed';
        $appointment->save();
        
        // Enregistrer l'activité
        $this->logActivity('appointment', 'Rendez-vous #' . $appointment->id . ' terminé pour la propriété <strong>' . $appointment->property->property_name . '</strong>');
        
        return redirect()->back()
            ->with('message', 'Rendez-vous marqué comme terminé avec succès')
            ->with('alert-type', 'success');
    }
    
    // Méthode pour afficher tous les messages de l'agent
    public function AllMessages() {
        $id = Auth::user()->id;
        
        $messages = Message::where('receiver_id', $id)
            ->with('sender')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('agent.messages.all_messages', compact('messages'));
    }
    
    // Méthode pour afficher toutes les propriétés de l'agent
    public function AllProperties() {
        $id = Auth::user()->id;
        
        $properties = Property::where('agent_id', $id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('agent.properties.all_properties', compact('properties'));
    }
    
    // Méthode pour créer une nouvelle propriété
    public function CreateProperty() {
        return view('agent.properties.create_property');
    }
    
    // Méthode privée pour enregistrer les activités de l'agent
    private function logActivity($type, $description) {
        AgentActivity::create([
            'agent_id' => Auth::user()->id,
            'type' => $type,
            'description' => $description,
        ]);
    }
}
