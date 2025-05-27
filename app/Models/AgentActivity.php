<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentActivity extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'agent_id',
        'type',
        'description',
    ];
    
    /**
     * Obtenir l'agent associé à cette activité
     */
    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }
}
