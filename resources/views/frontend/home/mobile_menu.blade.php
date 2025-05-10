<div class="mobile-menu">
    <div class="menu-backdrop"></div>
    <div class="close-btn"><i class="fas fa-times"></i></div>
    
    <nav class="menu-box">
        <div class="nav-logo"><a href="{{ route('homepage') }}"><img src="{{ asset('frontend/assets') }}/images/logo-2.png" alt="Immobilus" title="Immobilus"></a></div>
        <div class="menu-outer"><!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header--></div>
        <div class="contact-info">
            <h4>{{ __('messages.contact_info') }}</h4>
            <ul>
                <li>123 Avenue des Champs-Élysées, 75008 Paris, France</li>
                <li><a href="tel:+33123456789">+33 1 23 45 67 89</a></li>
                <li><a href="mailto:info@immobilus.com">info@immobilus.com</a></li>
            </ul>
        </div>
        <div class="social-links">
            <ul class="clearfix">
                <li><a href="#"><span class="fab fa-twitter"></span></a></li>
                <li><a href="#"><span class="fab fa-facebook-square"></span></a></li>
                <li><a href="#"><span class="fab fa-pinterest-p"></span></a></li>
                <li><a href="#"><span class="fab fa-instagram"></span></a></li>
                <li><a href="#"><span class="fab fa-linkedin-in"></span></a></li>
            </ul>
        </div>
        <!-- Language Selector -->
        <div class="language-selector mt-4 text-center">
            <a href="{{ route('lang.switch', 'fr') }}" class="btn {{ app()->getLocale() == 'fr' ? 'btn-primary' : 'btn-outline-primary' }} mr-2">FR</a>
            <a href="{{ route('lang.switch', 'en') }}" class="btn {{ app()->getLocale() == 'en' ? 'btn-primary' : 'btn-outline-primary' }}">EN</a>
        </div>
    </nav>
</div>