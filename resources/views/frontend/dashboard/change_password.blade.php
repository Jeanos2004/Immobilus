@extends('frontend.frontend_dashboard')
@section('content')
 
 <!--Page Title-->
 <section class="page-title centred" style="background-image: url({{ asset('frontend/assets') }}/images/background/page-title-5.jpg);">
    <div class="auto-container">
        <div class="content-box clearfix">
            <h1>Change Password </h1>
            <ul class="bread-crumb clearfix">
                <li><a href="index.html">Home</a></li>
                <li>Change Password </li>
            </ul>
        </div>
    </div>
</section>
<!--End Page Title-->


<!-- sidebar-page-container -->
<section class="sidebar-page-container blog-details sec-pad-2">
    <div class="auto-container">
        <div class="row clearfix">
            




            @php
                $UserData = App\Models\User::find(Auth::user()->id);
            @endphp



<div class="col-lg-4 col-md-12 col-sm-12 sidebar-side">
    <div class="blog-sidebar">
      <div class="sidebar-widget post-widget">
            <div class="widget-title">
                <h4>Change Password </h4>
            </div>
            <div class="post-inner">
                <div class="post">
                    <figure class="post-thumb"><a href="blog-details.html">
<img src="{{ (!empty($UserData->photo)) ? asset('uploads/user_images/'.$UserData->photo) :  asset('uploads/no_image.jpg') }}" alt=""></a></figure>
<h5><a href="blog-details.html">{{ $UserData->name }}</a></h5>
 <p>{{ $UserData->email }}</p>
                </div> 
            </div>
        </div> 

<div class="sidebar-widget category-widget">
    <div class="widget-title">
        
    </div>
    

    @include('frontend.dashboard.dashboard_sidebar')
  </div> 
                 
                </div>
            </div>




<div class="col-lg-8 col-md-12 col-sm-12 content-side">
                <div class="blog-details-content">
                    <div class="news-block-one">
                        <div class="inner-box">
                            
                            <div class="lower-content">
                                
                              
  
<form action="{{ route('user.password.update') }}" method="post" class="default-form">
    @csrf
<div class="form-group">
    <label>Current Password</label>
    <input type="password" name="old_password" class="form-control @error('old_password') is-invalid @enderror" id="old_password"  placeholder="Old Password">
    @error('old_password')
        <strong class="text-danger">{{ $message }}</strong>
    @enderror
</div>
<div class="form-group">
    <label>New Password</label>
    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password"  placeholder="Password">
    @error('password')
        <strong class="text-danger">{{ $message }}</strong>
    @enderror
</div>
<div class="form-group">
    <label>Confirm Password</label>
    <input type="password" name="password_confirmation" class="form-control" id="password_confirmation"  placeholder="Confirm Password">
</div>


<div class="form-group message-btn">
    <button type="submit" class="theme-btn btn-one">Save Changes </button>
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
<!-- sidebar-page-container -->

<!-- subscribe-section -->
<section class="subscribe-section bg-color-3">
    <div class="pattern-layer" style="background-image: url({{ asset('frontend/assets') }}/images/shape/shape-2.png);"></div>
    <div class="auto-container">
        <div class="row clearfix">
            <div class="col-lg-6 col-md-6 col-sm-12 text-column">
                <div class="text">
                    <span>Subscribe</span>
                    <h2>Sign Up To Our Newsletter To Get The Latest News And Offers.</h2>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 form-column">
                <div class="form-inner">
                    <form action="contact.html" method="post" class="subscribe-form">
                        <div class="form-group">
                            <input type="email" name="email" placeholder="Enter your email" required="">
                            <button type="submit">Subscribe Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- subscribe-section end -->

@endsection