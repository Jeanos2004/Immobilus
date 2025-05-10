@extends('frontend.frontend_dashboard')
@section('content')

<!-- page-title -->
<section class="page-title centred">
    <div class="title-outer">
        <div class="content-box">
            <h1>{{ __('messages.agent_details') }}</h1>
            <ul class="bread-crumb clearfix">
                <li><a href="{{ route('homepage') }}">{{ __('messages.home') }}</a></li>
                <li><a href="{{ route('agents.list') }}">{{ __('messages.agents') }}</a></li>
                <li>{{ $agent->name }}</li>
            </ul>
        </div>
    </div>
</section>
<!-- page-title end -->

<!-- agent-details -->
<section class="agent-details">
    <div class="auto-container">
        <div class="agent-details-content">
            <div class="agents-block-one">
                <div class="inner-box">
                    <div class="image-box">
                        @if(!empty($agent->photo))
                            <figure class="image"><img src="{{ asset($agent->photo) }}" alt="{{ $agent->name }}"></figure>
                        @else
                            <figure class="image"><img src="{{ asset('frontend/assets/images/team/team-1.jpg') }}" alt="{{ $agent->name }}"></figure>
                        @endif
                    </div>
                    <div class="content-box">
                        <div class="upper clearfix">
                            <div class="title-inner pull-left">
                                <h4>{{ $agent->name }}</h4>
                                <span class="designation">{{ __('messages.real_estate_agent') }}</span>
                            </div>
                            <ul class="social-list pull-right clearfix">
                                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                            </ul>
                        </div>
                        <div class="text">
                            <p>{{ $agent->address ?? __('messages.no_address_provided') }}</p>
                        </div>
                        <ul class="info clearfix">
                            <li><i class="fab fa-whatsapp"></i><a href="tel:{{ $agent->phone }}">{{ $agent->phone }}</a></li>
                            <li><i class="fas fa-envelope"></i><a href="mailto:{{ $agent->email }}">{{ $agent->email }}</a></li>
                        </ul>
                        <div class="btn-box">
                            <a href="#contact-agent" class="theme-btn btn-one">{{ __('messages.contact_agent') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- agent-details end -->

<!-- agents-page-section -->
<section class="agents-page-section agent-details-page">
    <div class="auto-container">
        <div class="row clearfix">
            <div class="col-lg-8 col-md-12 col-sm-12 content-side">
                <div class="agents-content-side tabs-box">
                    <div class="group-title">
                        <h3>{{ __('messages.agent_listings') }}</h3>
                    </div>
                    <div class="item-shorting clearfix">
                        <div class="left-column pull-left">
                            <h5>{{ __('messages.showing_results', ['count' => $properties->count(), 'total' => $properties->total()]) }}</h5>
                        </div>
                        <div class="right-column pull-right clearfix">
                            <div class="short-box clearfix">
                                <div class="select-box">
                                    <select class="wide">
                                        <option data-display="{{ __('messages.sort_by_default') }}">{{ __('messages.sort_by_default') }}</option>
                                        <option value="1">{{ __('messages.sort_by_price_low') }}</option>
                                        <option value="2">{{ __('messages.sort_by_price_high') }}</option>
                                        <option value="3">{{ __('messages.sort_by_date') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="short-menu clearfix">
                                <button class="list-view"><i class="icon-35"></i></button>
                                <button class="grid-view on"><i class="icon-36"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="tabs-content">
                        <div class="tab active-tab" id="tab-1">
                            <div class="wrapper grid">
                                <div class="row clearfix">
                                    @if(count($properties) > 0)
                                        @foreach($properties as $property)
                                        <div class="col-lg-6 col-md-6 col-sm-12 feature-block">
                                            <div class="feature-block-one">
                                                <div class="inner-box">
                                                    <div class="image-box">
                                                        <figure class="image"><img src="{{ asset($property->property_thumbnail) }}" alt="{{ $property->property_name }}"></figure>
                                                        <div class="batch"><i class="icon-11"></i></div>
                                                        <span class="category">{{ $property->type->type_name }}</span>
                                                    </div>
                                                    <div class="lower-content">
                                                        <div class="title-text"><h4><a href="{{ route('property.details', [$property->id, $property->property_slug]) }}">{{ $property->property_name }}</a></h4></div>
                                                        <div class="price-box clearfix">
                                                            <div class="price-info pull-left">
                                                                <h6>{{ __('messages.starting_from') }}</h6>
                                                                <h4>{{ number_format($property->lowest_price, 0, ',', ' ') }} €</h4>
                                                            </div>
                                                            <ul class="other-option pull-right clearfix">
                                                                <li><a href="javascript:void(0)" onclick="addToFavorite({{ $property->id }})"><i class="icon-12"></i></a></li>
                                                                <li><a href="{{ route('property.details', [$property->id, $property->property_slug]) }}"><i class="icon-13"></i></a></li>
                                                            </ul>
                                                        </div>
                                                        <ul class="more-details clearfix">
                                                            <li><i class="icon-14"></i>{{ $property->bedrooms }} {{ __('messages.beds') }}</li>
                                                            <li><i class="icon-15"></i>{{ $property->bathrooms }} {{ __('messages.baths') }}</li>
                                                            <li><i class="icon-16"></i>{{ $property->property_size }} {{ __('messages.sqm') }}</li>
                                                        </ul>
                                                        <div class="btn-box"><a href="{{ route('property.details', [$property->id, $property->property_slug]) }}" class="theme-btn btn-two">{{ __('messages.see_details') }}</a></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    @else
                                        <div class="col-12">
                                            <div class="no-results">
                                                <p>{{ __('messages.no_properties_found') }}</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pagination-wrapper">
                        {{ $properties->links('vendor.pagination.custom') }}
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12 sidebar-side">
                <div class="agents-sidebar">
                    <div class="form-widget sidebar-widget" id="contact-agent">
                        <div class="widget-title">
                            <h5>{{ __('messages.contact_agent') }}</h5>
                        </div>
                        <div class="form-inner">
                            <form method="post" action="{{ route('send.message') }}" class="default-form">
                                @csrf
                                <input type="hidden" name="agent_id" value="{{ $agent->id }}">
                                <div class="form-group">
                                    <input type="text" name="name" placeholder="{{ __('messages.your_name') }}" required="">
                                </div>
                                <div class="form-group">
                                    <input type="email" name="email" placeholder="{{ __('messages.your_email') }}" required="">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="phone" placeholder="{{ __('messages.phone') }}" required="">
                                </div>
                                <div class="form-group">
                                    <textarea name="message" placeholder="{{ __('messages.message') }}"></textarea>
                                </div>
                                <div class="form-group message-btn">
                                    <button type="submit" class="theme-btn btn-one">{{ __('messages.send_message') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="category-widget sidebar-widget">
                        <div class="widget-title">
                            <h5>{{ __('messages.property_status') }}</h5>
                        </div>
                        <ul class="category-list clearfix">
                            <li><a href="{{ route('agent.properties', $agent->id) }}">{{ __('messages.all_properties') }} <span>({{ App\Models\Property::where('agent_id', $agent->id)->count() }})</span></a></li>
                            <li><a href="{{ route('agent.properties', ['id' => $agent->id, 'status' => 'for-sale']) }}">{{ __('messages.for_sale') }} <span>({{ App\Models\Property::where('agent_id', $agent->id)->where('property_status', 'for-sale')->count() }})</span></a></li>
                            <li><a href="{{ route('agent.properties', ['id' => $agent->id, 'status' => 'for-rent']) }}">{{ __('messages.for_rent') }} <span>({{ App\Models\Property::where('agent_id', $agent->id)->where('property_status', 'for-rent')->count() }})</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- agents-page-section end -->

@endsection

@section('scripts')
<script>
    // Function to add a property to favorites
    function addToFavorite(propertyId) {
        $.ajax({
            url: "{{ route('add.to.wishlist') }}",
            type: "POST",
            data: {
                property_id: propertyId,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                // Show success message
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });

                if (response.success) {
                    Toast.fire({
                        icon: 'success',
                        title: response.message
                    });
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: response.message
                    });
                }
            }
        });
    }
</script>
@endsection
