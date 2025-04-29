<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Amenities;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AmenityController extends Controller
{
    /**
     * Affiche la liste de toutes les aménités
     */
    public function AllAmenities()
    {
        $amenities = Amenities::latest()->get();
        return view('backend.amenities.all_amenities', compact('amenities'));
    }

    /**
     * Affiche le formulaire pour ajouter une nouvelle aménité
     */
    public function AddAmenity()
    {
        return view('backend.amenities.add_amenities');
    }

    /**
     * Enregistre une nouvelle aménité dans la base de données
     */
    public function StoreAmenity(Request $request)
    {
        $request->validate([
            'amenities_name' => 'required|unique:amenities|max:200',
        ]);

        Amenities::insert([
            'amenities_name' => $request->amenities_name,
            'created_at' => Carbon::now(),
        ]);

        $notification = [
            'message' => "Aménité créée avec succès",
            'alert-type' => 'success'
        ];
        
        return redirect()->route('all.amenitie')->with($notification);
    }

    /**
     * Affiche le formulaire pour modifier une aménité existante
     */
    public function EditAmenity($id)
    {
        $amenity = Amenities::findOrFail($id);
        return view('backend.amenities.edit_amenities', compact('amenity'));
    }

    /**
     * Met à jour une aménité existante dans la base de données
     */
    public function UpdateAmenity(Request $request)
    {
        $amenity_id = $request->id;

        $request->validate([
            'amenities_name' => 'required|max:200|unique:amenities,amenities_name,'.$amenity_id,
        ]);

        Amenities::findOrFail($amenity_id)->update([
            'amenities_name' => $request->amenities_name,
            'updated_at' => Carbon::now(),
        ]);

        $notification = [
            'message' => "Aménité mise à jour avec succès",
            'alert-type' => 'success'
        ];
        
        return redirect()->route('all.amenitie')->with($notification);
    }

    /**
     * Supprime une aménité de la base de données
     */
    public function DeleteAmenity($id)
    {
        Amenities::findOrFail($id)->delete();

        $notification = [
            'message' => "Aménité supprimée avec succès",
            'alert-type' => 'success'
        ];
        
        return redirect()->back()->with($notification);
    }
}
