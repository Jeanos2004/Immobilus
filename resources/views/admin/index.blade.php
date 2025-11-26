@extends('admin.admin_dashboard')
@php
    use Illuminate\Support\Str;
@endphp
@section('content')
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
      <h4 class="mb-3 mb-md-0">Bienvenue sur le tableau de bord Immobilus</h4>
      <p class="text-muted">Vue d'ensemble de votre plateforme immobilière</p>
    </div>
    <div class="d-flex align-items-center flex-wrap text-nowrap">
      <div class="input-group flatpickr wd-200 me-2 mb-2 mb-md-0" id="dashboardDate">
        <span class="input-group-text input-group-addon bg-transparent border-primary" data-toggle><i data-feather="calendar" class="text-primary"></i></span>
        <input type="text" class="form-control bg-transparent border-primary" placeholder="Sélectionner une date" data-input>
      </div>
      <button type="button" class="btn btn-outline-primary btn-icon-text me-2 mb-2 mb-md-0" onclick="window.print()">
        <i class="btn-icon-prepend" data-feather="printer"></i>
        Imprimer
      </button>
      <a href="{{ route('admin.dashboard.report') }}" class="btn btn-primary btn-icon-text mb-2 mb-md-0">
        <i class="btn-icon-prepend" data-feather="download-cloud"></i>
        Télécharger le rapport
      </a>
    </div>
  </div>

  <div class="row">
    <div class="col-12 col-xl-12 stretch-card">
      <div class="row flex-grow-1">
        <div class="col-md-3 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-baseline">
                <h6 class="card-title mb-0">Propriétés</h6>
                <div class="dropdown mb-2">
                  <a type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                  </a>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item d-flex align-items-center" href="{{ route('all.property') }}"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">Voir tout</span></a>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <h3 class="mb-2">{{ $totalProperties }}</h3>
                  <div class="d-flex align-items-baseline">
                    <p class="text-primary">
                      <span>Total des propriétés</span>
                      <i data-feather="home" class="icon-sm mb-1"></i>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-3 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-baseline">
                <h6 class="card-title mb-0">Agents</h6>
                <div class="dropdown mb-2">
                  <a type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                  </a>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <a class="dropdown-item d-flex align-items-center" href="{{ route('all.agents') }}"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">Voir tout</span></a>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <h3 class="mb-2">{{ $totalAgents }}</h3>
                  <div class="d-flex align-items-baseline">
                    <p class="text-success">
                      <span>Agents immobiliers</span>
                      <i data-feather="users" class="icon-sm mb-1"></i>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-3 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-baseline">
                <h6 class="card-title mb-0">Utilisateurs</h6>
                <div class="dropdown mb-2">
                  <a type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                  </a>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                    <a class="dropdown-item d-flex align-items-center" href="{{ route('all.users') }}"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">Voir tout</span></a>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <h3 class="mb-2">{{ $totalUsers }}</h3>
                  <div class="d-flex align-items-baseline">
                    <p class="text-info">
                      <span>Clients inscrits</span>
                      <i data-feather="user" class="icon-sm mb-1"></i>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-3 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-baseline">
                <h6 class="card-title mb-0">Rendez-vous</h6>
                <div class="dropdown mb-2">
                  <a type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                  </a>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                    <a class="dropdown-item d-flex align-items-center" href="{{ route('all.appointments') }}"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">Voir tout</span></a>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <h3 class="mb-2">{{ $totalAppointments }}</h3>
                  <div class="d-flex align-items-baseline">
                    <p class="text-warning">
                      <span>{{ $pendingAppointments }} en attente</span>
                      <i data-feather="calendar" class="icon-sm mb-1"></i>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div> <!-- row -->
  
  <!-- Deuxième rangée de statistiques -->
  <div class="row">
    <div class="col-12 col-xl-12 stretch-card">
      <div class="row flex-grow-1 justify-content-center">
        <div class="col-md-4 col-xl-3 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-baseline">
                <h6 class="card-title mb-0">Types de propriétés</h6>
                <div class="dropdown mb-2">
                  <a type="button" id="dropdownMenuButton4" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                  </a>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton4">
                    <a class="dropdown-item d-flex align-items-center" href="{{ route('all.type') }}"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">Voir tout</span></a>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <h3 class="mb-2">{{ $totalPropertyTypes }}</h3>
                  <div class="d-flex align-items-baseline">
                    <p class="text-secondary">
                      <span>Catégories</span>
                      <i data-feather="list" class="icon-sm mb-1"></i>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-xl-3 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-baseline">
                <h6 class="card-title mb-0">Commodités</h6>
                <div class="dropdown mb-2">
                  <a type="button" id="dropdownMenuButton5" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                  </a>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton5">
                    <a class="dropdown-item d-flex align-items-center" href="{{ route('all.amenitie') }}"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">Voir tout</span></a>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <h3 class="mb-2">{{ $totalAmenities }}</h3>
                  <div class="d-flex align-items-baseline">
                    <p class="text-danger">
                      <span>Équipements</span>
                      <i data-feather="check-square" class="icon-sm mb-1"></i>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div> <!-- row -->

  <div class="row">
    <div class="col-lg-7 col-xl-8 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-baseline mb-2">
            <h6 class="card-title mb-0">Propriétés récentes</h6>
            <div class="dropdown mb-2">
              <a type="button" id="dropdownMenuButton4" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
              </a>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton4">
                <a class="dropdown-item d-flex align-items-center" href="{{ route('all.property') }}"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">Voir toutes les propriétés</span></a>
              </div>
            </div>
          </div>
          <p class="text-muted">Les propriétés les plus récemment ajoutées dans le système.</p>
          <div class="table-responsive">
            <table class="table table-hover mb-0">
              <thead>
                <tr>
                  <th class="pt-0">ID</th>
                  <th class="pt-0">Nom</th>
                  <th class="pt-0">Type</th>
                  <th class="pt-0">Prix</th>
                  <th class="pt-0">Statut</th>
                  <th class="pt-0">Agent</th>
                </tr>
              </thead>
              <tbody id="recent-properties-tbody">
                @include('admin.partials.recent_properties_rows')
              </tbody>
            </table>
          </div>
        </div> 
      </div>
    </div>
    <div class="col-lg-5 col-xl-4 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-baseline mb-2">
            <h6 class="card-title mb-0">Types de propriétés</h6>
            <div class="dropdown mb-2">
              <a type="button" id="dropdownMenuButton5" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
              </a>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton5">
                <a class="dropdown-item d-flex align-items-center" href="{{ route('all.type') }}"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">Gérer les types</span></a>
              </div>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Type</th>
                  <th>Nombre</th>
                  <th>%</th>
                </tr>
              </thead>
              <tbody>
                @php
                  $totalProps = $totalProperties > 0 ? $totalProperties : 1; // Éviter division par zéro
                @endphp
                @forelse($propertyTypeStats as $type)
                <tr>
                  <td>{{ $type->type_name }}</td>
                  <td>{{ $type->properties_count }}</td>
                  <td>{{ round(($type->properties_count / $totalProps) * 100) }}%</td>
                </tr>
                @empty
                <tr>
                  <td colspan="3" class="text-center">Aucun type disponible</td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
          <div class="d-grid mt-3">
            <a href="{{ route('add.type') }}" class="btn btn-primary">Ajouter un type</a>
          </div>
        </div>
      </div>
    </div>
  </div> <!-- row -->

  <div class="row">
    <div class="col-lg-5 col-xl-4 grid-margin grid-margin-xl-0 stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-baseline mb-2">
            <h6 class="card-title mb-0">Top Agents</h6>
            <div class="dropdown mb-2">
              <a type="button" id="dropdownMenuButton6" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
              </a>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton6">
                <a class="dropdown-item d-flex align-items-center" href="{{ route('all.agents') }}"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">Voir tous les agents</span></a>
              </div>
            </div>
          </div>
          <div class="d-flex flex-column">
            @forelse($topAgents as $agent)
            <a href="{{ route('agents.details', $agent->id) }}" class="d-flex align-items-center border-bottom pb-3 {{ !$loop->last ? 'mb-3' : '' }}">
              <div class="me-3">
                @if($agent->photo)
                <img src="{{ asset($agent->photo) }}" class="rounded-circle wd-35" alt="agent">
                @else
                <img src="{{ asset('upload/no_image.jpg') }}" class="rounded-circle wd-35" alt="agent">
                @endif
              </div>
              <div class="w-100">
                <div class="d-flex justify-content-between">
                  <h6 class="text-body mb-2">{{ $agent->name }}</h6>
                  <p class="text-success tx-12">{{ $agent->properties_count }} propriétés</p>
                </div>
                <p class="text-muted tx-13">{{ $agent->email }}</p>
              </div>
            </a>
            @empty
            <p class="text-center text-muted">Aucun agent disponible</p>
            @endforelse
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-7 col-xl-8 stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-baseline mb-2">
            <h6 class="card-title mb-0">Rendez-vous récents</h6>
            <div class="dropdown mb-2">
              <a type="button" id="dropdownMenuButton7" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
              </a>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton7">
                <a class="dropdown-item d-flex align-items-center" href="{{ route('all.appointments') }}"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">Voir tous les rendez-vous</span></a>
              </div>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-hover mb-0">
              <thead>
                <tr>
                  <th class="pt-0">ID</th>
                  <th class="pt-0">Propriété</th>
                  <th class="pt-0">Client</th>
                  <th class="pt-0">Date</th>
                  <th class="pt-0">Heure</th>
                  <th class="pt-0">Statut</th>
                </tr>
              </thead>
              <tbody>
                @forelse($recentAppointments as $appointment)
                <tr>
                  <td>{{ $appointment->id }}</td>
                  <td>
                    @if(isset($appointment->property))
                    <a href="{{ route('property.details', [$appointment->property->id, Str::slug($appointment->property->property_name)]) }}" target="_blank">{{ $appointment->property->property_name }}</a>
                    @else
                    N/A
                    @endif
                  </td>
                  <td>
                    @if(isset($appointment->user))
                    {{ $appointment->user->name }}
                    @else
                    N/A
                    @endif
                  </td>
                  <td>{{ $appointment->appointment_date }}</td>
                  <td>{{ $appointment->appointment_time }}</td>
                  <td>
                    @if($appointment->status == 'confirmed')
                    <span class="badge bg-success">Confirmé</span>
                    @elseif($appointment->status == 'cancelled')
                    <span class="badge bg-danger">Annulé</span>
                    @else
                    <span class="badge bg-warning">En attente</span>
                    @endif
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="6" class="text-center">Aucun rendez-vous disponible</td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div> 
      </div>
    </div>
  </div> <!-- row -->
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  const tbody = document.getElementById('recent-properties-tbody');
  if (!tbody) return;

  async function refreshRecentProperties() {
    try {
      const response = await fetch("{{ route('admin.dashboard.recent-properties') }}", {
        headers: {'X-Requested-With': 'XMLHttpRequest'}
      });
      if (!response.ok) return;
      const html = await response.text();
      tbody.innerHTML = html;
    } catch (e) {
      console.error(e);
    }
  }

  // Rafraîchir toutes les 15 secondes
  setInterval(refreshRecentProperties, 15000);
});
</script>
@endpush