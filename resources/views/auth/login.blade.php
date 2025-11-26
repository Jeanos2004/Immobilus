@extends('frontend.frontend_dashboard')
@section('content')
<!--Page Title-->
<section class="page-title-two bg-color-1 centred">
    <div class="pattern-layer">
        <div class="pattern-1" style="background-image: url({{ asset('frontend/assets') }}/images/shape/shape-9.png);"></div>
        <div class="pattern-2" style="background-image: url({{ asset('frontend/assets') }}/images/shape/shape-10.png);"></div>
    </div>
    <div class="auto-container">
        <div class="content-box clearfix">
            <h1>Connexion à Immobilus</h1>
            <ul class="bread-crumb clearfix">
                <li><a href="{{ route('homepage') }}">Accueil</a></li>
                <li>Connexion</li>
            </ul>
        </div>
    </div>
</section>
<!--End Page Title-->


<!-- register-section -->
<section class="ragister-section centred sec-pad">
    <div class="auto-container">
        <div class="row clearfix">
            <div class="col-xl-8 col-lg-12 col-md-12 offset-xl-2 big-column">
                <div class="sec-title">
                    <span class="sub-title">Accédez à votre espace Immobilus</span>
                    <h2>Retrouvez vos recherches, favoris et rendez-vous en un clic.</h2>
                </div>
                <div class="tabs-box">
                    <div class="tab-btn-box">
                        <ul class="tab-btns tab-buttons centred clearfix">
                            <li class="tab-btn active-btn" data-tab="#tab-1">Connexion</li>
                            <li class="tab-btn" data-tab="#tab-2">Inscription</li>
                        </ul>
                    </div>
                    <div class="tabs-content">
                        <div class="tab active-tab" id="tab-1">
                            <div class="inner-box">
                                <h4>Se connecter à Immobilus</h4>
                                <form action="{{ route('login') }}" method="post" class="default-form">
                                    @csrf
                                    <div class="form-group">
                                        <label>Nom d'utilisateur / Email / Téléphone</label>
                                        <input type="text" name="login" id="login" required="">
                                    </div>
                                    <div class="form-group">
                                        <label>Mot de passe</label>
                                        <input type="password" name="password" id="password" required="">
                                    </div>
                                    <div class="form-group d-flex justify-content-between align-items-center">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="remember">
                                                Se souvenir de moi
                                            </label>
                                        </div>
                                        @if (Route::has('password.request'))
                                            <a href="{{ route('password.request') }}" class="link">
                                                Mot de passe oublié ?
                                            </a>
                                        @endif
                                    </div>
                                    <div class="form-group message-btn">
                                        <button type="submit" class="theme-btn btn-one">Se connecter</button>
                                    </div>
                                    <p class="mt-3">
                                        Vous n'avez pas encore de compte ?
                                        <a href="javascript:void(0)" onclick="document.querySelector('[data-tab=\'#tab-2\']').click();">
                                            Créer un compte Immobilus
                                        </a>
                                    </p>
                                </form>
                            </div>
                        </div>
                        <div class="tab" id="tab-2">
                            <div class="inner-box">
                                <h4>Créer un compte Immobilus</h4>
                                <form action="{{ route('register') }}" method="post" class="default-form">
                                    @csrf
                                    <div class="form-group">
                                        <label>Nom complet</label>
                                        <input type="text" name="name" id="name" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Adresse email</label>
                                        <input type="email" name="email" id="email" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Mot de passe</label>
                                        <input type="password" name="password" id="password" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Confirmer le mot de passe</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation" required>
                                    </div>
                                    <div class="form-group message-btn">
                                        <button type="submit" class="theme-btn btn-one">Créer mon compte</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ragister-section end -->


<!-- subscribe-section -->
<section class="subscribe-section bg-color-3">
    <div class="pattern-layer" style="background-image: url({{ asset('frontend/assets/images/shape/shape-2.png') }});"></div>
    <div class="auto-container">
        <div class="row clearfix">
            <div class="col-lg-6 col-md-6 col-sm-12 text-column">
                <div class="text">
                    <span>Immobilus</span>
                    <h2>Recevez les dernières annonces et offres immobilières en Guinée.</h2>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 form-column">
                <div class="form-inner">
                    <form action="#" method="post" class="subscribe-form">
                        <div class="form-group">
                            <input type="email" name="email" placeholder="Votre adresse email" required="">
                            <button type="submit">S'abonner</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- subscribe-section end -->
@endsection