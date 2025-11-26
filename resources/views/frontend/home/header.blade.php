<header class="main-header">
    <!-- header-top -->
    <div class="header-top">
        <div class="top-inner clearfix">
            <div class="left-column pull-left">
                <ul class="info clearfix">
                    <li><i class="far fa-map-marker-alt"></i>Decouvrez, Conakry, GUINEE</li>
                    <li><i class="far fa-clock"></i>Lun  - Sam  9.00 - 18.00</li>
                    <li><i class="far fa-phone"></i><a href="tel:2512353256">+224-622-33-33-33</a></li>
                </ul>
            </div>
            <div class="right-column pull-right">
                <!-- Sélecteur de langue (FR uniquement pour l'instant) -->
                <div class="language-selector" style="display: inline-block; margin-right: 15px;">
                    <a href="{{ route('lang.switch', 'fr') }}" style="margin-right: 10px; color: #6571ff;">FR</a>
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
                        <a href="{{ route('dashboard') }}"><i class="fas fa-user"></i>Tableau de bord</a>
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
                        <a href="{{ route('user.logout') }}"><i class="fas fa-sign-out-alt"></i>Déconnexion</a>
                    </div>
                @else
                    <div class="sign-box">
                        <a href="{{ route('login') }}"><i class="fas fa-user"></i>Connexion</a>
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
        <figure class="logo"><a href="/"><img src="{{ asset('backend/assets/images/logo-light.png') }}" alt="Immobilus" height="40"></a></figure>
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
                    <li class="{{ Request::is('/') ? 'current' : '' }}"><a href="{{ route('homepage') }}"><span>Accueil</span></a>
                        <ul>
                            <li><a href="{{ route('homepage') }}">Accueil Immobilus</a></li>
                        </ul>
                    </li>
                    <li class="dropdown {{ Request::is('agents*') ? 'current' : '' }}"><a href="#"><span>Agents</span></a>
                        <ul>
                            <li><a href="{{ route('agents.list') }}">Liste des agents</a></li>
                            <li><a href="{{ route('agents.grid') }}">Grille des agents</a></li>
                            <li><a href="{{ route('agents.list') }}">Détails d'agent</a></li>
                        </ul>
                    </li> 
                    <li class="dropdown {{ Request::is('property*') ? 'current' : '' }}"><a href="#"><span>Propriétés</span></a>
                        <ul>
                            <li><a href="{{ route('property.list') }}">Liste des propriétés</a></li>
                            <li><a href="{{ route('property.grid') }}">Grille des propriétés</a></li>
                            <li><a href="{{ route('property.list') }}">Liste complète</a></li>
                            <li><a href="{{ route('property.grid') }}">Grille complète</a></li>
                            {{-- Carte interactive et recommandations supprimées pour simplifier le menu --}}
                        </ul>
                    </li>
                    <li class="dropdown"><a href="#"><span>Pages</span></a>
                        <div class="megamenu">
                            <div class="row clearfix">
                                <div class="col-xl-4 column">
                                    <ul>
                                        <li><h4>{{ __('Pages') }}</h4></li>
                                        <li><a href="{{ route('about') }}">{{ __('À propos de nous') }}</a></li>
                                        <li><a href="{{ route('faq') }}">{{ __('FAQ') }}</a></li>
                                        <li><a href="{{ route('privacy.policy') }}">{{ __('Politique de confidentialité') }}</a></li>
                                        <li><a href="{{ route('terms.service') }}">{{ __('Conditions d\'utilisation') }}</a></li>
                                        <li><a href="{{ route('compare.properties') }}">{{ __('Comparer des propriétés') }}</a></li>
                                        <li><a href="{{ route('mortgage.calculator') }}">{{ __('Calculatrice de prêt') }}</a></li>
                                        <li><a href="{{ route('gallery') }}">{{ __('Galerie') }}</a></li>
                                        <li><a href="{{ route('all.testimonials') }}">{{ __('Témoignages') }}</a>
                                    </ul>
                                </div>
                                <div class="col-xl-4 column">
                                    <ul>
                                        <li><h4>{{ __('Utilisateur') }}</h4></li>
                                        <li><a href="{{ route('dashboard') }}">{{ __('Tableau de bord') }}</a></li>
                                        <li><a href="{{ route('user.profile') }}">{{ __('Mon profil') }}</a></li>
                                        <li><a href="{{ route('user.wishlist') }}">{{ __('Mes favoris') }}</a></li>
                                        <li><a href="{{ route('user.appointments') }}">{{ __('Mes rendez-vous') }}</a></li>
                                        <li><a href="{{ route('user.inbox') }}">{{ __('Messagerie') }}</a></li>
                                        <li><a href="{{ route('all.notifications') }}">{{ __('Notifications') }}</a></li>
                                        <li><a href="{{ route('login') }}">{{ __('Connexion') }}</a></li>
                                        <li><a href="{{ route('register') }}">{{ __('Inscription') }}</a></li>
                                    </ul>
                                </div>
                                <div class="col-xl-4 column">
                                    <ul>
                                        <li><h4>{{ __('Ressources') }}</h4></li>
                                        <li><a href="{{ route('homepage') }}">{{ __('Blog immobilier') }}</a></li>
                                        <li><a href="{{ route('homepage') }}">{{ __('Conseils d\'achat') }}</a></li>
                                        <li><a href="{{ route('homepage') }}">{{ __('Financement') }}</a></li>
                                        <li><a href="{{ route('homepage') }}">{{ __('Rénovation') }}</a></li>
                                        {{-- Liens Carte des propriétés et Recommandations supprimés --}}
                                        <li><a href="{{ route('contact') }}">{{ __('Contact') }}</a></li>
                                        <li><a href="{{ route('homepage') }}">{{ __('Newsletter') }}</a></li>
                                    </ul>
                                </div>                                   
                            </div>                                        
                        </div>
                    </li> 
                    <li class="dropdown {{ Request::is('agency*') ? 'current' : '' }}"><a href="#"><span>Agence</span></a>
                        <ul>
                            <li><a href="{{ route('property.list') }}">Liste des agences</a></li>
                            <li><a href="{{ route('property.grid') }}">Grille des agences</a></li>
                        </ul>
                    </li>
                    <li class="dropdown {{ Request::is('blog*') ? 'current' : '' }}"><a href="{{ route('homepage') }}"><span>Blog</span></a>
                        <ul>
                            <li><a href="{{ route('homepage') }}">Liste des articles</a></li>
                            <li><a href="{{ route('homepage') }}">Détail d'article</a></li>
                        </ul>
                    </li>  
                    <li class="{{ Request::is('contact') ? 'current' : '' }}"><a href="{{ route('contact') }}"><span>Contact</span></a></li>   
                </ul>
            </div>
        </nav>
    </div>
    <div class="btn-box">
        <a href="{{ auth()->check() && auth()->user()->role == 'agent' ? route('agent.dashboard') : route('login') }}" class="theme-btn btn-one"><span>+</span>Ajouter une propriété</a>
    </div>
    </div>
    </div>
    </div>

    <!--sticky Header-->
    <div class="sticky-header">
        <div class="outer-box">
            <div class="main-box">
                <div class="logo-box">
                    <figure class="logo"><a href="/"><img src="{{ asset('backend/assets/images/logo-light.png') }}" alt="Immobilus" height="40"></a></figure>
                </div>
                <div class="menu-area clearfix">
                    <nav class="main-menu clearfix">
                        <!--Keep This Empty / Menu will come through Javascript-->
                    </nav>
                </div>
                <div class="btn-box">
                    <a href="{{ auth()->check() && auth()->user()->role == 'agent' ? route('agent.dashboard') : route('login') }}" class="theme-btn btn-one"><span>+</span>Ajouter une propriété</a>
                </div>
            </div>
        </div>
    </div>
</header>