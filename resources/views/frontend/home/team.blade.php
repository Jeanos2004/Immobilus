<section class="team-section sec-pad centred bg-color-1">
    <div class="pattern-layer" style="background-image: url({{ asset('frontend/assets') }}/images/shape/shape-1.png);"></div>
    <div class="auto-container">
        <div class="sec-title">
            <h5>Nos agents</h5>
            <h2>Rencontrez nos agents immobiliers</h2>
        </div>
        <div class="single-item-carousel owl-carousel owl-theme owl-dots-none nav-style-one">
            @if(count($agents) > 0)
            @foreach($agents as $agent)
            <div class="team-block-one">
                <div class="inner-box">
                    <figure class="image-box">
                        @if(!empty($agent->photo))
                            <img src="{{ asset($agent->photo) }}" alt="{{ $agent->name }}">
                        @else
                            <img src="{{ asset('frontend/assets/images/team/team-1.jpg') }}" alt="{{ $agent->name }}">
                        @endif
                    </figure>
                    <div class="lower-content">
                        <div class="inner">
                            <h4><a href="{{ route('agent.properties', $agent->id) }}">{{ $agent->name }}</a></h4>
                            <span class="designation">Agent Immobilier</span>
                            <ul class="social-links clearfix">
                                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <div class="team-block-one">
                <div class="inner-box">
                    <figure class="image-box"><img src="{{ asset('frontend/assets/images/team/team-1.jpg') }}" alt=""></figure>
                    <div class="lower-content">
                        <div class="inner">
                            <h4><a href="#">Aucun agent disponible</a></h4>
                            <span class="designation">Veuillez revenir plus tard</span>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>