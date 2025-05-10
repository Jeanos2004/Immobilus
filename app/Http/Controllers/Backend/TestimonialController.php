<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class TestimonialController extends Controller
{
    /**
     * Affiche la liste de tous les témoignages
     */
    public function AllTestimonials()
    {
        $testimonials = Testimonial::latest()->get();
        return view('backend.testimonials.all_testimonials', compact('testimonials'));
    }

    /**
     * Affiche le formulaire pour ajouter un témoignage
     */
    public function AddTestimonial()
    {
        return view('backend.testimonials.add_testimonial');
    }

    /**
     * Enregistre un nouveau témoignage
     */
    public function StoreTestimonial(Request $request)
    {
        // Validation des données
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'message' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        // Gérer l'upload de la photo
        $photo_path = null;
        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $save_url = 'upload/testimonials/' . $name_gen;
            
            // Créer le dossier s'il n'existe pas
            if (!File::exists('upload/testimonials')) {
                File::makeDirectory('upload/testimonials', 0777, true);
            }
            
            // Redimensionner et sauvegarder l'image
            Image::make($image)->resize(100, 100)->save($save_url);
            $photo_path = $save_url;
        }

        // Créer le témoignage
        Testimonial::create([
            'name' => $request->name,
            'position' => $request->position,
            'message' => $request->message,
            'photo' => $photo_path,
            'rating' => $request->rating,
            'status' => $request->status ? 1 : 0,
        ]);

        $notification = array(
            'message' => 'Témoignage ajouté avec succès',
            'alert-type' => 'success'
        );

        return redirect()->route('all.testimonials')->with($notification);
    }

    /**
     * Affiche le formulaire pour éditer un témoignage
     */
    public function EditTestimonial($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        return view('backend.testimonials.edit_testimonial', compact('testimonial'));
    }

    /**
     * Met à jour un témoignage existant
     */
    public function UpdateTestimonial(Request $request)
    {
        // Validation des données
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'message' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $testimonial_id = $request->id;
        $testimonial = Testimonial::findOrFail($testimonial_id);

        // Gérer l'upload de la photo
        if ($request->hasFile('photo')) {
            // Supprimer l'ancienne photo si elle existe
            if ($testimonial->photo && file_exists(public_path($testimonial->photo))) {
                unlink(public_path($testimonial->photo));
            }
            
            $image = $request->file('photo');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $save_url = 'upload/testimonials/' . $name_gen;
            
            // Créer le dossier s'il n'existe pas
            if (!File::exists('upload/testimonials')) {
                File::makeDirectory('upload/testimonials', 0777, true);
            }
            
            // Redimensionner et sauvegarder l'image
            Image::make($image)->resize(100, 100)->save($save_url);
            $testimonial->photo = $save_url;
        }

        // Mettre à jour les autres champs
        $testimonial->name = $request->name;
        $testimonial->position = $request->position;
        $testimonial->message = $request->message;
        $testimonial->rating = $request->rating;
        $testimonial->status = $request->status ? 1 : 0;
        $testimonial->save();

        $notification = array(
            'message' => 'Témoignage mis à jour avec succès',
            'alert-type' => 'success'
        );

        return redirect()->route('all.testimonials')->with($notification);
    }

    /**
     * Supprime un témoignage
     */
    public function DeleteTestimonial($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        
        // Supprimer la photo si elle existe
        if ($testimonial->photo && file_exists(public_path($testimonial->photo))) {
            unlink(public_path($testimonial->photo));
        }
        
        $testimonial->delete();

        $notification = array(
            'message' => 'Témoignage supprimé avec succès',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    /**
     * Change le statut d'un témoignage (actif/inactif)
     */
    public function ChangeTestimonialStatus($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->status = $testimonial->status == 1 ? 0 : 1;
        $testimonial->save();

        $status = $testimonial->status == 1 ? 'activé' : 'désactivé';
        $notification = array(
            'message' => 'Témoignage ' . $status . ' avec succès',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
