<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\Amenities;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use Illuminate\Support\Str;

class PropertyController extends Controller
{
    /**
     * Affiche la liste de toutes les propriétés
     * Cette méthode récupère toutes les propriétés de la base de données et les affiche dans une vue
     */
    public function AllProperty()
    {
        // Récupère toutes les propriétés avec leurs relations (type de propriété et agent)
        $properties = Property::with(['type', 'user'])->latest()->get();
        return view('backend.property.all_property', compact('properties'));
    }

    /**
     * Affiche le formulaire pour ajouter une nouvelle propriété
     * Cette méthode prépare les données nécessaires pour le formulaire d'ajout
     */
    public function AddProperty()
    {
        // Récupère tous les types de propriétés pour le menu déroulant
        $propertyTypes = PropertyType::latest()->get();
        
        // Récupère toutes les aménités pour les cases à cocher
        $amenities = Amenities::latest()->get();
        
        // Récupère tous les agents actifs pour le menu déroulant
        $activeAgents = User::where('status', 'active')
                            ->where('role', 'agent')
                            ->latest()
                            ->get();
        
        return view('backend.property.add_property', compact('propertyTypes', 'amenities', 'activeAgents'));
    }

    /**
     * Enregistre une nouvelle propriété dans la base de données
     * Cette méthode traite les données du formulaire, valide les entrées et enregistre la propriété
     */
    public function StoreProperty(Request $request)
    {
        // Validation des champs du formulaire
        $request->validate([
            'ptype_id' => 'required',
            'property_name' => 'required',
            'property_status' => 'required',
            'lowest_price' => 'required',
            'property_thumbnail' => 'required|image|mimes:jpeg,jpg,png,gif|max:2048',
            'short_description' => 'required',
            'long_description' => 'required',
            'bedrooms' => 'required',
            'bathrooms' => 'required',
            'garage' => 'required',
            'property_size' => 'required',
            'address' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
        ]);

        // Génération d'un code unique pour la propriété
        $propertyCode = 'PC' . mt_rand(1000000, 9999999);
        
        // Traitement de l'image principale (thumbnail)
        $image = $request->file('property_thumbnail');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        
        // Redimensionnement et sauvegarde de l'image
        Image::make($image)->resize(370, 250)->save('upload/property/thumbnail/' . $name_gen);
        $save_url = 'upload/property/thumbnail/' . $name_gen;

        // Création du slug à partir du nom de la propriété
        $property_slug = Str::slug($request->property_name);

        // Récupération de l'ID de la propriété nouvellement créée
        $property_id = Property::insertGetId([
            'ptype_id' => $request->ptype_id,
            'agent_id' => $request->agent_id,
            'property_name' => $request->property_name,
            'property_slug' => $property_slug,
            'property_code' => $propertyCode,
            'property_status' => $request->property_status,
            'lowest_price' => $request->lowest_price,
            'max_price' => $request->max_price,
            'property_thumbnail' => $save_url,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
            'bedrooms' => $request->bedrooms,
            'bathrooms' => $request->bathrooms,
            'garage' => $request->garage,
            'garage_size' => $request->garage_size,
            'property_size' => $request->property_size,
            'property_video' => $request->property_video,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'postal_code' => $request->postal_code,
            'neighborhood' => $request->neighborhood,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'featured' => $request->featured,
            'hot' => $request->hot,
            'status' => 1, // Par défaut, la propriété est active
            'created_at' => Carbon::now(),
        ]);

        // Traitement des aménités sélectionnées (relation many-to-many)
        if ($request->amenities_id) {
            $amenities = $request->amenities_id;
            
            // Pour chaque aménité sélectionnée, on crée une entrée dans la table pivot
            foreach ($amenities as $amenity) {
                DB::table('property_amenities')->insert([
                    'property_id' => $property_id,
                    'amenities_id' => $amenity,
                    'created_at' => Carbon::now(),
                ]);
            }
        }

        // Message de notification
        $notification = array(
            'message' => 'Propriété ajoutée avec succès',
            'alert-type' => 'success'
        );

        return redirect()->route('all.property')->with($notification);
    }

    /**
     * Affiche le formulaire pour modifier une propriété existante
     * Cette méthode récupère les données de la propriété à modifier et les affiche dans un formulaire
     */
    public function EditProperty($id)
    {
        // Récupère la propriété avec ses relations (aménités)
        $property = Property::findOrFail($id);
        
        // Récupère tous les types de propriétés pour le menu déroulant
        $propertyTypes = PropertyType::latest()->get();
        
        // Récupère toutes les aménités pour les cases à cocher
        $amenities = Amenities::latest()->get();
        
        // Récupère tous les agents actifs pour le menu déroulant
        $activeAgents = User::where('status', 'active')
                            ->where('role', 'agent')
                            ->latest()
                            ->get();
        
        // Récupère les IDs des aménités associées à cette propriété
        $property_amenities = DB::table('property_amenities')
                                ->where('property_id', $id)
                                ->pluck('amenities_id')
                                ->toArray();
        
        return view('backend.property.edit_property', compact(
            'property', 
            'propertyTypes', 
            'amenities', 
            'activeAgents', 
            'property_amenities'
        ));
    }

    /**
     * Met à jour une propriété existante dans la base de données
     * Cette méthode traite les données du formulaire, valide les entrées et met à jour la propriété
     */
    public function UpdateProperty(Request $request)
    {
        // Récupération de l'ID de la propriété à mettre à jour
        $property_id = $request->id;
        
        // Validation des champs du formulaire
        $request->validate([
            'ptype_id' => 'required',
            'property_name' => 'required',
            'property_status' => 'required',
            'lowest_price' => 'required',
            'short_description' => 'required',
            'long_description' => 'required',
            'bedrooms' => 'required',
            'bathrooms' => 'required',
            'garage' => 'required',
            'property_size' => 'required',
            'address' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
        ]);

        // Création du slug à partir du nom de la propriété
        $property_slug = Str::slug($request->property_name);

        // Mise à jour des données de la propriété
        Property::findOrFail($property_id)->update([
            'ptype_id' => $request->ptype_id,
            'agent_id' => $request->agent_id,
            'property_name' => $request->property_name,
            'property_slug' => $property_slug,
            'property_status' => $request->property_status,
            'lowest_price' => $request->lowest_price,
            'max_price' => $request->max_price,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
            'bedrooms' => $request->bedrooms,
            'bathrooms' => $request->bathrooms,
            'garage' => $request->garage,
            'garage_size' => $request->garage_size,
            'property_size' => $request->property_size,
            'property_video' => $request->property_video,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'postal_code' => $request->postal_code,
            'neighborhood' => $request->neighborhood,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'featured' => $request->featured,
            'hot' => $request->hot,
            'updated_at' => Carbon::now(),
        ]);

        // Message de notification
        $notification = array(
            'message' => 'Propriété mise à jour avec succès',
            'alert-type' => 'success'
        );

        return redirect()->route('all.property')->with($notification);
    }

    /**
     * Met à jour l'image principale (thumbnail) d'une propriété
     * Cette méthode traite le téléchargement et le redimensionnement de l'image
     */
    public function UpdatePropertyThumbnail(Request $request)
    {
        // Récupération de l'ID de la propriété
        $property_id = $request->id;
        $old_image = $request->old_img;

        // Traitement de la nouvelle image
        $image = $request->file('property_thumbnail');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        
        // Redimensionnement et sauvegarde de l'image
        Image::make($image)->resize(370, 250)->save('upload/property/thumbnail/' . $name_gen);
        $save_url = 'upload/property/thumbnail/' . $name_gen;

        // Suppression de l'ancienne image si elle existe
        if (file_exists($old_image)) {
            unlink($old_image);
        }

        // Mise à jour de l'image dans la base de données
        Property::findOrFail($property_id)->update([
            'property_thumbnail' => $save_url,
            'updated_at' => Carbon::now(),
        ]);

        // Message de notification
        $notification = array(
            'message' => 'Image principale mise à jour avec succès',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    /**
     * Met à jour les aménités associées à une propriété
     * Cette méthode gère la relation many-to-many entre les propriétés et les aménités
     */
    public function UpdatePropertyAmenities(Request $request)
    {
        // Récupération de l'ID de la propriété
        $property_id = $request->id;
        
        // Suppression de toutes les anciennes relations d'aménités pour cette propriété
        DB::table('property_amenities')->where('property_id', $property_id)->delete();
        
        // Traitement des nouvelles aménités sélectionnées
        if ($request->amenities_id) {
            $amenities = $request->amenities_id;
            
            // Pour chaque aménité sélectionnée, on crée une entrée dans la table pivot
            foreach ($amenities as $amenity) {
                DB::table('property_amenities')->insert([
                    'property_id' => $property_id,
                    'amenities_id' => $amenity,
                    'created_at' => Carbon::now(),
                ]);
            }
        }

        // Message de notification
        $notification = array(
            'message' => 'Aménités mises à jour avec succès',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    /**
     * Supprime une propriété de la base de données
     * Cette méthode supprime la propriété et son image associée
     */
    public function DeleteProperty($id)
    {
        // Récupération de la propriété à supprimer
        $property = Property::findOrFail($id);
        $img = $property->property_thumbnail;
        
        // Suppression de l'image si elle existe
        if (file_exists($img)) {
            unlink($img);
        }
        
        // Suppression de la propriété (les relations dans la table pivot seront automatiquement supprimées grâce à onDelete('cascade'))
        Property::findOrFail($id)->delete();
        
        // Message de notification
        $notification = array(
            'message' => 'Propriété supprimée avec succès',
            'alert-type' => 'success'
        );
        
        return redirect()->back()->with($notification);
    }

    /**
     * Change le statut d'une propriété (active/inactive)
     * Cette méthode bascule le statut d'une propriété entre actif et inactif
     */
    public function ChangePropertyStatus($id)
    {
        // Récupération de la propriété
        $property = Property::findOrFail($id);
        
        // Si la propriété est active, on la désactive, et vice versa
        if ($property->status == 1) {
            Property::findOrFail($id)->update([
                'status' => 0,
            ]);
            
            $notification = array(
                'message' => 'Propriété désactivée',
                'alert-type' => 'warning'
            );
        } else {
            Property::findOrFail($id)->update([
                'status' => 1,
            ]);
            
            $notification = array(
                'message' => 'Propriété activée',
                'alert-type' => 'success'
            );
        }
        
        return redirect()->back()->with($notification);
    }
}
