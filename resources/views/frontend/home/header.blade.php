<header class="main-header">
    <!-- header-top -->
    <div class="header-top">
        <div class="top-inner clearfix">
            <div class="left-column pull-left">
                <ul class="info clearfix">
                    <li><i class="far fa-map-marker-alt"></i>Discover St, New York, NY 10012, USA</li>
                    <li><i class="far fa-clock"></i>Mon - Sat  9.00 - 18.00</li>
                    <li><i class="far fa-phone"></i><a href="tel:2512353256">+251-235-3256</a></li>
                </ul>
            </div>
            <div class="right-column pull-right">
                <!-- Sélecteur de langue -->
                <div class="language-selector" style="display: inline-block; margin-right: 15px;">
                    <a href="{{ route('lang.switch', 'fr') }}" style="margin-right: 10px; color: {{ app()->getLocale() == 'fr' ? '#2dbe6c' : '#a19a9a' }};">FR</a>
                    <a href="{{ route('lang.switch', 'en') }}" style="color: {{ app()->getLocale() == 'en' ? '#2dbe6c' : '#a19a9a' }};">EN</a>
                </div>
                <ul class="social-links clearfix">
                    <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                    <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                    <li><a href="#"><i class="fab fa-pinterest-p"></i></a></li>
                    <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                    <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                </ul>
                @auth
                    <div class="sign-box">
                        <a href="{{ route('dashboard') }}"><i class="fas fa-user"></i>{{ __('messages.dashboard') }}</a>
                        <a href="{{ route('user.wishlist') }}"><i class="fas fa-heart"></i>Mes favoris</a>
                        <a href="{{ route('compare.properties') }}"><i class="fas fa-exchange-alt"></i>Comparer
                            @php
                                $compareCount = session()->get('compare_list') ? count(session()->get('compare_list')) : 0;
                            @endphp
                            @if($compareCount > 0)
                                <span class="badge badge-pill badge-primary compare-count" style="font-size: 0.6em; position: relative; top: -8px; left: -5px;">{{ $compareCount }}</span>
                            @else
                                <span class="badge badge-pill badge-primary compare-count d-none" style="font-size: 0.6em; position: relative; top: -8px; left: -5px;">0</span>
                            @endif
                        </a>
                        <a href="{{ route('user.inbox') }}"><i class="fas fa-envelope"></i>Messagerie</a>
                        <a href="{{ route('all.notifications') }}">
                            <i class="fas fa-bell"></i>Notifications
                            @php
                                $notificationCount = auth()->user()->unreadNotifications()->count();
                            @endphp
                            @if($notificationCount > 0)
                                <span class="badge badge-pill badge-danger" style="font-size: 0.6em; position: relative; top: -8px; left: -5px;">{{ $notificationCount }}</span>
                            @endif
                        </a>
                        <a href="{{ route('user.logout') }}"><i class="fas fa-sign-out-alt"></i>{{ __('messages.logout') }}</a>
                    </div>
                @else
                    <div class="sign-box">
                        <a href="{{ route('login') }}"><i class="fas fa-user"></i>{{ __('messages.login') }}</a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
    <!-- header-lower -->
    <div class="header-lower">
    <div class="outer-box">
    <div class="main-box">
    <div class="logo-box">
        <figure class="logo"><a href="/"><img src="{{ asset('frontend/assets') }}/images/logo.png" alt="Immobilus"></a></figure>
    </div>
    <div class="menu-area clearfix">
        <!--Mobile Navigation Toggler-->
        <div class="mobile-nav-toggler">
            <i class="icon-bar"></i>
            <i class="icon-bar"></i>
            <i class="icon-bar"></i>
        </div>
        <nav class="main-menu navbar-expand-md navbar-light">
            <div class="collapse navbar-collapse show clearfix" id="navbarSupportedContent">
                <ul class="navigation clearfix">
                    <li class="{{ Request::is('/') ? 'current' : '' }}"><a href="{{ route('homepage') }}"><span>{{ __('messages.home') }}</span></a>
                        <ul>
                            <li><a href="{{ route('homepage') }}">{{ __('messages.main_home') }}</a></li>
                        </ul>
                    </li>
                    <li class="dropdown {{ Request::is('agents*') ? 'current' : '' }}"><a href="#"><span>{{ __('messages.agents') }}</span></a>
                        <ul>
                            <li><a href="{{ route('agents.list') }}">{{ __('messages.agents_list') }}</a></li>
                            <li><a href="{{ route('agents.grid') }}">{{ __('messages.agents_grid') }}</a></li>
                            <li><a href="{{ route('agents.list') }}">{{ __('messages.agent_details') }}</a></li>
                        </ul>
                    </li> 
                    <li class="dropdown {{ Request::is('property*') ? 'current' : '' }}"><a href="#"><span>{{ __('messages.properties') }}</span></a>
                        <ul>
                            <li><a href="{{ route('property.list') }}">{{ __('messages.property_list') }}</a></li>
                            <li><a href="{{ route('property.grid') }}">{{ __('messages.property_grid') }}</a></li>
                            <li><a href="{{ route('property.list') }}">{{ __('messages.property_list_full') }}</a></li>
                            <li><a href="{{ route('property.grid') }}">{{ __('messages.property_grid_full') }}</a></li>
                            <li><a href="{{ route('property.map') }}">Carte interactive</a></li>
                            <li><a href="{{ route('recommendations') }}">Recommandations personnalisées</a></li>
                        </ul>
                    </li>
                    <li class="dropdown"><a href="#"><span>{{ __('messages.pages') }}</span></a>
                        <div class="megamenu">
                            <div class="row clearfix">
                                <div class="col-xl-4 column">
                                    <ul>
                                        <li><h4>Pages</h4></li>
                                        <li><a href="about.html">About Us</a></li>
                                        <li><a href="services.html">Our Services</a></li>
                                        <li><a href="faq.html">Faq's Page</a></li>
                                        <li><a href="pricing.html">Pricing Table</a></li>
                                        <li><a href="compare-roperties.html">Compare Properties</a></li>
                                        <li><a href="categories.html">Categories Page</a></li>
                                        <li><a href="career.html">Career Opportunity</a></li>
                                        <li><a href="testimonials.html">Testimonials</a></li>
                                    </ul>
                                </div>
                                <div class="col-xl-4 column">
                                    <ul>
                                        <li><h4>Pages</h4></li>
                                        <li><a href="gallery.html">Our Gallery</a></li>
                                        <li><a href="profile.html">My Profile</a></li>
                                        <li><a href="signin.html">Sign In</a></li>
                                        <li><a href="signup.html">Sign Up</a></li>
                                        <li><a href="error.html">404</a></li>
                                        <li><a href="{{ route('agents.list') }}">{{ __('messages.agents_list') }}</a></li>
                                        <li><a href="{{ route('agents.grid') }}">{{ __('messages.agents_grid') }}</a></li>
                                        <li><a href="{{ route('agents.list') }}">{{ __('messages.agent_details') }}</a></li>
                                    </ul>
                                </div>
                                <div class="col-xl-4 column">
                                    <ul>
                                        <li><h4>Pages</h4></li>
                                        <li><a href="blog-1.html">Blog 01</a></li>
                                        <li><a href="blog-2.html">Blog 02</a></li>
                                        <li><a href="blog-3.html">Blog 03</a></li>
                                        <li><a href="blog-details.html">Blog Details</a></li>
                                        <li><a href="agency-list.html">Agency List</a></li>
                                        <li><a href="agency-grid.html">Agency Grid</a></li>
                                        <li><a href="agency-details.html">Agency Details</a></li>
                                        <li><a href="contact.html">Contact Us</a></li>
                                    </ul>
                                </div>                                   
                            </div>                                        
                        </div>
                    </li> 
                    <li class="dropdown {{ Request::is('agency*') ? 'current' : '' }}"><a href="#"><span>{{ __('messages.agency') }}</span></a>
                        <ul>
                            <li><a href="{{ route('property.list') }}">{{ __('messages.agency_list') }}</a></li>
                            <li><a href="{{ route('property.grid') }}">{{ __('messages.agency_grid') }}</a></li>
                        </ul>
                    </li>
                    <li class="dropdown {{ Request::is('blog*') ? 'current' : '' }}"><a href="#"><span>{{ __('messages.blog') }}</span></a>
                        <ul>
                            <li><a href="{{ route('homepage') }}">{{ __('messages.blog_list') }}</a></li>
                            <li><a href="{{ route('homepage') }}">{{ __('messages.blog_details') }}</a></li>
                        </ul>
                    </li>  
                    <li class="{{ Request::is('contact') ? 'current' : '' }}"><a href="{{ route('contact') }}"><span>{{ __('messages.contact') }}</span></a></li>   
                </ul>
            </div>
        </nav>
    </div>
    <div class="btn-box">
        <a href="{{ auth()->check() && auth()->user()->role == 'agent' ? route('agent.dashboard') : route('login') }}" class="theme-btn btn-one"><span>+</span>{{ __('messages.add_listing') }}</a>
    </div>
    </div>
    </div>
    </div>

    <!--sticky Header-->
    <div class="sticky-header">
        <div class="outer-box">
            <div class="main-box">
                <div class="logo-box">
                    <figure class="logo"><a href="/"><img src="{{ asset('frontend/assets') }}/images/logo.png" alt="Immobilus"></a></figure>
                </div>
                <div class="menu-area clearfix">
                    <nav class="main-menu clearfix">
                        <!--Keep This Empty / Menu will come through Javascript-->
                    </nav>
                </div>
                <div class="btn-box">
                    <a href="{{ auth()->check() && auth()->user()->role == 'agent' ? route('agent.dashboard') : route('login') }}" class="theme-btn btn-one"><span>+</span>{{ __('messages.add_listing') }}</a>
                </div>
            </div>
        </div>
    </div>
</header>