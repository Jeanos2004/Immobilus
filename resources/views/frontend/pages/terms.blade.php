@extends('frontend.frontend_dashboard')
@section('content')

<!-- page-title -->
<section class="page-title centred">
    <div class="container">
        <div class="content-box">
            <h1>{{ __('Conditions d\'utilisation') }}</h1>
            <ul class="bread-crumb clearfix">
                <li><a href="{{ route('homepage') }}">{{ __('Accueil') }}</a></li>
                <li>{{ __('Conditions d\'utilisation') }}</li>
            </ul>
        </div>
    </div>
</section>
<!-- page-title end -->

<!-- terms-section -->
<section class="terms-section sec-pad">
    <div class="container">
        <div class="content-box">
            <div class="text">
                <h3>{{ __('1. Acceptation des conditions') }}</h3>
                <p>{{ __('En accédant et en utilisant le site web Immobilus, vous acceptez d\'être lié par ces conditions d\'utilisation, toutes les lois et réglementations applicables, et vous acceptez que vous êtes responsable du respect des lois locales applicables. Si vous n\'acceptez pas ces conditions, vous n\'êtes pas autorisé à utiliser ou à accéder à ce site.') }}</p>
                
                <h3>{{ __('2. Utilisation de la licence') }}</h3>
                <p>{{ __('L\'autorisation est accordée de télécharger temporairement une copie des documents sur le site web d\'Immobilus pour un usage personnel, non commercial et transitoire uniquement. Cette licence ne constitue pas un transfert de titre et, sous cette licence, vous ne pouvez pas :') }}</p>
                <ul class="list-item clearfix">
                    <li>{{ __('Modifier ou copier les documents') }}</li>
                    <li>{{ __('Utiliser les documents à des fins commerciales ou pour toute présentation publique') }}</li>
                    <li>{{ __('Tenter de décompiler ou de désosser tout logiciel contenu sur le site web d\'Immobilus') }}</li>
                    <li>{{ __('Supprimer tout droit d\'auteur ou autres notations de propriété des documents') }}</li>
                    <li>{{ __('Transférer les documents à une autre personne ou "refléter" les documents sur un autre serveur') }}</li>
                </ul>
                <p>{{ __('Cette licence sera automatiquement résiliée si vous violez l\'une de ces restrictions et peut être résiliée par Immobilus à tout moment.') }}</p>
                
                <h3>{{ __('3. Exactitude des informations') }}</h3>
                <p>{{ __('Les documents présents sur le site web d\'Immobilus peuvent inclure des erreurs techniques, typographiques ou photographiques. Immobilus ne garantit pas que les documents de son site web sont exacts, complets ou à jour. Immobilus peut modifier les documents contenus sur son site web à tout moment sans préavis. Cependant, Immobilus ne s\'engage pas à mettre à jour les documents.') }}</p>
                
                <h3>{{ __('4. Propriétés immobilières et annonces') }}</h3>
                <p>{{ __('Les informations concernant les propriétés immobilières présentées sur notre site sont fournies par nos agents et propriétaires partenaires. Bien que nous nous efforcions de vérifier l\'exactitude de ces informations, nous ne pouvons garantir qu\'elles sont complètes, à jour ou exemptes d\'erreurs. Nous vous recommandons de vérifier toutes les informations importantes directement auprès de l\'agent responsable avant de prendre toute décision basée sur ces informations.') }}</p>
                <p>{{ __('Les prix, disponibilités et conditions des propriétés peuvent changer sans préavis. Les images des propriétés sont fournies à titre indicatif et peuvent ne pas représenter exactement l\'état actuel de la propriété.') }}</p>
                
                <h3>{{ __('5. Liens') }}</h3>
                <p>{{ __('Immobilus n\'a pas examiné tous les sites liés à son site web et n\'est pas responsable du contenu de ces sites liés. L\'inclusion de tout lien n\'implique pas l\'approbation par Immobilus du site. L\'utilisation de tout site web lié est aux risques et périls de l\'utilisateur.') }}</p>
                
                <h3>{{ __('6. Compte utilisateur') }}</h3>
                <p>{{ __('Pour accéder à certaines fonctionnalités du site, vous devrez peut-être créer un compte. Vous êtes responsable du maintien de la confidentialité de votre compte et mot de passe et de la restriction de l\'accès à votre ordinateur. Vous acceptez d\'assumer la responsabilité de toutes les activités qui se produisent sous votre compte ou mot de passe.') }}</p>
                <p>{{ __('Immobilus se réserve le droit de refuser le service, de supprimer ou de modifier le contenu, ou d\'annuler des comptes à sa seule discrétion.') }}</p>
                
                <h3>{{ __('7. Communications et messages') }}</h3>
                <p>{{ __('En utilisant notre système de messagerie pour communiquer avec des agents ou d\'autres utilisateurs, vous acceptez de ne pas envoyer de messages :') }}</p>
                <ul class="list-item clearfix">
                    <li>{{ __('Diffamatoires, obscènes, harcelants, menaçants ou abusifs') }}</li>
                    <li>{{ __('Contenant des informations fausses ou trompeuses') }}</li>
                    <li>{{ __('Violant les droits de propriété intellectuelle d\'autrui') }}</li>
                    <li>{{ __('Contenant des virus ou autres codes malveillants') }}</li>
                    <li>{{ __('À des fins de spam ou de sollicitation commerciale non autorisée') }}</li>
                </ul>
                <p>{{ __('Immobilus se réserve le droit de surveiller les communications et de supprimer tout contenu qui viole ces conditions.') }}</p>
                
                <h3>{{ __('8. Rendez-vous et visites') }}</h3>
                <p>{{ __('Les rendez-vous pris via notre plateforme sont soumis à la disponibilité des agents et des propriétaires. Bien que nous nous efforcions de faciliter ces rendez-vous, nous ne pouvons garantir qu\'ils auront lieu comme prévu. Nous vous encourageons à confirmer directement avec l\'agent concerné avant la visite prévue.') }}</p>
                <p>{{ __('L\'annulation d\'un rendez-vous doit être effectuée dans un délai raisonnable pour éviter tout désagrément.') }}</p>
                
                <h3>{{ __('9. Modifications des conditions d\'utilisation') }}</h3>
                <p>{{ __('Immobilus peut réviser ces conditions d\'utilisation de son site web à tout moment sans préavis. En utilisant ce site web, vous acceptez d\'être lié par la version alors en vigueur de ces conditions d\'utilisation.') }}</p>
                
                <h3>{{ __('10. Loi applicable') }}</h3>
                <p>{{ __('Ces conditions sont régies et interprétées conformément aux lois françaises, et vous vous soumettez irrévocablement à la juridiction exclusive des tribunaux de Paris, France.') }}</p>
                
                <h3>{{ __('11. Contact') }}</h3>
                <p>{{ __('Si vous avez des questions concernant ces conditions d\'utilisation, veuillez nous contacter à :') }}</p>
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
<!-- terms-section end -->

@endsection
