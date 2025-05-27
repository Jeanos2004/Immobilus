@extends('frontend.frontend_dashboard')
@section('content')

<!-- page-title -->
<section class="page-title centred">
    <div class="container">
        <div class="content-box">
            <h1>{{ __('Résultats de recherche') }}</h1>
            <ul class="bread-crumb clearfix">
                <li><a href="{{ route('homepage') }}">{{ __('Accueil') }}</a></li>
                <li><a href="{{ route('blog') }}">{{ __('Blog') }}</a></li>
                <li>{{ __('Recherche') }}: {{ $query }}</li>
            </ul>
        </div>
    </div>
</section>
<!-- page-title end -->

<!-- sidebar-page-container -->
<section class="sidebar-page-container blog-grid sec-pad-2">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12 col-sm-12 content-side">
                <div class="blog-grid-content">
                    <div class="title-box">
                        <h4>{{ __('Résultats de recherche pour') }}: <span class="text-primary">"{{ $query }}"</span></h4>
                        <p>{{ $posts->total() }} {{ __('articles trouvés') }}</p>
                    </div>
                    <div class="row clearfix">
                        @forelse($posts as $post)
                        <div class="col-lg-6 col-md-6 col-sm-12 news-block">
                            <div class="news-block-one wow fadeInUp animated" data-wow-delay="00ms" data-wow-duration="1500ms">
                                <div class="inner-box">
                                    <div class="image-box">
                                        <figure class="image"><a href="{{ route('blog.show', $post->slug) }}">
                                            <img src="{{ asset($post->featured_image) }}" alt="{{ $post->title }}"></a>
                                        </figure>
                                        <span class="category">{{ $post->category->name }}</span>
                                    </div>
                                    <div class="lower-content">
                                        <h4><a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a></h4>
                                        <ul class="post-info clearfix">
                                            <li class="author-box">
                                                <figure class="author-thumb">
                                                    @if($post->user->photo)
                                                    <img src="{{ url('upload/user_images/'.$post->user->photo) }}" alt="{{ $post->user->name }}">
                                                    @else
                                                    <img src="{{ url('upload/no_image.jpg') }}" alt="{{ $post->user->name }}">
                                                    @endif
                                                </figure>
                                                <h5><a href="#">{{ $post->user->name }}</a></h5>
                                            </li>
                                            <li>{{ $post->created_at->format('d M Y') }}</li>
                                        </ul>
                                        <div class="text">
                                            <p>{{ Str::limit($post->short_description, 120) }}</p>
                                        </div>
                                        <div class="btn-box">
                                            <a href="{{ route('blog.show', $post->slug) }}" class="theme-btn btn-two">{{ __('Lire plus') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="text-center">
                                <h3>{{ __('Aucun article trouvé pour votre recherche') }}</h3>
                                <p>{{ __('Essayez avec d\'autres mots-clés ou parcourez nos catégories.') }}</p>
                                <a href="{{ route('blog') }}" class="theme-btn btn-one">{{ __('Retour au blog') }}</a>
                            </div>
                        </div>
                        @endforelse
                    </div>
                    <div class="pagination-wrapper">
                        {{ $posts->appends(['query' => $query])->links('vendor.pagination.custom') }}
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12 sidebar-side">
                <div class="blog-sidebar">
                    <div class="sidebar-widget search-widget">
                        <div class="widget-title">
                            <h4>{{ __('Recherche') }}</h4>
                        </div>
                        <div class="search-inner">
                            <form action="{{ route('blog.search') }}" method="GET">
                                <div class="form-group">
                                    <input type="search" name="query" value="{{ $query }}" placeholder="{{ __('Rechercher...') }}" required>
                                    <button type="submit"><i class="fas fa-search"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="sidebar-widget category-widget">
                        <div class="widget-title">
                            <h4>{{ __('Catégories') }}</h4>
                        </div>
                        <div class="widget-content">
                            <ul class="category-list clearfix">
                                @foreach($categories as $category)
                                <li><a href="{{ route('blog.category', $category->slug) }}">{{ $category->name }} <span>({{ $category->posts->count() }})</span></a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="sidebar-widget post-widget">
                        <div class="widget-title">
                            <h4>{{ __('Articles récents') }}</h4>
                        </div>
                        <div class="post-inner">
                            @foreach($recentPosts as $recent)
                            <div class="post">
                                <figure class="post-thumb"><a href="{{ route('blog.show', $recent->slug) }}">
                                    <img src="{{ asset($recent->featured_image) }}" alt="{{ $recent->title }}"></a>
                                </figure>
                                <h5><a href="{{ route('blog.show', $recent->slug) }}">{{ Str::limit($recent->title, 40) }}</a></h5>
                                <span class="post-date">{{ $recent->created_at->format('d M Y') }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- sidebar-page-container end -->

@endsection
