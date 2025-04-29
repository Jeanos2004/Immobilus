<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relation avec le type de propriété
    public function type()
    {
        return $this->belongsTo(PropertyType::class, 'ptype_id', 'id');
    }

    // Relation avec l'utilisateur (agent)
    public function user()
    {
        return $this->belongsTo(User::class, 'agent_id', 'id');
    }

    // Relation avec les aménités (many-to-many)
    public function amenities()
    {
        return $this->belongsToMany(Amenities::class, 'property_amenities', 'property_id', 'amenities_id');
    }
}
