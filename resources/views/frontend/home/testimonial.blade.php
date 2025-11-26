<section class="testimonial-section bg-color-1 centred">
    <div class="pattern-layer" style="background-image: url({{ asset('frontend/assets') }}/images/shape/shape-1.png);"></div>
    <div class="auto-container">
        <div class="sec-title">
            <h5>Témoignages</h5>
            <h2>Ce que disent nos clients</h2>
        </div>
        <div class="single-item-carousel owl-carousel owl-theme owl-dots-none nav-style-one">
            @php
                $testimonials = \App\Models\Testimonial::where('status', 1)->latest()->get();
            @endphp
            
            @if(count($testimonials) > 0)
                @foreach($testimonials as $testimonial)
                <div class="testimonial-block-one">
                    <div class="inner-box">
                        <figure class="thumb-box">
                            @if(!empty($testimonial->photo))
                                <img src="{{ asset($testimonial->photo) }}" alt="{{ $testimonial->name }}">
                            @else
                                <img src="{{ asset('frontend/assets/images/resource/testimonial-1.jpg') }}" alt="{{ $testimonial->name }}">
                            @endif
                        </figure>
                        <div class="rating">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $testimonial->rating)
                                    <i class="fas fa-star"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                            @endfor
                        </div>
                        <div class="text">
                            <p>{{ $testimonial->message }}</p>
                        </div>
                        <div class="author-info">
                            <h4>{{ $testimonial->name }}</h4>
                            <span class="designation">{{ $testimonial->position }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="testimonial-block-one">
                    <div class="inner-box">
                        <figure class="thumb-box"><img src="{{ asset('frontend/assets/images/resource/testimonial-1.jpg') }}" alt=""></figure>
                        <div class="text">
                            <p>Aucun témoignage disponible pour le moment.</p>
                        </div>
                        <div class="author-info">
                            <h4>Immobilus</h4>
                            <span class="designation">Agence immobilière</span>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

<style>
    .testimonial-section .rating {
        margin-bottom: 15px;
        color: #FFD700;
    }
    
    .testimonial-section .testimonial-block-one .inner-box {
        position: relative;
        display: block;
        background: #fff;
        padding: 40px 30px;
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }
    
    .testimonial-section .testimonial-block-one .inner-box:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }
    
    .testimonial-section .testimonial-block-one .thumb-box {
        position: relative;
        display: inline-block;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        margin-bottom: 20px;
        overflow: hidden;
    }
    
    .testimonial-section .testimonial-block-one .thumb-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }
</style>