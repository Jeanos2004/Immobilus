<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\PropertyImage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class MultiImageController extends Controller
{
    /**
     * Affiche le formulaire pour ajouter des images à une propriété
     * 
     * @param int $id ID de la propriété
     * @return \Illuminate\View\View
     */
    public function StoreMultiImage($id)
    {
        // Récupérer la propriété
        $property = Property::findOrFail($id);
        
        // Récupérer les images existantes de la propriété
        $multiImages = PropertyImage::where('property_id', $id)->get();
        
        return view('backend.property.multi_image', compact('property', 'multiImages'));
    }
    
    /**
     * Enregistre les nouvelles images pour une propriété
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function SaveMultiImage(Request $request)
    {
        // Validation des données
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'multi_img' => 'required|array',
            'multi_img.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        // Récupérer l'ID de la propriété
        $property_id = $request->property_id;
        
        // Traiter chaque image
        if ($request->hasFile('multi_img')) {
            foreach ($request->file('multi_img') as $image) {
                // Générer un nom unique pour l'image
                $imageName = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
                
                // Créer le répertoire s'il n'existe pas
                $uploadPath = 'upload/property/multi-image/';
                if (!File::isDirectory(public_path($uploadPath))) {
                    File::makeDirectory(public_path($uploadPath), 0777, true);
                }
                
                // Redimensionner et sauvegarder l'image
                Image::make($image)->resize(770, 520)->save(public_path($uploadPath . $imageName));
                
                // Enregistrer l'image dans la base de données
                PropertyImage::create([
                    'property_id' => $property_id,
                    'photo_name' => $uploadPath . $imageName,
                ]);
            }
        }
        
        // Notification et redirection
        $notification = [
            'message' => 'Images ajoutées avec succès',
            'alert-type' => 'success'
        ];
        
        return redirect()->back()->with($notification);
    }
    
    /**
     * Supprime une image de la galerie
     * 
     * @param int $id ID de l'image à supprimer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function DeleteMultiImage($id)
    {
        // Récupérer l'image
        $image = PropertyImage::findOrFail($id);
        
        // Supprimer le fichier physique
        if (File::exists(public_path($image->photo_name))) {
            File::delete(public_path($image->photo_name));
        }
        
        // Supprimer l'enregistrement de la base de données
        $image->delete();
        
        // Notification et redirection
        $notification = [
            'message' => 'Image supprimée avec succès',
            'alert-type' => 'success'
        ];
        
        return redirect()->back()->with($notification);
    }
    
    /**
     * Met à jour l'ordre des images (fonctionnalité future)
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function UpdateMultiImageOrder(Request $request)
    {
        // Fonctionnalité à implémenter pour réorganiser les images
        // Cette méthode sera utilisée si vous souhaitez permettre aux utilisateurs de réorganiser les images
        
        return redirect()->back();
    }
}
