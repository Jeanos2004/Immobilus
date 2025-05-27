@extends('frontend.frontend_dashboard')
@section('content')

<!-- page-title -->
<section class="page-title centred">
    <div class="container">
        <div class="content-box">
            <h1>{{ __('Questions fréquemment posées') }}</h1>
            <ul class="bread-crumb clearfix">
                <li><a href="{{ route('homepage') }}">{{ __('Accueil') }}</a></li>
                <li>{{ __('FAQ') }}</li>
            </ul>
        </div>
    </div>
</section>
<!-- page-title end -->

<!-- faq-section -->
<section class="faq-section sec-pad">
    <div class="container">
        <div class="sec-title centred">
            <h5>{{ __('FAQ') }}</h5>
            <h2>{{ __('Questions fréquemment posées') }}</h2>
            <p>{{ __('Trouvez les réponses aux questions les plus courantes sur nos services immobiliers') }}</p>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 content-column">
                <div class="faq-content">
                    <div class="accordion-box">
                        <!-- Question 1 -->
                        <div class="accordion-item active-block">
                            <div class="acc-btn active">
                                <div class="icon-outer"><i class="fas fa-plus"></i></div>
                                <h5>{{ __('Comment puis-je commencer à chercher une propriété ?') }}</h5>
                            </div>
                            <div class="acc-content current">
                                <div class="content">
                                    <p>{{ __('Pour commencer votre recherche de propriété, vous pouvez utiliser notre outil de recherche avancée sur la page d\'accueil ou naviguer dans la section "Propriétés". Vous pouvez filtrer les résultats par type de propriété, emplacement, budget et autres caractéristiques pour trouver exactement ce que vous cherchez.') }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Question 2 -->
                        <div class="accordion-item">
                            <div class="acc-btn">
                                <div class="icon-outer"><i class="fas fa-plus"></i></div>
                                <h5>{{ __('Comment puis-je contacter un agent immobilier ?') }}</h5>
                            </div>
                            <div class="acc-content">
                                <div class="content">
                                    <p>{{ __('Vous pouvez contacter nos agents de plusieurs façons : en utilisant le formulaire de contact sur la page de détails de la propriété, en visitant la page "Agents" pour trouver un agent spécifique, ou en nous contactant directement via notre page "Contact". Vous pouvez également prendre rendez-vous avec un agent pour discuter de vos besoins immobiliers.') }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Question 3 -->
                        <div class="accordion-item">
                            <div class="acc-btn">
                                <div class="icon-outer"><i class="fas fa-plus"></i></div>
                                <h5>{{ __('Comment fonctionne le processus d\'achat d\'une propriété ?') }}</h5>
                            </div>
                            <div class="acc-content">
                                <div class="content">
                                    <p>{{ __('Le processus d\'achat d\'une propriété comprend généralement les étapes suivantes : recherche de propriétés, visites, négociation du prix, obtention d\'un prêt immobilier, signature du compromis de vente, et finalisation de l\'achat chez le notaire. Nos agents vous accompagnent à chaque étape pour vous assurer une transaction fluide et sans stress.') }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Question 4 -->
                        <div class="accordion-item">
                            <div class="acc-btn">
                                <div class="icon-outer"><i class="fas fa-plus"></i></div>
                                <h5>{{ __('Quels sont les frais associés à l\'achat d\'une propriété ?') }}</h5>
                            </div>
                            <div class="acc-content">
                                <div class="content">
                                    <p>{{ __('Les frais associés à l\'achat d\'une propriété incluent généralement : les frais de notaire (environ 7-8% du prix d\'achat pour un bien ancien, 2-3% pour un bien neuf), les frais d\'agence (si applicable), les frais de dossier bancaire pour le prêt, et potentiellement des frais d\'expertise. Notre calculatrice de prêt immobilier peut vous aider à estimer ces coûts.') }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Question 5 -->
                        <div class="accordion-item">
                            <div class="acc-btn">
                                <div class="icon-outer"><i class="fas fa-plus"></i></div>
                                <h5>{{ __('Comment puis-je vendre ma propriété avec Immobilus ?') }}</h5>
                            </div>
                            <div class="acc-content">
                                <div class="content">
                                    <p>{{ __('Pour vendre votre propriété avec Immobilus, contactez-nous pour organiser une évaluation gratuite de votre bien. Un de nos agents vous rencontrera pour discuter de votre projet de vente, évaluer votre propriété, et élaborer une stratégie marketing personnalisée. Nous nous occupons ensuite de la promotion, des visites, et des négociations pour vous obtenir le meilleur prix.') }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Question 6 -->
                        <div class="accordion-item">
                            <div class="acc-btn">
                                <div class="icon-outer"><i class="fas fa-plus"></i></div>
                                <h5>{{ __('Comment fonctionne la calculatrice de prêt immobilier ?') }}</h5>
                            </div>
                            <div class="acc-content">
                                <div class="content">
                                    <p>{{ __('Notre calculatrice de prêt immobilier vous permet d\'estimer vos mensualités en fonction du montant emprunté, du taux d\'intérêt, et de la durée du prêt. Entrez simplement ces informations dans l\'outil, et vous obtiendrez une estimation de vos paiements mensuels. C\'est un excellent moyen de planifier votre budget et de déterminer ce que vous pouvez vous permettre.') }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Question 7 -->
                        <div class="accordion-item">
                            <div class="acc-btn">
                                <div class="icon-outer"><i class="fas fa-plus"></i></div>
                                <h5>{{ __('Comment puis-je comparer différentes propriétés ?') }}</h5>
                            </div>
                            <div class="acc-content">
                                <div class="content">
                                    <p>{{ __('Pour comparer différentes propriétés, utilisez notre fonction "Ajouter aux favoris" sur les propriétés qui vous intéressent. Vous pouvez ensuite accéder à votre liste de favoris et utiliser notre outil de comparaison pour voir côte à côte les caractéristiques, les prix, et les avantages de chaque propriété, ce qui facilite votre prise de décision.') }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Question 8 -->
                        <div class="accordion-item">
                            <div class="acc-btn">
                                <div class="icon-outer"><i class="fas fa-plus"></i></div>
                                <h5>{{ __('Comment puis-je laisser un témoignage sur Immobilus ?') }}</h5>
                            </div>
                            <div class="acc-content">
                                <div class="content">
                                    <p>{{ __('Pour laisser un témoignage, connectez-vous à votre compte et accédez à la section "Témoignages" dans votre tableau de bord. Vous pouvez y partager votre expérience avec Immobilus et nos services. Vos commentaires sont précieux pour nous et aident d\'autres clients potentiels à prendre leur décision.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- faq-section end -->

<!-- contact-section -->
<section class="contact-section bg-color-1">
    <div class="container">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 content-column">
                <div class="content-box">
                    <div class="sec-title">
                        <h5>{{ __('Contact') }}</h5>
                        <h2>{{ __('Vous avez d\'autres questions ?') }}</h2>
                    </div>
                    <div class="text">
                        <p>{{ __('Si vous ne trouvez pas la réponse à votre question, n\'hésitez pas à nous contacter directement.') }}</p>
                    </div>
                    <div class="btn-box">
                        <a href="{{ route('contact') }}" class="theme-btn btn-one">{{ __('Contactez-nous') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- contact-section end -->

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Gestion de l'accordéon FAQ
        $('.accordion-item .acc-btn').on('click', function() {
            if($(this).hasClass('active') === false) {
                $('.accordion-item .acc-btn').removeClass('active');
                $(this).addClass('active');
                $('.accordion-item').removeClass('active-block');
                $(this).parent('.accordion-item').addClass('active-block');
                $('.accordion-item .acc-content').slideUp(300);
                $(this).next('.acc-content').slideDown(300);
            }
        });
    });
</script>
@endsection
