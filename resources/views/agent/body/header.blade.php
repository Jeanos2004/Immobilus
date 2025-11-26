<!-- partial:partials/_navbar.html -->
<nav class="navbar">
  <a href="#" class="sidebar-toggler">
    <i data-feather="menu"></i>
  </a>
  <div class="navbar-content">
    <form class="search-form">
      <div class="input-group">
        <div class="input-group-text">
          <i data-feather="search"></i>
        </div>
        <input type="text" class="form-control" id="navbarForm" placeholder="Rechercher...">
      </div>
    </form>
    <ul class="navbar-nav">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="flag-icon flag-icon-fr mt-1" title="fr"></i> <span class="ms-1 me-1 d-none d-md-inline-block">Français</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="languageDropdown">
          <a href="{{ route('lang.switch', 'fr') }}" class="dropdown-item py-2"><i class="flag-icon flag-icon-fr" title="fr" id="fr"></i> <span class="ms-1"> Français </span></a>
          <a href="{{ route('lang.switch', 'en') }}" class="dropdown-item py-2"><i class="flag-icon flag-icon-us" title="us" id="us"></i> <span class="ms-1"> English </span></a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i data-feather="bell"></i>
          <div class="indicator">
            <div class="circle"></div>
          </div>
        </a>
        <div class="dropdown-menu p-0" aria-labelledby="notificationDropdown">
          <div class="d-flex align-items-center justify-content-between py-2 px-3">
            <div>
              <h6 class="mb-0">Notifications</h6>
            </div>
            <div class="dropdown-menu-right">
              <a href="#" class="text-muted">Tout marquer comme lu</a>
            </div>
          </div>
          <div class="p-1">
            <div class="d-flex align-items-center py-2 px-2">
              <div class="me-3">
                <i data-feather="calendar" class="text-primary icon-lg"></i>
              </div>
              <div>
                <h6 class="mb-1">Nouveau rendez-vous</h6>
                <p class="text-muted mb-0">Vous avez un nouveau rendez-vous</p>
                <p class="text-muted mb-0 small">10 min ago</p>
              </div>
            </div>
          </div>
          <div class="p-1 border-top">
            <a href="#" class="dropdown-item d-flex align-items-center justify-content-center fw-bold">
              Voir toutes les notifications
            </a>
          </div>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <img class="wd-30 ht-30 rounded-circle" src="{{ (!empty(Auth::user()->photo)) ? url('upload/agent_images/'.Auth::user()->photo) : url('upload/no_image.jpg') }}" alt="profile">
        </a>
        <div class="dropdown-menu p-0" aria-labelledby="profileDropdown">
          <div class="d-flex flex-column align-items-center border-bottom px-5 py-3">
            <div class="mb-3">
              <img class="wd-80 ht-80 rounded-circle" src="{{ (!empty(Auth::user()->photo)) ? url('upload/agent_images/'.Auth::user()->photo) : url('upload/no_image.jpg') }}" alt="">
            </div>
            <div class="text-center">
              <p class="tx-16 fw-bolder">{{ Auth::user()->name }}</p>
              <p class="tx-12 text-muted">{{ Auth::user()->email }}</p>
            </div>
          </div>
          <ul class="list-unstyled p-1">
            <li class="dropdown-item py-2">
              <a href="{{ route('user.profile') }}" class="text-body ms-0">
                <i class="me-2 icon-md" data-feather="user"></i>
                <span>Profil</span>
              </a>
            </li>
            <li class="dropdown-item py-2">
              <a href="{{ route('user.profile') }}" class="text-body ms-0">
                <i class="me-2 icon-md" data-feather="edit"></i>
                <span>Modifier profil</span>
              </a>
            </li>
            <li class="dropdown-item py-2">
              <a href="{{ route('user.change.passwore') }}" class="text-body ms-0">
                <i class="me-2 icon-md" data-feather="repeat"></i>
                <span>Changer mot de passe</span>
              </a>
            </li>
            <li class="dropdown-item py-2">
              <a href="{{ route('user.logout') }}" class="text-body ms-0">
                <i class="me-2 icon-md" data-feather="log-out"></i>
                <span>Déconnexion</span>
              </a>
            </li>
          </ul>
        </div>
      </li>
    </ul>
  </div>
</nav>
<!-- partial -->
