<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class NotificationController extends Controller
{
    /**
     * Affiche toutes les notifications de l'utilisateur connecté
     * 
     * @return \Illuminate\Http\Response
     */
    public function AllNotifications()
    {
        // Récupérer l'utilisateur connecté
        $user = Auth::user();
        
        // Récupérer toutes les notifications (lues et non lues)
        $notifications = $user->notifications()->latest()->paginate(10);
        
        return view('notifications.all_notifications', compact('notifications'));
    }
    
    /**
     * Marque une notification comme lue
     * 
     * @param string $id ID de la notification
     * @return \Illuminate\Http\RedirectResponse
     */
    public function MarkAsRead($id)
    {
        // Récupérer l'utilisateur connecté
        $user = Auth::user();
        
        // Marquer la notification comme lue
        $notification = $user->notifications()->where('id', $id)->first();
        
        if ($notification) {
            $notification->markAsRead();
            
            $toast = [
                'message' => 'Notification marquée comme lue',
                'alert-type' => 'success'
            ];
        } else {
            $toast = [
                'message' => 'Notification introuvable',
                'alert-type' => 'error'
            ];
        }
        
        return redirect()->back()->with($toast);
    }
    
    /**
     * Marque toutes les notifications comme lues
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function MarkAllAsRead()
    {
        // Récupérer l'utilisateur connecté
        $user = Auth::user();
        
        // Marquer toutes les notifications comme lues
        $user->unreadNotifications->markAsRead();
        
        $toast = [
            'message' => 'Toutes les notifications ont été marquées comme lues',
            'alert-type' => 'success'
        ];
        
        return redirect()->back()->with($toast);
    }
    
    /**
     * Supprime une notification
     * 
     * @param string $id ID de la notification
     * @return \Illuminate\Http\RedirectResponse
     */
    public function DeleteNotification($id)
    {
        // Récupérer l'utilisateur connecté
        $user = Auth::user();
        
        // Supprimer la notification
        $notification = $user->notifications()->where('id', $id)->first();
        
        if ($notification) {
            $notification->delete();
            
            $toast = [
                'message' => 'Notification supprimée avec succès',
                'alert-type' => 'success'
            ];
        } else {
            $toast = [
                'message' => 'Notification introuvable',
                'alert-type' => 'error'
            ];
        }
        
        return redirect()->back()->with($toast);
    }
    
    /**
     * Supprime toutes les notifications
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function DeleteAllNotifications()
    {
        // Récupérer l'utilisateur connecté
        $user = Auth::user();
        
        // Supprimer toutes les notifications
        $user->notifications()->delete();
        
        $toast = [
            'message' => 'Toutes les notifications ont été supprimées',
            'alert-type' => 'success'
        ];
        
        return redirect()->back()->with($toast);
    }
}
