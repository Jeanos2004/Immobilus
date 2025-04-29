<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * Relation avec le type de propriété
     * Une propriété appartient à un seul type de propriété
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(PropertyType::class, 'ptype_id', 'id');
    }

    /**
     * Relation avec l'utilisateur (agent)
     * Une propriété appartient à un seul agent
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'agent_id', 'id');
    }

    /**
     * Relation avec les aménités (many-to-many)
     * Une propriété peut avoir plusieurs aménités
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function amenities()
    {
        return $this->belongsToMany(Amenities::class, 'property_amenities', 'property_id', 'amenities_id');
    }
    
    /**
     * Relation avec les images de propriété
     * Une propriété peut avoir plusieurs images
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function propertyImages()
    {
        return $this->hasMany(PropertyImage::class);
    }
    
    /**
     * Relation avec les avis sur la propriété
     * Une propriété peut avoir plusieurs avis d'utilisateurs
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviews()
    {
        return $this->hasMany(PropertyReview::class);
    }
    
    /**
     * Relation avec les utilisateurs qui ont mis cette propriété en favori
     * Une propriété peut être mise en favori par plusieurs utilisateurs
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites', 'property_id', 'user_id')->withTimestamps();
    }
}
