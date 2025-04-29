<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\Backend\PropertyTypeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\PropertyController;

// Route::get('/', function () {
//     return view('welcome');
// });

// Routes pour le changement de langue
Route::get('/language/{locale}', [LanguageController::class, 'switchLang'])->name('lang.switch');

// User Frontend All Routes
Route::get('/', [UserController::class, 'Index']);

// Routes pour les propriétés (frontend)
Route::controller(\App\Http\Controllers\Frontend\PropertyController::class)->group(function(){
    Route::get('/properties', 'PropertyList')->name('property.list');
    Route::get('/properties/grid', 'PropertyGrid')->name('property.grid');
    Route::get('/property/details/{id}/{slug}', 'PropertyDetails')->name('property.details');
    Route::get('/property/search', 'PropertySearch')->name('property.search');
    Route::get('/property/type/{id}', 'PropertyByType')->name('property.type');
    Route::get('/agent/properties/{id}', 'AgentProperties')->name('agent.properties');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/user/profile', [UserController::class, 'UserProfile'])->name('user.profile');
    Route::post('/user/profile/store', [UserController::class, 'UserProfileStore'])->name('user.profile.store');
    Route::get('/user/logout', [UserController::class, 'UserLogout'])->name('user.logout');
    Route::get('/user/change/password', [UserController::class, 'UserChangePassword'])->name('user.change.passwore');
    Route::post('/user/password/update', [UserController::class, 'UserPasswordUpdate'])->name('user.password.update');
});

require __DIR__.'/auth.php';

// Start Group Admin Middleware
Route::middleware(['auth', 'role:admin'])->group(function(){
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
    Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
    Route::post('/admin/update/password', [AdminController::class, 'AdminUpdatePassword'])->name('admin.update.password');

}); // End Group Admin Middleware

// Start Group Agent Middleware
Route::middleware(['auth', 'role:agent'])->group(function(){
    Route::get('/agent/dashboard', [AgentController::class, 'AgentDashboard'])->name('agent.dashboard');

}); // End Group Agent Middleware

Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login');

// Start Group Admin Middleware
Route::middleware(['auth', 'role:admin'])->group(function(){
    
    //Property Type All Route -> Group Controller
    Route::controller(PropertyTypeController::class)->group(function(){
        Route::get('/all/type', 'AllType')->name('all.type');
        Route::get('/add/type', 'AddType')->name('add.type');
        Route::post('/store/type', 'StoreType')->name('store.type');
        Route::get('/edit/type/{id}', 'EditType')->name('edit.type');
        Route::post('/update/type', 'UpdateType')->name('update.type');
        Route::get('/delete/type/{id}', 'DeleteType')->name('delete.type');
    });

    //Amenities All Route -> Group Controller
    Route::controller(PropertyTypeController::class)->group(function(){
        Route::get('/all/amenitie', 'AllAmenitie')->name('all.amenitie');
        Route::get('/add/amenitie', 'AddAmenitie')->name('add.amenitie');
        Route::post('/store/type', 'StoreType')->name('store.type');
        Route::get('/edit/type/{id}', 'EditType')->name('edit.type');
        Route::post('/update/type', 'UpdateType')->name('update.type');
        Route::get('/delete/type/{id}', 'DeleteType')->name('delete.type');
    });

    //Property All Route -> Group Controller
    Route::controller(PropertyController::class)->group(function(){
        // Affichage et création de propriétés
        Route::get('/all/property', 'AllProperty')->name('all.property');
        Route::get('/add/property', 'AddProperty')->name('add.property');
        Route::post('/store/property', 'StoreProperty')->name('store.property');
        
        // Modification de propriétés
        Route::get('/edit/property/{id}', 'EditProperty')->name('edit.property');
        Route::post('/update/property', 'UpdateProperty')->name('update.property');
        
        // Mise à jour de l'image principale
        Route::post('/update/property/thumbnail', 'UpdatePropertyThumbnail')->name('update.property.thumbnail');
        
        // Mise à jour des aménités
        Route::post('/update/property/amenities', 'UpdatePropertyAmenities')->name('update.property.amenities');
        
        // Suppression de propriété
        Route::get('/delete/property/{id}', 'DeleteProperty')->name('delete.property');
        
        // Changement de statut (actif/inactif)
        Route::get('/change/status/property/{id}', 'ChangePropertyStatus')->name('change.status.property');
    });

}); // End Group Admin Middleware