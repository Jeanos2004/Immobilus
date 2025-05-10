<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Property;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    // Afficher la liste des agents (vue liste)
    public function AgentsList()
    {
        $agents = User::where('status', 'active')
            ->where('role', 'agent')
            ->orderBy('id', 'DESC')
            ->paginate(12);
        
        return view('frontend.agent.agents_list', compact('agents'));
    }

    // Afficher la liste des agents (vue grille)
    public function AgentsGrid()
    {
        $agents = User::where('status', 'active')
            ->where('role', 'agent')
            ->orderBy('id', 'DESC')
            ->paginate(12);
        
        return view('frontend.agent.agents_grid', compact('agents'));
    }

    // Afficher les détails d'un agent
    public function AgentDetails($id)
    {
        $agent = User::findOrFail($id);
        
        // Récupérer les propriétés de l'agent
        $properties = Property::where('agent_id', $id)
            ->where('status', 1)
            ->orderBy('id', 'DESC')
            ->paginate(6);
        
        return view('frontend.agent.agent_details', compact('agent', 'properties'));
    }
}
