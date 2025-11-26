<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Property;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AppointmentStatsController extends Controller
{
    /**
     * Affiche le tableau de bord des statistiques des rendez-vous pour l'administrateur
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Statistiques générales
        $stats = [
            'total' => Appointment::count(),
            'pending' => Appointment::where('status', 'pending')->count(),
            'confirmed' => Appointment::where('status', 'confirmed')->count(),
            'cancelled' => Appointment::where('status', 'cancelled')->count(),
            'completed' => Appointment::where('status', 'completed')->count(),
        ];
        
        // Rendez-vous par mois (pour les 6 derniers mois)
        $appointmentsByMonth = $this->getAppointmentsByMonth();
        
        // Top 5 des agents avec le plus de rendez-vous
        $topAgents = $this->getTopAgents();
        
        // Top 5 des propriétés les plus visitées
        $topProperties = $this->getTopProperties();
        
        // Taux de conversion (rendez-vous terminés / total des rendez-vous)
        $conversionRate = $stats['total'] > 0 ? round(($stats['completed'] / $stats['total']) * 100, 2) : 0;
        
        // Taux d'annulation (rendez-vous annulés / total des rendez-vous)
        $cancellationRate = $stats['total'] > 0 ? round(($stats['cancelled'] / $stats['total']) * 100, 2) : 0;
        
        // Rendez-vous à venir dans les 7 prochains jours
        $upcomingAppointments = Appointment::with(['user', 'agent', 'property'])
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('appointment_date', '>=', Carbon::now())
            ->where('appointment_date', '<=', Carbon::now()->addDays(7))
            ->orderBy('appointment_date')
            ->take(10)
            ->get();
        
        return view('backend.stats.appointment_stats', compact(
            'stats', 
            'appointmentsByMonth', 
            'topAgents', 
            'topProperties', 
            'conversionRate', 
            'cancellationRate', 
            'upcomingAppointments'
        ));
    }
    
    /**
     * Affiche le tableau de bord des statistiques des rendez-vous pour un agent spécifique
     * 
     * @return \Illuminate\View\View
     */
    public function agentStats()
    {
        $agentId = auth()->id();
        
        // Statistiques générales pour cet agent
        $stats = [
            'total' => Appointment::where('agent_id', $agentId)->count(),
            'pending' => Appointment::where('agent_id', $agentId)->where('status', 'pending')->count(),
            'confirmed' => Appointment::where('agent_id', $agentId)->where('status', 'confirmed')->count(),
            'cancelled' => Appointment::where('agent_id', $agentId)->where('status', 'cancelled')->count(),
            'completed' => Appointment::where('agent_id', $agentId)->where('status', 'completed')->count(),
        ];
        
        // Rendez-vous par mois pour cet agent (pour les 6 derniers mois)
        $appointmentsByMonth = $this->getAppointmentsByMonth($agentId);
        
        // Top 5 des propriétés les plus visitées pour cet agent
        $topProperties = $this->getTopProperties($agentId);
        
        // Taux de conversion (rendez-vous terminés / total des rendez-vous)
        $conversionRate = $stats['total'] > 0 ? round(($stats['completed'] / $stats['total']) * 100, 2) : 0;
        
        // Taux d'annulation (rendez-vous annulés / total des rendez-vous)
        $cancellationRate = $stats['total'] > 0 ? round(($stats['cancelled'] / $stats['total']) * 100, 2) : 0;
        
        // Rendez-vous à venir dans les 7 prochains jours
        $upcomingAppointments = Appointment::with(['user', 'property'])
            ->where('agent_id', $agentId)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('appointment_date', '>=', Carbon::now())
            ->where('appointment_date', '<=', Carbon::now()->addDays(7))
            ->orderBy('appointment_date')
            ->take(10)
            ->get();
        
        return view('frontend.stats.agent_appointment_stats', compact(
            'stats', 
            'appointmentsByMonth', 
            'topProperties', 
            'conversionRate', 
            'cancellationRate', 
            'upcomingAppointments'
        ));
    }
    
    /**
     * Récupère les données des rendez-vous par mois pour les 6 derniers mois
     * 
     * @param int|null $agentId ID de l'agent (optionnel)
     * @return array Tableau des données par mois
     */
    private function getAppointmentsByMonth($agentId = null)
    {
        $months = [];
        $pendingData = [];
        $confirmedData = [];
        $cancelledData = [];
        $completedData = [];
        
        // Générer les 6 derniers mois
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = $date->format('M Y'); // Format: Jan 2025
            
            $startOfMonth = Carbon::now()->subMonths($i)->startOfMonth();
            $endOfMonth = Carbon::now()->subMonths($i)->endOfMonth();
            
            // Requête de base
            $query = Appointment::whereBetween('created_at', [$startOfMonth, $endOfMonth]);
            
            // Si un agent spécifique est demandé
            if ($agentId) {
                $query->where('agent_id', $agentId);
            }
            
            // Compter les rendez-vous par statut
            $pendingData[] = (clone $query)->where('status', 'pending')->count();
            $confirmedData[] = (clone $query)->where('status', 'confirmed')->count();
            $cancelledData[] = (clone $query)->where('status', 'cancelled')->count();
            $completedData[] = (clone $query)->where('status', 'completed')->count();
        }
        
        return [
            'months' => $months,
            'pending' => $pendingData,
            'confirmed' => $confirmedData,
            'cancelled' => $cancelledData,
            'completed' => $completedData
        ];
    }
    
    /**
     * Récupère les 5 agents avec le plus de rendez-vous
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getTopAgents()
    {
        return User::withCount(['agentAppointments as total_appointments'])
            ->withCount([
                'agentAppointments as completed_appointments' => function ($query) {
                    $query->where('status', 'completed');
                }
            ])
            ->withCount([
                'agentAppointments as conversion_rate' => function ($query) {
                    $query->selectRaw('ROUND((COUNT(CASE WHEN status = "completed" THEN 1 END) / COUNT(*)) * 100, 2)');
                }
            ])
            ->where('role', 'agent')
            ->orderBy('total_appointments', 'desc')
            ->take(5)
            ->get();
    }
    
    /**
     * Récupère les 5 propriétés avec le plus de rendez-vous
     * 
     * @param int|null $agentId ID de l'agent (optionnel)
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getTopProperties($agentId = null)
    {
        $query = Property::withCount(['appointments as total_appointments'])
            ->withCount([
                'appointments as completed_appointments' => function ($query) {
                    $query->where('status', 'completed');
                }
            ])
            ->with('type');
        
        // Si un agent spécifique est demandé
        if ($agentId) {
            $query->whereHas('appointments', function ($q) use ($agentId) {
                $q->where('agent_id', $agentId);
            });
        }
        
        return $query->orderBy('total_appointments', 'desc')
            ->take(5)
            ->get();
    }
}
