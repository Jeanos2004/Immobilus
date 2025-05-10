<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function Index(){
        // Charger les types de propriétés pour le formulaire de recherche
        $propertyTypes = \App\Models\PropertyType::orderBy('type_name', 'ASC')->get();
        
        // Charger les propriétés en vedette (actives et marquées comme featured)
        $featuredProperties = \App\Models\Property::with('type', 'user')
            ->where('status', 1)
            ->where('featured', 1)
            ->orderBy('id', 'DESC')
            ->limit(6)
            ->get();
            
        // Charger les propriétés récentes
        $recentProperties = \App\Models\Property::with('type', 'user')
            ->where('status', 1)
            ->orderBy('id', 'DESC')
            ->limit(3)
            ->get();
            
        // Charger les agents immobiliers
        $agents = \App\Models\User::where('status', 'active')
            ->where('role', 'agent')
            ->orderBy('id', 'DESC')
            ->limit(4)
            ->get();
            
        return view('frontend.index', compact(
            'propertyTypes',
            'featuredProperties',
            'recentProperties',
            'agents'
        ));
    }

    public function UserProfile(){
        $userData = User::find(Auth::user()->id);
        return view('frontend.dashboard.edit_profile', compact('userData'));
    }

    public function UserProfileStore(Request $request){
        $profileData = User::find(Auth::user()->id);

        $profileData->username = $request->username;
        $profileData->name = $request->name;
        $profileData->email = $request->email;
        $profileData->phone = $request->phone;
        $profileData->address = $request->address;

        if($request->photo){
            if(Auth::user()->photo != ''){
                $delete_form = public_path('uploads/user_images/'. $profileData->photo);
                unlink($delete_form);
            }
            
            $file = $request->photo;
            $extension = $file->extension();
            $file_name = uniqid().'.'. $extension;

            $file->move(public_path('uploads/user_images'), $file_name);
            $profileData['photo'] = $file_name;
        }
        $profileData->save();

        $notification = array(
            'message' => "User Profile Updated Successfully",
            'alert-type' => 'success'
        );
        return back()->with($notification);
    }

    public function UserLogout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $notification = array(
            'message' => "User Logout Successfully",
            'alert-type' => 'success'
        );

        return redirect('/login')->with($notification);
    }

    public function UserChangePassword(){
        return view('frontend.dashboard.change_password');
    }

    public function UserPasswordUpdate(Request $request){

        //validation
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|confirmed'
        ]);

        //Match The Old Password
        if(!Hash::check($request->old_password, Auth::user()->password)){
            $notification = array(
                'message' => "User Password Does not Match!",
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
    
    public function Contact(){
        return view('frontend.contact');
    }
}
