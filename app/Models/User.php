<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Relation avec les propriétés (pour les agents)
     * Un agent peut avoir plusieurs propriétés à vendre/louer
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function properties()
    {
        return $this->hasMany(Property::class, 'agent_id', 'id');
    }
    
    /**
     * Relation avec les propriétés favorites
     * Un utilisateur peut avoir plusieurs propriétés favorites
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
    
    /**
     * Relation directe avec les propriétés favorites
     * Permet d'accéder directement aux propriétés favorites sans passer par le modèle Favorite
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function favoriteProperties()
    {
        return $this->belongsToMany(Property::class, 'favorites', 'user_id', 'property_id')->withTimestamps();
    }
    
    /**
     * Relation avec les rendez-vous où l'utilisateur est l'agent
     * Un agent peut avoir plusieurs rendez-vous
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function agentAppointments()
    {
        return $this->hasMany(Appointment::class, 'agent_id', 'id');
    }
    
    /**
     * Relation avec les rendez-vous où l'utilisateur est le client
     * Un utilisateur peut avoir plusieurs rendez-vous
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userAppointments()
    {
        return $this->hasMany(Appointment::class, 'user_id', 'id');
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
