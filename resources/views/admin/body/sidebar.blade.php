<nav class="sidebar">
    <div class="sidebar-header">
      <a href="#" class="sidebar-brand">
        Immo<span>bilus</span>
      </a>
      <div class="sidebar-toggler not-active">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
    <div class="sidebar-body">
      <ul class="nav">
        <li class="nav-item nav-category">Main</li>
        <li class="nav-item">
          <a href="{{ route('admin.dashboard') }}" class="nav-link">
            <i class="link-icon" data-feather="box"></i>
            <span class="link-title">Dashboard</span>
          </a>
        </li>
        <li class="nav-item nav-category">Immobilus</li>
        
        <!-- Gestion des propriétés -->
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#properties" role="button" aria-expanded="false" aria-controls="properties">
            <i class="link-icon" data-feather="home"></i>
            <span class="link-title">Propriétés</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
          </a>
          <div class="collapse" id="properties">
            <ul class="nav sub-menu">
              <li class="nav-item">
                <a href="{{ route('all.property') }}" class="nav-link">Toutes les propriétés</a>
              </li>
              <li class="nav-item">
                <a href="{{ route('add.property') }}" class="nav-link">Ajouter une propriété</a>
              </li>
            </ul>
          </div>
        </li>
        
        <!-- Types de propriétés -->
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#propertyTypes" role="button" aria-expanded="false" aria-controls="propertyTypes">
            <i class="link-icon" data-feather="layers"></i>
            <span class="link-title">Types de propriétés</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
          </a>
          <div class="collapse" id="propertyTypes">
            <ul class="nav sub-menu">
              <li class="nav-item">
                <a href="{{ route('all.type') }}" class="nav-link">Tous les types</a>
              </li>
              <li class="nav-item">
                <a href="{{ route('add.type') }}" class="nav-link">Ajouter un type</a>
              </li>
            </ul>
          </div>
        </li>

        <!-- Aménités -->
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#amenitie" role="button" aria-expanded="false" aria-controls="amenitie">
            <i class="link-icon" data-feather="check-square"></i>
            <span class="link-title">Aménités</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
          </a>
          <div class="collapse" id="amenitie">
            <ul class="nav sub-menu">
              <li class="nav-item">
                <a href="{{ route('all.amenitie') }}" class="nav-link">Toutes les aménités</a>
              </li>
              <li class="nav-item">
                <a href="{{ route('add.amenitie') }}" class="nav-link">Ajouter une aménité</a>
              </li>
            </ul>
          </div>
        </li>
        
        <!-- Gestion des utilisateurs -->
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#users" role="button" aria-expanded="false" aria-controls="users">
            <i class="link-icon" data-feather="users"></i>
            <span class="link-title">Utilisateurs</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
          </a>
          <div class="collapse" id="users">
            <ul class="nav sub-menu">
              <li class="nav-item">
                <a href="#" class="nav-link">Administrateurs</a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">Agents</a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">Utilisateurs</a>
              </li>
            </ul>
          </div>
        </li>

        <!-- Avis et notes -->
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#reviews" role="button" aria-expanded="false" aria-controls="reviews">
            <i class="link-icon" data-feather="star"></i>
            <span class="link-title">Avis & Notes</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
          </a>
          <div class="collapse" id="reviews">
            <ul class="nav sub-menu">
              <li class="nav-item">
                <a href="{{ route('all.reviews') }}" class="nav-link">Tous les avis</a>
              </li>
              <li class="nav-item">
                <a href="{{ route('review.approve', 0) }}" class="nav-link">Approuver un avis</a>
              </li>
              <li class="nav-item">
                <a href="{{ route('review.reject', 0) }}" class="nav-link">Rejeter un avis</a>
              </li>
            </ul>
          </div>
        </li>
        
        <!-- Messagerie -->
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#messages" role="button" aria-expanded="false" aria-controls="messages">
            <i class="link-icon" data-feather="message-square"></i>
            <span class="link-title">Messagerie</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
          </a>
          <div class="collapse" id="messages">
            <ul class="nav sub-menu">
              <li class="nav-item">
                <a href="{{ route('admin.all.messages') }}" class="nav-link">Tous les messages</a>
              </li>
            </ul>
          </div>
        </li>
        
        <!-- Favoris -->
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#favorites" role="button" aria-expanded="false" aria-controls="favorites">
            <i class="link-icon" data-feather="heart"></i>
            <span class="link-title">Favoris</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
          </a>
          <div class="collapse" id="favorites">
            <ul class="nav sub-menu">
              <li class="nav-item">
                <a href="{{ route('user.wishlist') }}" class="nav-link">Liste des favoris</a>
              </li>
            </ul>
          </div>
        </li>
        
        <!-- Rendez-vous -->
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#appointments" role="button" aria-expanded="false" aria-controls="appointments">
            <i class="link-icon" data-feather="calendar"></i>
            <span class="link-title">Rendez-vous</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
          </a>
          <div class="collapse" id="appointments">
            <ul class="nav sub-menu">
              <li class="nav-item">
                <a href="{{ route('all.appointments') }}" class="nav-link">Tous les rendez-vous</a>
              </li>
              <li class="nav-item">
                <a href="{{ route('pending.appointments') }}" class="nav-link">En attente</a>
              </li>
              <li class="nav-item">
                <a href="{{ route('confirmed.appointments') }}" class="nav-link">Confirmés</a>
              </li>
              <li class="nav-item">
                <a href="{{ route('cancelled.appointments') }}" class="nav-link">Annulés</a>
              </li>
              <li class="nav-item">
                <a href="{{ route('completed.appointments') }}" class="nav-link">Terminés</a>
              </li>
              <li class="nav-item">
                <a href="{{ route('appointment.statistics') }}" class="nav-link">Statistiques</a>
              </li>
            </ul>
          </div>
        </li>
        
        <!-- Gestion des utilisateurs -->
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#userManagement" role="button" aria-expanded="false" aria-controls="userManagement">
            <i class="link-icon" data-feather="users"></i>
            <span class="link-title">Gestion des utilisateurs</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
          </a>
          <div class="collapse" id="userManagement">
            <ul class="nav sub-menu">
              <li class="nav-item">
                <a href="{{ route('all.users') }}" class="nav-link">Tous les utilisateurs</a>
              </li>
              <li class="nav-item">
                <a href="{{ route('all.admins') }}" class="nav-link">Administrateurs</a>
              </li>
              <li class="nav-item">
                <a href="{{ route('all.agents') }}" class="nav-link">Agents immobiliers</a>
              </li>
              <li class="nav-item">
                <a href="{{ route('all.customers') }}" class="nav-link">Clients</a>
              </li>
              <li class="nav-item">
                <a href="{{ route('add.user') }}" class="nav-link">Ajouter un utilisateur</a>
              </li>
            </ul>
          </div>
        </li>
        
        <!-- Fonctionnalités à venir -->
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#comingSoon" role="button" aria-expanded="false" aria-controls="comingSoon">
            <i class="link-icon" data-feather="clock"></i>
            <span class="link-title">Prochainement</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
          </a>
          <div class="collapse" id="comingSoon">
            <ul class="nav sub-menu">
              <li class="nav-item">
                <a href="#" class="nav-link">Statistiques</a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">Rapports</a>
              </li>
            </ul>
          </div>
        </li>
        
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="link-icon" data-feather="calendar"></i>
            <span class="link-title">Calendrier</span>
          </a>
        </li>
        <li class="nav-item nav-category">Components</li>
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#uiComponents" role="button" aria-expanded="false" aria-controls="uiComponents">
            <i class="link-icon" data-feather="feather"></i>
            <span class="link-title">UI Kit</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
          </a>
          <div class="collapse" id="uiComponents">
            <ul class="nav sub-menu">
              <li class="nav-item">
                <a href="pages/ui-components/accordion.html" class="nav-link">Accordion</a>
              </li>
              <li class="nav-item">
                <a href="pages/ui-components/alerts.html" class="nav-link">Alerts</a>
              </li>
            </ul>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#advancedUI" role="button" aria-expanded="false" aria-controls="advancedUI">
            <i class="link-icon" data-feather="anchor"></i>
            <span class="link-title">Advanced UI</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
          </a>
          <div class="collapse" id="advancedUI">
            <ul class="nav sub-menu">
              <li class="nav-item">
                <a href="pages/advanced-ui/cropper.html" class="nav-link">Cropper</a>
              </li>
              <li class="nav-item">
                <a href="pages/advanced-ui/owl-carousel.html" class="nav-link">Owl carousel</a>
              </li>
            </ul>
          </div>
        </li>
        <li class="nav-item nav-category">Docs</li>
        <li class="nav-item">
          <a href="#" target="_blank" class="nav-link">
            <i class="link-icon" data-feather="hash"></i>
            <span class="link-title">Documentation</span>
          </a>
        </li>
      </ul>
    </div>
  </nav>
  