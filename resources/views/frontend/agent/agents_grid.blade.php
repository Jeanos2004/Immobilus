@extends('frontend.frontend_dashboard')
@section('content')

<!-- page-title -->
<section class="page-title centred">
    <div class="title-outer">
        <div class="content-box">
            <h1>{{ __('messages.agents_grid') }}</h1>
            <ul class="bread-crumb clearfix">
                <li><a href="{{ route('homepage') }}">{{ __('messages.home') }}</a></li>
                <li>{{ __('messages.agents_grid') }}</li>
            </ul>
        </div>
    </div>
</section>
<!-- page-title end -->

<!-- agents-page-section -->
<section class="agents-page-section">
    <div class="auto-container">
        <div class="row clearfix">
            <div class="col-lg-8 col-md-12 col-sm-12 content-side">
                <div class="agents-content-side">
                    <div class="item-shorting clearfix">
                        <div class="left-column pull-left">
                            <h5>{{ __('messages.showing_results', ['count' => $agents->count(), 'total' => $agents->total()]) }}</h5>
                        </div>
                        <div class="right-column pull-right clearfix">
                            <div class="short-box clearfix">
                                <div class="select-box">
                                    <select class="wide">
                                        <option data-display="{{ __('messages.sort_by_default') }}">{{ __('messages.sort_by_default') }}</option>
                                        <option value="1">{{ __('messages.sort_by_name') }}</option>
                                        <option value="2">{{ __('messages.sort_by_date') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="short-menu clearfix">
                                <button class="list-view"><i class="icon-35"></i></button>
                                <button class="grid-view on"><i class="icon-36"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="wrapper grid">
                        <div class="row clearfix">
                            @if(count($agents) > 0)
                                @foreach($agents as $agent)
                                <div class="col-lg-6 col-md-6 col-sm-12 agents-block">
                                    <div class="agents-block-two">
                                        <div class="inner-box">
                                            <div class="image-box">
                                                @if(!empty($agent->photo))
                                                    <figure class="image"><img src="{{ asset($agent->photo) }}" alt="{{ $agent->name }}"></figure>
                                                @else
                                                    <figure class="image"><img src="{{ asset('frontend/assets/images/team/team-1.jpg') }}" alt="{{ $agent->name }}"></figure>
                                                @endif
                                                <ul class="social-links clearfix">
                                                    <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                                    <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                                    <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                                </ul>
                                            </div>
                                            <div class="content-box">
                                                <div class="title-inner">
                                                    <h4><a href="{{ route('agents.details', $agent->id) }}">{{ $agent->name }}</a></h4>
                                                    <span class="designation">{{ __('messages.real_estate_agent') }}</span>
                                                </div>
                                                <div class="text">
                                                    <p>{{ $agent->address ?? __('messages.no_address_provided') }}</p>
                                                </div>
                                                <ul class="info clearfix">
                                                    <li><i class="fab fa-whatsapp"></i><a href="tel:{{ $agent->phone }}">{{ $agent->phone }}</a></li>
                                                    <li><i class="fas fa-envelope"></i><a href="mailto:{{ $agent->email }}">{{ $agent->email }}</a></li>
                                                </ul>
                                                <div class="btn-box">
                                                    <a href="{{ route('agents.details', $agent->id) }}" class="theme-btn btn-one">{{ __('messages.view_profile') }}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="col-12">
                                    <div class="no-results">
                                        <p>{{ __('messages.no_agents_found') }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="pagination-wrapper">
                        {{ $agents->links('vendor.pagination.custom') }}
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12 sidebar-side">
                <div class="agents-sidebar">
                    <div class="search-widget sidebar-widget">
                        <div class="widget-title">
                            <h5>{{ __('messages.search_agents') }}</h5>
                        </div>
                        <div class="search-inner">
                            <form action="{{ route('agents.grid') }}" method="get">
                                <div class="form-group">
                                    <input type="text" name="search" placeholder="{{ __('messages.search_by_name') }}" required="">
                                    <button type="submit"><i class="fas fa-search"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="category-widget sidebar-widget">
                        <div class="widget-title">
                            <h5>{{ __('messages.status') }}</h5>
                        </div>
                        <ul class="category-list clearfix">
                            <li><a href="{{ route('agents.grid') }}">{{ __('messages.all_agents') }} <span>({{ App\Models\User::where('role', 'agent')->count() }})</span></a></li>
                            <li><a href="{{ route('agents.grid', ['status' => 'active']) }}">{{ __('messages.active_agents') }} <span>({{ App\Models\User::where('role', 'agent')->where('status', 'active')->count() }})</span></a></li>
                            <li><a href="{{ route('agents.grid', ['status' => 'inactive']) }}">{{ __('messages.inactive_agents') }} <span>({{ App\Models\User::where('role', 'agent')->where('status', 'inactive')->count() }})</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- agents-page-section end -->

@endsection
