@extends('frontend.frontend_dashboard')
@section('content')

<!-- page-title -->
<section class="page-title centred">
    <div class="container">
        <div class="content-box">
            <h1>{{ __('Politique de confidentialité') }}</h1>
            <ul class="bread-crumb clearfix">
                <li><a href="{{ route('homepage') }}">{{ __('Accueil') }}</a></li>
                <li>{{ __('Politique de confidentialité') }}</li>
            </ul>
        </div>
    </div>
</section>
<!-- page-title end -->

<!-- privacy-section -->
<section class="privacy-section sec-pad">
    <div class="container">
        <div class="content-box">
            <div class="text">
                <h3>{{ __('Introduction') }}</h3>
                <p>{{ __('Chez Immobilus, nous prenons la protection de vos données personnelles très au sérieux. Cette politique de confidentialité explique comment nous collectons, utilisons, partageons et protégeons vos informations lorsque vous utilisez notre site web et nos services.') }}</p>
                
                <h3>{{ __('Collecte des informations') }}</h3>
                <p>{{ __('Nous collectons des informations lorsque vous :') }}</p>
                <ul class="list-item clearfix">
                    <li>{{ __('Créez un compte sur notre site') }}</li>
                    <li>{{ __('Remplissez un formulaire de contact') }}</li>
                    <li>{{ __('Prenez rendez-vous avec un agent') }}</li>
                    <li>{{ __('Envoyez un message à un agent ou à un autre utilisateur') }}</li>
                    <li>{{ __('Ajoutez une propriété à vos favoris') }}</li>
                    <li>{{ __('Laissez un avis ou un témoignage') }}</li>
                    <li>{{ __('Utilisez notre calculatrice de prêt immobilier') }}</li>
                </ul>
                <p>{{ __('Les informations que nous collectons peuvent inclure :') }}</p>
                <ul class="list-item clearfix">
                    <li>{{ __('Informations d\'identification (nom, prénom, adresse e-mail, numéro de téléphone)') }}</li>
                    <li>{{ __('Informations de connexion et d\'utilisation de notre site') }}</li>
                    <li>{{ __('Préférences de recherche immobilière') }}</li>
                    <li>{{ __('Contenu des messages et communications') }}</li>
                    <li>{{ __('Informations de localisation (si vous l\'autorisez)') }}</li>
                </ul>
                
                <h3>{{ __('Utilisation des informations') }}</h3>
                <p>{{ __('Nous utilisons vos informations pour :') }}</p>
                <ul class="list-item clearfix">
                    <li>{{ __('Fournir, maintenir et améliorer nos services') }}</li>
                    <li>{{ __('Traiter vos demandes et vous contacter') }}</li>
                    <li>{{ __('Personnaliser votre expérience utilisateur') }}</li>
                    <li>{{ __('Vous recommander des propriétés susceptibles de vous intéresser') }}</li>
                    <li>{{ __('Vous envoyer des notifications concernant vos rendez-vous, messages ou activités sur le site') }}</li>
                    <li>{{ __('Analyser l\'utilisation de notre site pour l\'améliorer') }}</li>
                    <li>{{ __('Détecter et prévenir les fraudes ou abus') }}</li>
                </ul>
                
                <h3>{{ __('Partage des informations') }}</h3>
                <p>{{ __('Nous pouvons partager vos informations avec :') }}</p>
                <ul class="list-item clearfix">
                    <li>{{ __('Les agents immobiliers lorsque vous prenez rendez-vous ou envoyez un message') }}</li>
                    <li>{{ __('Nos prestataires de services qui nous aident à exploiter notre site et nos services') }}</li>
                    <li>{{ __('Les autorités légales si nous y sommes contraints par la loi') }}</li>
                </ul>
                <p>{{ __('Nous ne vendons jamais vos données personnelles à des tiers à des fins commerciales.') }}</p>
                
                <h3>{{ __('Protection des informations') }}</h3>
                <p>{{ __('Nous mettons en œuvre des mesures de sécurité appropriées pour protéger vos informations contre tout accès non autorisé, altération, divulgation ou destruction. Ces mesures comprennent le chiffrement des données, l\'accès limité aux informations personnelles par nos employés, et des procédures de sauvegarde régulières.') }}</p>
                
                <h3>{{ __('Cookies et technologies similaires') }}</h3>
                <p>{{ __('Nous utilisons des cookies et des technologies similaires pour améliorer votre expérience sur notre site, analyser comment vous l\'utilisez, et personnaliser le contenu et les publicités. Vous pouvez configurer votre navigateur pour refuser tous les cookies ou pour vous avertir lorsqu\'un cookie est envoyé. Cependant, certaines fonctionnalités du site peuvent ne pas fonctionner correctement si les cookies sont désactivés.') }}</p>
                
                <h3>{{ __('Vos droits') }}</h3>
                <p>{{ __('Vous disposez de certains droits concernant vos données personnelles, notamment :') }}</p>
                <ul class="list-item clearfix">
                    <li>{{ __('Accéder à vos données personnelles') }}</li>
                    <li>{{ __('Rectifier vos données inexactes') }}</li>
                    <li>{{ __('Supprimer vos données dans certaines circonstances') }}</li>
                    <li>{{ __('Limiter ou vous opposer au traitement de vos données') }}</li>
                    <li>{{ __('Recevoir vos données dans un format structuré (portabilité)') }}</li>
                    <li>{{ __('Retirer votre consentement à tout moment') }}</li>
                </ul>
                <p>{{ __('Pour exercer ces droits, veuillez nous contacter via notre page de contact ou à l\'adresse e-mail indiquée ci-dessous.') }}</p>
                
                <h3>{{ __('Modifications de la politique de confidentialité') }}</h3>
                <p>{{ __('Nous pouvons mettre à jour cette politique de confidentialité de temps à autre. Nous vous informerons de tout changement important en publiant la nouvelle politique sur cette page et en vous envoyant un e-mail si nécessaire. Nous vous encourageons à consulter régulièrement cette page pour rester informé des changements.') }}</p>
                
                <h3>{{ __('Contact') }}</h3>
                <p>{{ __('Si vous avez des questions concernant cette politique de confidentialité, veuillez nous contacter à :') }}</p>
                <p>
                    {{ __('Immobilus') }}<br>
                    {{ __('Email : contact@immobilus.com') }}<br>
                    {{ __('Téléphone : +33 1 23 45 67 89') }}<br>
                    {{ __('Adresse : 123 Avenue de l\'Immobilier, 75000 Paris, France') }}
                </p>
                
                <p class="mb-0">{{ __('Dernière mise à jour : 27 mai 2025') }}</p>
            </div>
        </div>
    </div>
</section>
<!-- privacy-section end -->

@endsection
