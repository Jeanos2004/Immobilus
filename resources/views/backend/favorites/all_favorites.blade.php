@extends('admin.admin_dashboard')
@section('content')

<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Propriétés mises en favoris</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Favoris</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Toutes les propriétés favorites des utilisateurs</h4>

                        <div class="table-responsive">
                            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Utilisateur</th>
                                        <th>Email</th>
                                        <th>Adresse utilisateur</th>
                                        <th>Propriété</th>
                                        <th>Adresse propriété</th>
                                        <th>Ville</th>
                                        <th>Date d'ajout</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($favorites as $index => $favorite)
                                        @if($favorite->user && $favorite->property)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $favorite->user->name }}</td>
                                                <td>{{ $favorite->user->email }}</td>
                                                <td>{{ $favorite->user->address ?? '—' }}</td>
                                                <td>
                                                    <a href="{{ route('property.details', [$favorite->property->id, $favorite->property->property_slug]) }}" target="_blank">
                                                        {{ $favorite->property->property_name }}
                                                    </a>
                                                </td>
                                                <td>{{ $favorite->property->address }}</td>
                                                <td>{{ $favorite->property->city }}</td>
                                                <td>{{ $favorite->created_at?->format('d/m/Y H:i') }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection


