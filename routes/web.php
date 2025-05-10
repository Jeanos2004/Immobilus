<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\Backend\PropertyTypeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use \App\Http\Controllers\Backend\MultiImageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\PropertyController;
use \App\Http\Controllers\Backend\UserManagementController;

// Route::get('/', function () {
//     return view('welcome');
// });

// Routes pour le changement de langue
Route::get('/language/{locale}', [LanguageController::class, 'switchLang'])->name('lang.switch');

// User Frontend All Routes
Route::get('/', [UserController::class, 'Index'])->name('homepage');

// Routes pour les agents (frontend)
Route::controller(\App\Http\Controllers\Frontend\AgentController::class)->group(function(){
    Route::get('/agents', 'AgentsList')->name('agents.list');
    Route::get('/agents/grid', 'AgentsGrid')->name('agents.grid');
    Route::get('/agent/details/{id}', 'AgentDetails')->name('agents.details');
});

// Routes pour la page de contact
Route::get('/contact', [UserController::class, 'Contact'])->name('contact');
Route::post('/contact/submit', [\App\Http\Controllers\Frontend\ContactController::class, 'submitContactForm'])->name('contact.submit');

// Routes pour les propriétés (frontend)
Route::controller(\App\Http\Controllers\Frontend\PropertyController::class)->group(function(){
    Route::get('/properties', 'PropertyList')->name('property.list');
    Route::get('/properties/grid', 'PropertyGrid')->name('property.grid');
    Route::get('/property/details/{id}/{slug}', 'PropertyDetails')->name('property.details');
    Route::get('/property/search', 'PropertySearch')->name('property.search');
    Route::get('/property/type/{id}', 'PropertyByType')->name('property.type');
    Route::get('/agent/properties/{id}', 'AgentProperties')->name('agent.properties');
});

// Routes pour la carte interactive
Route::controller(\App\Http\Controllers\Frontend\MapController::class)->group(function(){
    Route::get('/properties/map', 'index')->name('property.map');
    Route::post('/properties/map/search-area', 'searchByArea')->name('property.map.search.area');
    Route::post('/properties/map/search-address', 'searchByAddress')->name('property.map.search.address');
});

// Routes pour les recommandations
Route::controller(\App\Http\Controllers\Frontend\RecommendationController::class)->group(function(){
    Route::get('/recommendations', 'index')->name('recommendations');
    Route::post('/track-property-view', 'trackPropertyView')->name('track.property.view');
});

// Routes pour les favoris (wishlist)
Route::controller(\App\Http\Controllers\Frontend\WishlistController::class)->group(function(){
    // Ajouter/Supprimer des favoris (AJAX)
    Route::post('/add-to-wishlist', 'AddToWishlist')->name('add.to.wishlist');
    // Afficher la liste des favoris (nécessite authentification)
    Route::get('/user/wishlist', 'WishlistIndex')->name('user.wishlist')->middleware('auth');
    // Supprimer un favori
    Route::get('/user/wishlist/remove/{id}', 'RemoveFromWishlist')->name('remove.wishlist')->middleware('auth');
});

// Routes pour les avis (reviews)
Route::controller(\App\Http\Controllers\Frontend\ReviewController::class)->group(function(){
    // Soumettre un avis (nécessite authentification)
    Route::post('/store-review', 'StoreReview')->name('store.review')->middleware('auth');
    
    // Répondre à un avis (agents et admins uniquement)
    Route::post('/reply-to-review', 'StoreReviewReply')->name('store.review.reply')->middleware('auth');
    Route::get('/delete-review-reply/{id}', 'DeleteReviewReply')->name('delete.review.reply')->middleware('auth');
    
    // Voter sur un avis (utile/non utile)
    Route::post('/vote-review', 'VoteReview')->name('vote.review')->middleware('auth');
    
    // Signaler un avis inapproprié
    Route::post('/report-review', 'ReportReview')->name('report.review')->middleware('auth');
});

// Routes pour les rendez-vous (frontend)
Route::controller(\App\Http\Controllers\Frontend\AppointmentController::class)->group(function(){
    // Formulaire de prise de rendez-vous
    Route::get('/book-appointment/{property_id}', 'BookAppointment')->name('book.appointment');
    // Enregistrer un rendez-vous
    Route::post('/store-appointment', 'StoreAppointment')->name('store.appointment')->middleware('auth');
    // Liste des rendez-vous de l'utilisateur
    Route::get('/user/appointments', 'UserAppointments')->name('user.appointments')->middleware('auth');
    // Annuler un rendez-vous
    Route::get('/cancel-appointment/{id}', 'CancelAppointment')->name('cancel.appointment')->middleware('auth');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profil utilisateur
    Route::get('/user/profile', [UserController::class, 'UserProfile'])->name('user.profile');
    Route::post('/user/profile/store', [UserController::class, 'UserProfileStore'])->name('user.profile.store');
    Route::get('/user/logout', [UserController::class, 'UserLogout'])->name('user.logout');
    Route::get('/user/change/password', [UserController::class, 'UserChangePassword'])->name('user.change.passwore');
    Route::post('/user/password/update', [UserController::class, 'UserPasswordUpdate'])->name('user.password.update');
    
    // Routes pour la messagerie utilisateur
    Route::controller(\App\Http\Controllers\Frontend\MessageController::class)->group(function(){
        // Envoyer un message
        Route::post('/send-message', 'SendMessage')->name('send.message');
        // Boîte de réception
        Route::get('/user/inbox', 'UserInbox')->name('user.inbox');
        // Messages envoyés
        Route::get('/user/sent', 'UserSent')->name('user.sent');
        // Voir un message
        Route::get('/message/view/{id}', 'ViewMessage')->name('message.view');
        // Répondre à un message
        Route::post('/message/reply', 'ReplyMessage')->name('message.reply');
        // Supprimer un message
        Route::get('/message/delete/{id}', 'DeleteMessage')->name('message.delete');
    });
});

require __DIR__.'/auth.php';

// Routes pour les rendez-vous (agent)
Route::middleware(['auth', 'role:agent'])->group(function () {
    Route::get('/agent/appointments', [AppointmentController::class, 'AgentAppointments'])->name('agent.appointments');
    Route::get('/agent/appointment/status/{id}/{status}', [AppointmentController::class, 'AgentChangeStatus'])->name('agent.appointment.status');
    
    // Statistiques des rendez-vous (agent)
    Route::get('/agent/appointment/statistics', [\App\Http\Controllers\Backend\AppointmentStatsController::class, 'agentStats'])->name('agent.appointment.statistics');
});

// Routes pour les notifications (accessibles à tous les utilisateurs authentifiés)
Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'AllNotifications'])->name('all.notifications');
    Route::get('/notification/mark-as-read/{id}', [\App\Http\Controllers\NotificationController::class, 'MarkAsRead'])->name('notification.mark.read');
    Route::get('/notification/mark-all-as-read', [\App\Http\Controllers\NotificationController::class, 'MarkAllAsRead'])->name('notification.mark.all.read');
    Route::get('/notification/delete/{id}', [\App\Http\Controllers\NotificationController::class, 'DeleteNotification'])->name('notification.delete');
    Route::get('/notification/delete-all', [\App\Http\Controllers\NotificationController::class, 'DeleteAllNotifications'])->name('notification.delete.all');
});

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
    
    // Routes pour la messagerie agent
    Route::controller(\App\Http\Controllers\Frontend\MessageController::class)->group(function(){
        // Boîte de réception
        Route::get('/agent/inbox', 'AgentInbox')->name('agent.inbox');
        // Messages envoyés
        Route::get('/agent/sent', 'AgentSent')->name('agent.sent');
        // Voir un message
        Route::get('/agent/message/view/{id}', 'AgentViewMessage')->name('agent.message.view');
        // Répondre à un message
        Route::post('/agent/message/reply', 'AgentReplyMessage')->name('agent.message.reply');
        // Supprimer un message
        Route::get('/agent/message/delete/{id}', 'AgentDeleteMessage')->name('agent.message.delete');
    });
    
    // Routes pour les rendez-vous (agent)
    Route::controller(\App\Http\Controllers\Frontend\AppointmentController::class)->group(function(){
        // Liste des rendez-vous de l'agent
        Route::get('/agent/appointments', 'AgentAppointments')->name('agent.appointments');
        // Changer le statut d'un rendez-vous
        Route::get('/agent/appointment/status/{id}/{status}', 'AgentChangeStatus')->name('agent.appointment.status');
    });

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
    Route::controller(\App\Http\Controllers\Backend\AmenityController::class)->group(function(){
        Route::get('/all/amenitie', 'AllAmenities')->name('all.amenitie');
        Route::get('/add/amenitie', 'AddAmenity')->name('add.amenitie');
        Route::post('/store/amenitie', 'StoreAmenity')->name('store.amenitie');
        Route::get('/edit/amenitie/{id}', 'EditAmenity')->name('edit.amenitie');
        Route::post('/update/amenitie', 'UpdateAmenity')->name('update.amenitie');
        Route::get('/delete/amenitie/{id}', 'DeleteAmenity')->name('delete.amenitie');
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
    
    // Gestion des images multiples pour les propriétés
    Route::controller(MultiImageController::class)->group(function(){
        // Affichage du formulaire d'ajout d'images
        Route::get('/property/multi/image/{id}', 'StoreMultiImage')->name('property.multi.image');
        // Enregistrement des nouvelles images
        Route::post('/store/multi/image', 'SaveMultiImage')->name('store.multi.image');
        // Suppression d'une image
        Route::get('/delete/multi/image/{id}', 'DeleteMultiImage')->name('delete.multi.image');
        // Mise à jour de l'ordre des images (fonctionnalité future)
        Route::post('/update/multi/image/order', 'UpdateMultiImageOrder')->name('update.multi.image.order');
    });
    
    // Gestion des avis pour l'administration
    Route::controller(\App\Http\Controllers\Frontend\ReviewController::class)->group(function(){
        // Affichage de tous les avis
        Route::get('/all/reviews', 'AdminAllReviews')->name('all.reviews');
        // Approuver un avis
        Route::get('/review/approve/{id}', 'ChangeReviewStatus')->name('review.approve');
        // Rejeter un avis
        Route::get('/review/reject/{id}', 'ChangeReviewStatus')->name('review.reject');
        // Supprimer un avis
        Route::get('/review/delete/{id}', 'DeleteReview')->name('review.delete');
        
        // Gestion des signalements d'avis
        Route::get('/review/reports', 'AdminAllReports')->name('admin.review.reports');
        Route::get('/review/report/{id}/status/{status}', 'ChangeReportStatus')->name('admin.report.status');
    });
    
    // Gestion des messages pour l'administration
    Route::controller(\App\Http\Controllers\Frontend\MessageController::class)->group(function(){
        // Affichage de tous les messages
        Route::get('/all/messages', 'AdminAllMessages')->name('admin.all.messages');
        // Voir un message
        Route::get('/message/view/{id}', 'AdminViewMessage')->name('admin.message.view');
        // Supprimer un message
        Route::get('/message/delete/{id}', 'AdminDeleteMessage')->name('admin.message.delete');
    });
    
    // Gestion des rendez-vous pour l'administration
    Route::controller(\App\Http\Controllers\Backend\AppointmentController::class)->group(function(){
        // Affichage de tous les rendez-vous
        Route::get('/all/appointments', 'AllAppointments')->name('all.appointments');
        // Rendez-vous en attente
        Route::get('/pending/appointments', 'PendingAppointments')->name('pending.appointments');
        // Rendez-vous confirmés
        Route::get('/confirmed/appointments', 'ConfirmedAppointments')->name('confirmed.appointments');
        // Rendez-vous annulés
        Route::get('/canceled/appointments', 'CanceledAppointments')->name('canceled.appointments');
        // Rendez-vous terminés
        Route::get('/completed/appointments', 'CompletedAppointments')->name('completed.appointments');
        // Changer le statut d'un rendez-vous
        Route::get('/change/status/appointment/{id}/{status}', 'ChangeStatus')->name('change.status.appointment');
        // Supprimer un rendez-vous
        Route::get('/delete/appointment/{id}', 'DeleteAppointment')->name('delete.appointment');
    });

    // Statistiques des rendez-vous (admin)
    Route::get('/appointment/statistics', [\App\Http\Controllers\Backend\AppointmentStatsController::class, 'index'])->name('appointment.statistics');
    
    // Gestion des témoignages
    Route::controller(\App\Http\Controllers\Backend\TestimonialController::class)->group(function(){
        Route::get('/all/testimonials', 'AllTestimonials')->name('all.testimonials');
        Route::get('/add/testimonial', 'AddTestimonial')->name('add.testimonial');
        Route::post('/store/testimonial', 'StoreTestimonial')->name('store.testimonial');
        Route::get('/edit/testimonial/{id}', 'EditTestimonial')->name('edit.testimonial');
        Route::post('/update/testimonial', 'UpdateTestimonial')->name('update.testimonial');
        Route::get('/delete/testimonial/{id}', 'DeleteTestimonial')->name('delete.testimonial');
        Route::get('/testimonial/status/{id}', 'ChangeTestimonialStatus')->name('testimonial.status');
    });
    
    // Routes pour la gestion des messages de contact
    Route::controller(\App\Http\Controllers\Backend\ContactMessageController::class)->group(function(){
        Route::get('/all/messages', 'AllMessages')->name('all.messages');
        Route::get('/message/view/{id}', 'ViewMessage')->name('admin.message.view');
        Route::get('/message/delete/{id}', 'DeleteMessage')->name('admin.message.delete');
    });
    
    // Gestion des utilisateurs (admin)
    Route::controller(UserManagementController::class)->group(function(){
        // Liste des utilisateurs
        Route::get('/all/users', 'AllUsers')->name('all.users');
        Route::get('/all/admins', 'AllAdmins')->name('all.admins');
        Route::get('/all/agents', 'AllAgents')->name('all.agents');
        Route::get('/all/customers', 'AllCustomers')->name('all.customers');
        
        // Ajout d'utilisateur
        Route::get('/add/user', 'AddUser')->name('add.user');
        Route::post('/store/user', 'StoreUser')->name('store.user');
        
        // Modification d'utilisateur
        Route::get('/edit/user/{id}', 'EditUser')->name('edit.user');
        Route::post('/update/user/{id}', 'UpdateUser')->name('update.user');
        
        // Détails d'utilisateur
        Route::get('/view/user/{id}', 'ViewUser')->name('view.user');
        
        // Suppression d'utilisateur
        Route::get('/delete/user/{id}', 'DeleteUser')->name('delete.user');
        
        // Changement de statut (actif/inactif)
        Route::get('/change/status/user/{id}', 'ChangeUserStatus')->name('change.status.user');
        
        // Changement de rôle
        Route::post('/change/role/user/{id}', 'ChangeUserRole')->name('change.role.user');
    });

}); // End Group Admin Middleware

Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login');

// Start Group Agent Middleware
Route::middleware(['auth', 'role:agent'])->group(function(){
    Route::get('/agent/dashboard', [AgentController::class, 'AgentDashboard'])->name('agent.dashboard');
    
    // Routes pour la messagerie agent
    Route::controller(\App\Http\Controllers\Frontend\MessageController::class)->group(function(){
        // Boîte de réception
        Route::get('/agent/inbox', 'AgentInbox')->name('agent.inbox');
        // Messages envoyés
        Route::get('/agent/sent', 'AgentSent')->name('agent.sent');
        // Voir un message
        Route::get('/agent/message/view/{id}', 'AgentViewMessage')->name('agent.message.view');
        // Répondre à un message
        Route::post('/agent/message/reply', 'AgentReplyMessage')->name('agent.message.reply');
        // Supprimer un message
        Route::get('/agent/message/delete/{id}', 'AgentDeleteMessage')->name('agent.message.delete');
    });
    
    // Routes pour les rendez-vous (agent)
    Route::controller(\App\Http\Controllers\Frontend\AppointmentController::class)->group(function(){
        // Liste des rendez-vous de l'agent
        Route::get('/agent/appointments', 'AgentAppointments')->name('agent.appointments');
        // Changer le statut d'un rendez-vous
        Route::get('/agent/appointment/status/{id}/{status}', 'AgentChangeStatus')->name('agent.appointment.status');
    });

}); // End Group Agent Middleware