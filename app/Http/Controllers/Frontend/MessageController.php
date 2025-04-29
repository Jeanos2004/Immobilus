<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MessageController extends Controller
{
    /**
     * Envoie un message à un agent concernant une propriété
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function SendMessage(Request $request)
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login')->with([
                'message' => 'Veuillez vous connecter pour envoyer un message',
                'alert-type' => 'error'
            ]);
        }
        
        // Valider les données
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'agent_id' => 'required|exists:users,id',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10|max:1000'
        ], [
            'subject.required' => 'Veuillez indiquer un sujet',
            'subject.max' => 'Le sujet ne doit pas dépasser 255 caractères',
            'message.required' => 'Veuillez écrire un message',
            'message.min' => 'Le message doit contenir au moins 10 caractères',
            'message.max' => 'Le message ne doit pas dépasser 1000 caractères'
        ]);
        
        // Créer le message
        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->agent_id,
            'property_id' => $request->property_id,
            'subject' => $request->subject,
            'message' => $request->message,
            'read' => false
        ]);
        
        $notification = [
            'message' => 'Votre message a été envoyé avec succès',
            'alert-type' => 'success'
        ];
        
        return redirect()->back()->with($notification);
    }
    
    /**
     * Affiche tous les messages reçus par l'utilisateur connecté
     * 
     * @return \Illuminate\View\View
     */
    public function UserInbox()
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        // Récupérer les messages reçus par l'utilisateur
        $messages = Message::where('receiver_id', Auth::id())
                            ->with(['sender', 'property'])
                            ->latest()
                            ->get();
        
        return view('frontend.message.inbox', compact('messages'));
    }
    
    /**
     * Affiche tous les messages envoyés par l'utilisateur connecté
     * 
     * @return \Illuminate\View\View
     */
    public function UserSent()
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        // Récupérer les messages envoyés par l'utilisateur
        $messages = Message::where('sender_id', Auth::id())
                            ->with(['receiver', 'property'])
                            ->latest()
                            ->get();
        
        return view('frontend.message.sent', compact('messages'));
    }
    
    /**
     * Affiche un message spécifique
     * 
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function ViewMessage($id)
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        // Récupérer le message
        $message = Message::with(['sender', 'receiver', 'property'])
                            ->findOrFail($id);
        
        // Vérifier que l'utilisateur est bien le destinataire ou l'expéditeur du message
        if ($message->receiver_id !== Auth::id() && $message->sender_id !== Auth::id()) {
            return redirect()->route('user.inbox')->with([
                'message' => 'Vous n\'êtes pas autorisé à voir ce message',
                'alert-type' => 'error'
            ]);
        }
        
        // Marquer le message comme lu si l'utilisateur est le destinataire
        if ($message->receiver_id === Auth::id() && !$message->read) {
            $message->update([
                'read' => true
            ]);
        }
        
        // Récupérer les réponses à ce message
        $replies = Message::where('parent_id', $id)
                        ->with(['sender', 'receiver'])
                        ->orderBy('created_at', 'asc')
                        ->get();
        
        return view('frontend.message.view_message', compact('message', 'replies'));
    }
    
    /**
     * Supprime un message
     * 
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function DeleteMessage($id)
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        // Récupérer le message
        $message = Message::findOrFail($id);
        
        // Vérifier que l'utilisateur est bien le destinataire ou l'expéditeur du message
        if ($message->receiver_id !== Auth::id() && $message->sender_id !== Auth::id()) {
            return redirect()->route('user.inbox')->with([
                'message' => 'Vous n\'êtes pas autorisé à supprimer ce message',
                'alert-type' => 'error'
            ]);
        }
        
        // Supprimer le message
        $message->delete();
        
        $notification = [
            'message' => 'Message supprimé avec succès',
            'alert-type' => 'success'
        ];
        
        return redirect()->back()->with($notification);
    }
    
    /**
     * Répond à un message
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function ReplyMessage(Request $request)
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login')->with([
                'message' => 'Veuillez vous connecter pour répondre à ce message',
                'alert-type' => 'error'
            ]);
        }
        
        // Valider les données
        $request->validate([
            'parent_id' => 'required|exists:messages,id',
            'property_id' => 'required|exists:properties,id',
            'agent_id' => 'required|exists:users,id',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10|max:1000'
        ], [
            'subject.required' => 'Veuillez indiquer un sujet',
            'subject.max' => 'Le sujet ne doit pas dépasser 255 caractères',
            'message.required' => 'Veuillez écrire un message',
            'message.min' => 'Le message doit contenir au moins 10 caractères',
            'message.max' => 'Le message ne doit pas dépasser 1000 caractères'
        ]);
        
        // Récupérer le message original
        // Créer la réponse
        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->agent_id,
            'property_id' => $request->property_id,
            'subject' => $request->subject,
            'message' => $request->message,
            'parent_id' => $request->parent_id,
            'read' => false
        ]);
        
        $notification = [
            'message' => 'Votre réponse a été envoyée avec succès',
            'alert-type' => 'success'
        ];
        
        return redirect()->back()->with($notification);
    }
    
    /**
     * Affiche tous les messages pour l'administration
     * 
     * @return \Illuminate\View\View
     */
    public function AdminAllMessages()
    {
        // Récupérer tous les messages avec les relations
        $messages = Message::with(['sender', 'receiver', 'property'])
                            ->latest()
                            ->get();
        
        return view('backend.message.all_messages', compact('messages'));
    }
    
    /**
     * Affiche un message spécifique pour l'administration
     * 
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function AdminViewMessage($id)
    {
        // Récupérer le message
        $message = Message::with(['sender', 'receiver', 'property'])
                            ->findOrFail($id);
        
        // Récupérer les réponses à ce message
        $replies = Message::where('parent_id', $id)
                        ->with(['sender', 'receiver'])
                        ->orderBy('created_at', 'asc')
                        ->get();
        
        return view('backend.message.view_message', compact('message', 'replies'));
    }
    
    /**
     * Supprime un message (admin)
     * 
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function AdminDeleteMessage($id)
    {
        // Récupérer le message
        $message = Message::findOrFail($id);
        
        // Supprimer le message
        $message->delete();
        
        $notification = [
            'message' => 'Message supprimé avec succès',
            'alert-type' => 'success'
        ];
        
        return redirect()->route('admin.all.messages')->with($notification);
    }
    
    /**
     * Affiche tous les messages reçus par l'agent connecté
     * 
     * @return \Illuminate\View\View
     */
    public function AgentInbox()
    {
        // Récupérer les messages reçus par l'agent
        $messages = Message::where('receiver_id', Auth::id())
                            ->with(['sender', 'property'])
                            ->latest()
                            ->get();
        
        return view('agent.message.inbox', compact('messages'));
    }
    
    /**
     * Affiche tous les messages envoyés par l'agent connecté
     * 
     * @return \Illuminate\View\View
     */
    public function AgentSent()
    {
        // Récupérer les messages envoyés par l'agent
        $messages = Message::where('sender_id', Auth::id())
                            ->with(['receiver', 'property'])
                            ->latest()
                            ->get();
        
        return view('agent.message.sent', compact('messages'));
    }
    
    /**
     * Affiche un message spécifique pour l'agent
     * 
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function AgentViewMessage($id)
    {
        // Récupérer le message
        $message = Message::with(['sender', 'receiver', 'property'])
                            ->findOrFail($id);
        
        // Vérifier que l'agent est bien le destinataire ou l'expéditeur du message
        if ($message->receiver_id !== Auth::id() && $message->sender_id !== Auth::id()) {
            return redirect()->route('agent.inbox')->with([
                'message' => 'Vous n\'êtes pas autorisé à voir ce message',
                'alert-type' => 'error'
            ]);
        }
        
        // Marquer le message comme lu si l'agent est le destinataire
        if ($message->receiver_id === Auth::id() && !$message->read) {
            $message->update([
                'read' => true
            ]);
        }
        
        // Récupérer les réponses à ce message
        $replies = Message::where('parent_id', $id)
                        ->with(['sender', 'receiver'])
                        ->orderBy('created_at', 'asc')
                        ->get();
        
        return view('agent.message.view_message', compact('message', 'replies'));
    }
    
    /**
     * Supprime un message (agent)
     * 
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function AgentDeleteMessage($id)
    {
        // Récupérer le message
        $message = Message::findOrFail($id);
        
        // Vérifier que l'agent est bien le destinataire ou l'expéditeur du message
        if ($message->receiver_id !== Auth::id() && $message->sender_id !== Auth::id()) {
            return redirect()->route('agent.inbox')->with([
                'message' => 'Vous n\'êtes pas autorisé à supprimer ce message',
                'alert-type' => 'error'
            ]);
        }
        
        // Supprimer le message
        $message->delete();
        
        $notification = [
            'message' => 'Message supprimé avec succès',
            'alert-type' => 'success'
        ];
        
        return redirect()->back()->with($notification);
    }
    
    /**
     * Répond à un message (agent)
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function AgentReplyMessage(Request $request)
    {
        // Valider les données
        $request->validate([
            'parent_id' => 'required|exists:messages,id',
            'property_id' => 'required|exists:properties,id',
            'user_id' => 'required|exists:users,id',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10|max:1000'
        ], [
            'subject.required' => 'Veuillez indiquer un sujet',
            'subject.max' => 'Le sujet ne doit pas dépasser 255 caractères',
            'message.required' => 'Veuillez écrire un message',
            'message.min' => 'Le message doit contenir au moins 10 caractères',
            'message.max' => 'Le message ne doit pas dépasser 1000 caractères'
        ]);
        
        // Créer la réponse
        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->user_id,
            'property_id' => $request->property_id,
            'subject' => $request->subject,
            'message' => $request->message,
            'parent_id' => $request->parent_id,
            'read' => false
        ]);
        
        $notification = [
            'message' => 'Votre réponse a été envoyée avec succès',
            'alert-type' => 'success'
        ];
        
        return redirect()->back()->with($notification);
    }
}
