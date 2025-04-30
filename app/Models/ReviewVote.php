<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewVote extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * Les attributs à convertir en types natifs.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_helpful' => 'boolean',
    ];

    /**
     * Relation avec l'avis auquel ce vote est associé
     * Un vote appartient à un seul avis
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function review()
    {
        return $this->belongsTo(PropertyReview::class, 'review_id');
    }

    /**
     * Relation avec l'utilisateur qui a voté
     * Un vote appartient à un seul utilisateur
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
