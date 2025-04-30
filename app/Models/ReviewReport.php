<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewReport extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * Relation avec l'avis qui est signalé
     * Un signalement concerne un seul avis
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function review()
    {
        return $this->belongsTo(PropertyReview::class, 'review_id');
    }

    /**
     * Relation avec l'utilisateur qui a signalé l'avis
     * Un signalement est fait par un seul utilisateur
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
