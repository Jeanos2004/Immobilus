<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function AdminDashboard(){
        // Récupérer les statistiques pour le tableau de bord
        $totalProperties = \App\Models\Property::count();
        $totalAgents = \App\Models\User::where('role', 'agent')->count();
        $totalUsers = \App\Models\User::where('role', 'user')->count();
        $totalTestimonials = \App\Models\Testimonial::count();
        $totalAppointments = \App\Models\Appointment::count() ?? 0;
        $pendingAppointments = \App\Models\Appointment::where('status', 'pending')->count() ?? 0;
        $totalPropertyTypes = \App\Models\PropertyType::count();
        $totalAmenities = \App\Models\Amenities::count();
        
        // Récupérer les propriétés récentes
        $recentProperties = \App\Models\Property::with(['type', 'user'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        // Récupérer les agents les plus actifs (avec le plus de propriétés)
        $topAgents = \App\Models\User::withCount('properties')
            ->where('role', 'agent')
            ->orderBy('properties_count', 'desc')
            ->limit(5)
            ->get();
            
        // Récupérer les rendez-vous récents
        $recentAppointments = \App\Models\Appointment::with(['property', 'user'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get() ?? collect([]);
            
        // Récupérer les types de propriétés avec le nombre de propriétés par type
        $propertyTypeStats = \App\Models\PropertyType::withCount('properties')
            ->orderBy('properties_count', 'desc')
            ->get();
            
        return view('admin.index', compact(
            'totalProperties', 
            'totalAgents', 
            'totalUsers', 
            'totalTestimonials',
            'totalAppointments',
            'pendingAppointments',
            'totalPropertyTypes',
            'totalAmenities',
            'recentProperties',
            'topAgents',
            'recentAppointments',
            'propertyTypeStats'
        ));

    } // End Method

    /**
     * Renvoie uniquement le tableau des propriétés récentes (pour rafraîchissement AJAX)
     */
    public function RecentPropertiesPartial()
    {
        $recentProperties = \App\Models\Property::with(['type', 'user'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.partials.recent_properties_rows', compact('recentProperties'));
    }

    /**
     * Télécharge un rapport CSV simple avec les principales statistiques du dashboard.
     */
    public function DownloadDashboardReport()
    {
        // Récupérer les mêmes statistiques que sur le dashboard
        $totalProperties     = \App\Models\Property::count();
        $totalAgents         = \App\Models\User::where('role', 'agent')->count();
        $totalUsers          = \App\Models\User::where('role', 'user')->count();
        $totalTestimonials   = \App\Models\Testimonial::count();
        $totalAppointments   = \App\Models\Appointment::count() ?? 0;
        $pendingAppointments = \App\Models\Appointment::where('status', 'pending')->count() ?? 0;
        $totalPropertyTypes  = \App\Models\PropertyType::count();
        $totalAmenities      = \App\Models\Amenities::count();

        $rows = [
            ['Métrique', 'Valeur'],
            ['Total des propriétés', $totalProperties],
            ['Total des agents', $totalAgents],
            ['Total des utilisateurs', $totalUsers],
            ['Total des témoignages', $totalTestimonials],
            ['Total des rendez-vous', $totalAppointments],
            ['Rendez-vous en attente', $pendingAppointments],
            ['Types de propriétés', $totalPropertyTypes],
            ['Aménités', $totalAmenities],
        ];

        $callback = function () use ($rows) {
            $fh = fopen('php://output', 'w');
            // BOM UTF-8 pour bonne ouverture dans Excel
            fprintf($fh, chr(0xEF).chr(0xBB).chr(0xBF));
            foreach ($rows as $row) {
                fputcsv($fh, $row, ';');
            }
            fclose($fh);
        };

        $filename = 'rapport-dashboard-immobilus-'.now()->format('Y-m-d_H-i-s').'.csv';

        return response()->streamDownload($callback, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function AdminLogout(Request $request){
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $notification = [
            'message' => "Déconnexion administrateur réussie",
            'alert-type' => 'success',
        ];

        // Redirige vers la page de connexion principale (frontend)
        return redirect()->route('login')->with($notification);
    } // End Method

    public function AdminLogin(){
        return view('admin.admin_login');

    }

    public function AdminProfile(){
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('admin.admin_profile_view', compact('profileData'));
    }

    public function AdminProfileStore(Request $request){
        $profileData = User::find(Auth::user()->id);

        $profileData->username = $request->username;
        $profileData->name = $request->name;
        $profileData->email = $request->email;
        $profileData->phone = $request->phone;
        $profileData->address = $request->address;

        if($request->photo){
            
            
            $file = $request->photo;
            $delete_form = public_path('uploads/admin_images/'. $profileData->photo);
            //unlink($delete_form);
            
            $extension = $file->extension();
            $file_name = uniqid().'.'. $extension;

            $file->move(public_path('uploads/admin_images'), $file_name);
            $profileData['photo'] = $file_name;
        }
        $profileData->save();

        $notification = array(
            'message' => "Admin Profile Updated Successfully",
            'alert-type' => 'success'
        );
        return back()->with($notification);
    }
    
    public function AdminChangePassword(){
        $profileData = User::find(Auth::user()->id);
        return view('admin.admin_change_password', compact('profileData'));
    }

    public function AdminUpdatePassword(Request $request){

        //validation
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|confirmed'
        ]);

        //Match The Old Password
        if(!Hash::check($request->old_password, Auth::user()->password)){
            $notification = array(
                'message' => "Admin Password Does not Match!",
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }

        //Update The New Password
        User::whereId(Auth::user()->id)->update([
            'password' => Hash::make($request->password),
        ]);

        $notification = array(
            'message' => "Password Update Successfully",
            'alert-type' => 'success'
        );
        return back()->with($notification);
    }
}
