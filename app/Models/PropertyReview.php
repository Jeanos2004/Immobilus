<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyReview extends Model
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
        'rating' => 'integer',
        'rating_location' => 'integer',
        'rating_cleanliness' => 'integer',
        'rating_value' => 'integer',
        'rating_comfort' => 'integer',
        'rating_amenities' => 'integer',
        'rating_accuracy' => 'integer',
    ];

    /**
     * Relation avec l'utilisateur qui a laissé l'avis
     * Un avis appartient à un seul utilisateur
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec la propriété concernée par l'avis
     * Un avis concerne une seule propriété
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * Relation avec les réponses à cet avis
     * Un avis peut avoir plusieurs réponses
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany(ReviewReply::class, 'review_id');
    }

    /**
     * Relation avec les votes sur cet avis
     * Un avis peut avoir plusieurs votes
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function votes()
    {
        return $this->hasMany(ReviewVote::class, 'review_id');
    }

    /**
     * Relation avec les signalements de cet avis
     * Un avis peut avoir plusieurs signalements
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reports()
    {
        return $this->hasMany(ReviewReport::class, 'review_id');
    }

    /**
     * Calcule le nombre de votes utiles pour cet avis
     * 
     * @return int
     */
    public function getHelpfulVotesCountAttribute()
    {
        return $this->votes()->where('is_helpful', true)->count();
    }

    /**
     * Calcule le nombre de votes non utiles pour cet avis
     * 
     * @return int
     */
    public function getUnhelpfulVotesCountAttribute()
    {
        return $this->votes()->where('is_helpful', false)->count();
    }

    /**
     * Calcule la note moyenne des catégories pour cet avis
     * 
     * @return float
     */
    public function getAverageCategoryRatingAttribute()
    {
        $sum = 0;
        $count = 0;
        
        $categories = [
            'rating_location',
            'rating_cleanliness',
            'rating_value',
            'rating_comfort',
            'rating_amenities',
            'rating_accuracy'
        ];
        
        foreach ($categories as $category) {
            if (!is_null($this->$category)) {
                $sum += $this->$category;
                $count++;
            }
        }
        
        return $count > 0 ? round($sum / $count, 1) : 0;
    }
}
