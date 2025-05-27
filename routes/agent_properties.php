    // Routes pour les propriétés (agent)
    Route::controller(\App\Http\Controllers\Frontend\PropertyController::class)->group(function(){
        // Liste des propriétés de l'agent
        Route::get('/agent/properties', 'AgentProperties')->name('agent.properties.all');
        // Ajouter une propriété
        Route::get('/agent/property/add', 'AgentAddProperty')->name('agent.property.add');
        // Enregistrer une nouvelle propriété
        Route::post('/agent/property/store', 'AgentStoreProperty')->name('agent.property.store');
        // Modifier une propriété
        Route::get('/agent/property/edit/{id}', 'AgentEditProperty')->name('agent.property.edit');
        // Mettre à jour une propriété
        Route::post('/agent/property/update/{id}', 'AgentUpdateProperty')->name('agent.property.update');
        // Supprimer une propriété
        Route::get('/agent/property/delete/{id}', 'AgentDeleteProperty')->name('agent.property.delete');
        // Détails d'une propriété
        Route::get('/agent/property/view/{id}', 'AgentViewProperty')->name('agent.property.view');
    });
