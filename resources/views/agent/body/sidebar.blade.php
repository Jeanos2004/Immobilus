<!-- partial:partials/_sidebar.html -->
<nav class="sidebar">
  <div class="sidebar-header">
    <a href="{{ route('agent.dashboard') }}" class="sidebar-brand">
      <img src="{{ asset('backend/assets/images/logo-light.png') }}" alt="logo" height="40">
    </a>
    <div class="sidebar-toggler not-active">
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div>
  <div class="sidebar-body">
    <ul class="nav">
      <li class="nav-item nav-category">Menu Principal</li>
      <li class="nav-item">
        <a href="{{ route('agent.dashboard') }}" class="nav-link">
          <i class="link-icon" data-feather="box"></i>
          <span class="link-title">Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#properties" role="button" aria-expanded="false" aria-controls="properties">
          <i class="link-icon" data-feather="home"></i>
          <span class="link-title">Propriétés</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse" id="properties">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="{{ route('agent.properties.all') }}" class="nav-link">Mes propriétés</a>
            </li>
            <li class="nav-item">
              <a href="{{ route('agent.property.add') }}" class="nav-link">Ajouter une propriété</a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#appointments" role="button" aria-expanded="false" aria-controls="appointments">
          <i class="link-icon" data-feather="calendar"></i>
          <span class="link-title">Rendez-vous</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse" id="appointments">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="{{ route('agent.appointments.all') }}" class="nav-link">Tous les rendez-vous</a>
            </li>
            <li class="nav-item">
              <a href="{{ route('agent.appointments.all') }}?status=pending" class="nav-link">En attente</a>
            </li>
            <li class="nav-item">
              <a href="{{ route('agent.appointments.all') }}?status=confirmed" class="nav-link">Confirmés</a>
            </li>
            <li class="nav-item">
              <a href="{{ route('agent.appointments.all') }}?status=completed" class="nav-link">Terminés</a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#messages" role="button" aria-expanded="false" aria-controls="messages">
          <i class="link-icon" data-feather="mail"></i>
          <span class="link-title">Messagerie</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse" id="messages">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="{{ route('agent.inbox') }}" class="nav-link">Boîte de réception</a>
            </li>
            <li class="nav-item">
              <a href="{{ route('agent.sent') }}" class="nav-link">Messages envoyés</a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#payments" role="button" aria-expanded="false" aria-controls="payments">
          <i class="link-icon" data-feather="credit-card"></i>
          <span class="link-title">Paiements</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse" id="payments">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="#" class="nav-link">Historique des paiements</a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">Paiements en attente</a>
            </li>
          </ul>
        </div>
      </li>
    </ul>
  </div>
</nav>
<!-- partial -->
