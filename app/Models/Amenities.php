<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amenities extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    // Relation avec les propriétés (many-to-many)
    public function properties()
    {
        return $this->belongsToMany(Property::class, 'property_amenities', 'amenities_id', 'property_id');
    }
}
