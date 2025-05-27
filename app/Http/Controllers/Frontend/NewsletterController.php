<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class NewsletterController extends Controller
{
    // Afficher la page d'abonnement à la newsletter
    public function index()
    {
        return view('frontend.newsletter.index');
    }

    // S'abonner à la newsletter
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:newsletters,email'
        ], [
            'email.required' => 'Veuillez entrer votre adresse e-mail.',
            'email.email' => 'Veuillez entrer une adresse e-mail valide.',
            'email.unique' => 'Cette adresse e-mail est déjà abonnée à notre newsletter.'
        ]);

        // Générer un token unique
        $token = Str::random(64);

        // Enregistrer l'abonnement
        Newsletter::create([
            'email' => $request->email,
            'token' => $token,
            'is_active' => true
        ]);

        // Envoyer un e-mail de confirmation (simulation)
        // Mail::to($request->email)->send(new \App\Mail\NewsletterConfirmation($token));

        $notification = [
            'message' => 'Vous êtes maintenant abonné à notre newsletter !',
            'alert-type' => 'success'
        ];

        return back()->with($notification);
    }

    // Se désabonner de la newsletter
    public function unsubscribe($token)
    {
        $subscriber = Newsletter::where('token', $token)->first();

        if (!$subscriber) {
            $notification = [
                'message' => 'Lien de désabonnement invalide.',
                'alert-type' => 'error'
            ];

            return redirect()->route('homepage')->with($notification);
        }

        // Désactiver l'abonnement
        $subscriber->is_active = false;
        $subscriber->save();

        $notification = [
            'message' => 'Vous avez été désabonné de notre newsletter avec succès.',
            'alert-type' => 'success'
        ];

        return redirect()->route('homepage')->with($notification);
    }
}
