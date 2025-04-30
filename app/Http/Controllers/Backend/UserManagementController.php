<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    /**
     * Affiche la liste de tous les utilisateurs
     * 
     * @return \Illuminate\View\View
     */
    public function AllUsers()
    {
        // Récupérer tous les utilisateurs avec pagination
        $users = User::latest()->paginate(10);
        
        // Vérifier si des utilisateurs ont été récupérés
        if ($users->isEmpty()) {
            // Si aucun utilisateur n'est trouvé, ajouter un message
            return view('backend.users.all_users', compact('users'))->with('message', 'Aucun utilisateur trouvé dans la base de données.');
        }
        
        return view('backend.users.all_users', compact('users'));
    }
    
    /**
     * Affiche la liste des administrateurs
     * 
     * @return \Illuminate\View\View
     */
    public function AllAdmins()
    {
        // Récupérer tous les utilisateurs avec le rôle 'admin'
        $admins = User::where('role', 'admin')->latest()->paginate(10);
        
        return view('backend.users.all_admins', compact('admins'));
    }
    
    /**
     * Affiche la liste des agents immobiliers
     * 
     * @return \Illuminate\View\View
     */
    public function AllAgents()
    {
        // Récupérer tous les utilisateurs avec le rôle 'agent'
        $agents = User::where('role', 'agent')->latest()->paginate(10);
        
        return view('backend.users.all_agents', compact('agents'));
    }
    
    /**
     * Affiche la liste des utilisateurs réguliers
     * 
     * @return \Illuminate\View\View
     */
    public function AllCustomers()
    {
        // Récupérer tous les utilisateurs avec le rôle 'user'
        $customers = User::where('role', 'user')->latest()->paginate(10);
        
        return view('backend.users.all_customers', compact('customers'));
    }
    
    /**
     * Affiche le formulaire pour ajouter un nouvel utilisateur
     * 
     * @return \Illuminate\View\View
     */
    public function AddUser()
    {
        return view('backend.users.add_user');
    }
    
    /**
     * Enregistre un nouvel utilisateur dans la base de données
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function StoreUser(Request $request)
    {
        // Validation des données
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,agent,user',
            'status' => 'required|in:active,inactive',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        // Création d'un nouvel utilisateur
        $user = new User();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        $user->status = $request->status;
        
        // Gestion de l'image de profil
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move(public_path('uploads/user_images'), $filename);
            $user->photo = $filename;
        }
        
        $user->save();
        
        $notification = [
            'message' => 'Utilisateur créé avec succès',
            'alert-type' => 'success'
        ];
        
        return redirect()->route('all.users')->with($notification);
    }
    
    /**
     * Affiche le formulaire pour modifier un utilisateur
     * 
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function EditUser($id)
    {
        $user = User::findOrFail($id);
        return view('backend.users.edit_user', compact('user'));
    }
    
    /**
     * Met à jour les informations d'un utilisateur
     * 
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function UpdateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        // Validation des données
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'role' => 'required|in:admin,agent,user',
            'status' => 'required|in:active,inactive',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        // Mise à jour des informations
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->role = $request->role;
        $user->status = $request->status;
        
        // Mise à jour du mot de passe si fourni
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        
        // Gestion de l'image de profil
        if ($request->hasFile('photo')) {
            // Supprimer l'ancienne image si elle existe
            if ($user->photo && file_exists(public_path('uploads/user_images/' . $user->photo))) {
                unlink(public_path('uploads/user_images/' . $user->photo));
            }
            
            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move(public_path('uploads/user_images'), $filename);
            $user->photo = $filename;
        }
        
        $user->save();
        
        $notification = [
            'message' => 'Utilisateur mis à jour avec succès',
            'alert-type' => 'success'
        ];
        
        return redirect()->route('all.users')->with($notification);
    }
    
    /**
     * Affiche les détails d'un utilisateur
     * 
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function ViewUser($id)
    {
        $user = User::findOrFail($id);
        return view('backend.users.view_user', compact('user'));
    }
    
    /**
     * Supprime un utilisateur
     * 
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function DeleteUser($id)
    {
        $user = User::findOrFail($id);
        
        // Supprimer l'image de profil si elle existe
        if ($user->photo && file_exists(public_path('uploads/user_images/' . $user->photo))) {
            unlink(public_path('uploads/user_images/' . $user->photo));
        }
        
        $user->delete();
        
        $notification = [
            'message' => 'Utilisateur supprimé avec succès',
            'alert-type' => 'success'
        ];
        
        return redirect()->back()->with($notification);
    }
    
    /**
     * Change le statut d'un utilisateur (actif/inactif)
     * 
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function ChangeUserStatus($id)
    {
        $user = User::findOrFail($id);
        
        // Inverser le statut actuel
        $user->status = ($user->status == 'active') ? 'inactive' : 'active';
        $user->save();
        
        $status = $user->status == 'active' ? 'activé' : 'désactivé';
        
        $notification = [
            'message' => "Compte utilisateur {$status} avec succès",
            'alert-type' => 'success'
        ];
        
        return redirect()->back()->with($notification);
    }
    
    /**
     * Change le rôle d'un utilisateur
     * 
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function ChangeUserRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        // Validation du rôle
        $request->validate([
            'role' => 'required|in:admin,agent,user'
        ]);
        
        $user->role = $request->role;
        $user->save();
        
        $notification = [
            'message' => "Rôle de l'utilisateur changé avec succès",
            'alert-type' => 'success'
        ];
        
        return redirect()->back()->with($notification);
    }
}
