<section class="chooseus-section">
    <div class="auto-container">
        <div class="inner-container bg-color-2">
            <div class="upper-box clearfix">
                <div class="sec-title light">
                    <h5>{{ __('messages.why_choose_us') }}</h5>
                    <h2>{{ __('messages.reasons_to_choose_us') }}</h2>
                </div>
                <div class="btn-box">
                    <a href="{{ route('property.list') }}" class="theme-btn btn-one">{{ __('messages.all_categories') }}</a>
                </div>
            </div>
            <div class="lower-box">
                <div class="row clearfix">
                    <div class="col-lg-4 col-md-6 col-sm-12 chooseus-block">
                        <div class="chooseus-block-one">
                            <div class="inner-box">
                                <div class="icon-box"><i class="icon-19"></i></div>
                                <h4>{{ __('messages.excellent_reputation') }}</h4>
                                <p>{{ __('messages.excellent_reputation_desc') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12 chooseus-block">
                        <div class="chooseus-block-one">
                            <div class="inner-box">
                                <div class="icon-box"><i class="icon-26"></i></div>
                                <h4>{{ __('messages.best_local_agents') }}</h4>
                                <p>{{ __('messages.best_local_agents_desc') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12 chooseus-block">
                        <div class="chooseus-block-one">
                            <div class="inner-box">
                                <div class="icon-box"><i class="icon-21"></i></div>
                                <h4>{{ __('messages.personalized_service') }}</h4>
                                <p>{{ __('messages.personalized_service_desc') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .chooseus-section .inner-container {
        position: relative;
        padding: 60px 30px;
        border-radius: 10px;
    }
    
    .chooseus-section .upper-box {
        margin-bottom: 40px;
    }
    
    .chooseus-section .sec-title h5,
    .chooseus-section .sec-title h2 {
        color: #fff;
    }
    
    .chooseus-section .chooseus-block-one {
        position: relative;
        display: block;
        background: rgba(255, 255, 255, 0.1);
        padding: 30px;
        border-radius: 10px;
        transition: all 0.3s ease;
        height: 100%;
    }
    
    .chooseus-section .chooseus-block-one:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: translateY(-10px);
    }
    
    .chooseus-section .chooseus-block-one .icon-box {
        position: relative;
        display: inline-block;
        font-size: 50px;
        line-height: 50px;
        color: #fff;
        margin-bottom: 20px;
    }
    
    .chooseus-section .chooseus-block-one h4 {
        font-size: 22px;
        line-height: 30px;
        font-weight: 600;
        color: #fff;
        margin-bottom: 10px;
    }
    
    .chooseus-section .chooseus-block-one p {
        color: rgba(255, 255, 255, 0.8);
    }
    
    .chooseus-section .chooseus-block {
        margin-bottom: 30px;
    }
    
    @media (max-width: 767px) {
        .chooseus-section .inner-container {
            padding: 40px 20px;
        }
        
        .chooseus-section .upper-box {
            text-align: center;
        }
        
        .chooseus-section .btn-box {
            float: none !important;
            margin-top: 20px;
        }
    }
</style>