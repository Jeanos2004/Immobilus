@extends('frontend.frontend_dashboard')
@section('content')

<!-- page-title -->
<section class="page-title centred">
    <div class="container">
        <div class="content-box">
            <h1>{{ $post->title }}</h1>
            <ul class="bread-crumb clearfix">
                <li><a href="{{ route('homepage') }}">{{ __('Accueil') }}</a></li>
                <li><a href="{{ route('blog') }}">{{ __('Blog') }}</a></li>
                <li>{{ Str::limit($post->title, 30) }}</li>
            </ul>
        </div>
    </div>
</section>
<!-- page-title end -->

<!-- sidebar-page-container -->
<section class="sidebar-page-container blog-details sec-pad-2">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12 col-sm-12 content-side">
                <div class="blog-details-content">
                    <div class="news-block-one">
                        <div class="inner-box">
                            <div class="image-box">
                                <figure class="image"><img src="{{ asset($post->featured_image) }}" alt="{{ $post->title }}"></figure>
                                <span class="category">{{ $post->category->name }}</span>
                            </div>
                            <div class="lower-content">
                                <h3>{{ $post->title }}</h3>
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
                                    <li><i class="far fa-eye"></i>{{ $post->views }} {{ __('vues') }}</li>
                                </ul>
                                <div class="text">
                                    <p>{{ $post->short_description }}</p>
                                    {!! $post->content !!}
                                </div>
                                <div class="post-tags">
                                    <ul class="tags-list clearfix">
                                        <li><h5>{{ __('Tags') }}:</h5></li>
                                        @if($post->tags)
                                            @php
                                                $tags = explode(',', $post->tags);
                                            @endphp
                                            @foreach($tags as $tag)
                                                <li><a href="{{ route('blog.search', ['query' => trim($tag)]) }}">{{ trim($tag) }}</a></li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Partage sur les réseaux sociaux -->
                    <div class="post-share-option clearfix">
                        <div class="text pull-left">
                            <h4>{{ __('Partager cet article') }}:</h4>
                        </div>
                        <ul class="social-links pull-right clearfix">
                            <li><a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog.show', $post->slug)) }}" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="https://twitter.com/intent/tweet?url={{ urlencode(route('blog.show', $post->slug)) }}&text={{ urlencode($post->title) }}" target="_blank"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('blog.show', $post->slug)) }}&title={{ urlencode($post->title) }}" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
                            <li><a href="https://pinterest.com/pin/create/button/?url={{ urlencode(route('blog.show', $post->slug)) }}&media={{ urlencode(asset($post->featured_image)) }}&description={{ urlencode($post->title) }}" target="_blank"><i class="fab fa-pinterest-p"></i></a></li>
                        </ul>
                    </div>
                    
                    <!-- Articles connexes -->
                    <div class="related-post">
                        <div class="title">
                            <h4>{{ __('Articles connexes') }}</h4>
                        </div>
                        <div class="row clearfix">
                            @foreach($relatedPosts as $related)
                            <div class="col-lg-6 col-md-6 col-sm-12 news-block">
                                <div class="news-block-one wow fadeInUp animated" data-wow-delay="00ms" data-wow-duration="1500ms">
                                    <div class="inner-box">
                                        <div class="image-box">
                                            <figure class="image"><a href="{{ route('blog.show', $related->slug) }}">
                                                <img src="{{ asset($related->featured_image) }}" alt="{{ $related->title }}"></a>
                                            </figure>
                                            <span class="category">{{ $related->category->name }}</span>
                                        </div>
                                        <div class="lower-content">
                                            <h4><a href="{{ route('blog.show', $related->slug) }}">{{ $related->title }}</a></h4>
                                            <ul class="post-info clearfix">
                                                <li><i class="far fa-calendar-alt"></i>{{ $related->created_at->format('d M Y') }}</li>
                                                <li><i class="far fa-eye"></i>{{ $related->views }} {{ __('vues') }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Commentaires -->
                    <div class="comments-area">
                        <div class="title">
                            <h4>{{ $post->comments->count() }} {{ __('Commentaires') }}</h4>
                        </div>
                        
                        @foreach($post->comments->where('parent_id', null) as $comment)
                        <div class="comment-box">
                            <div class="comment">
                                <figure class="thumb-box">
                                    @if($comment->user->photo)
                                    <img src="{{ url('upload/user_images/'.$comment->user->photo) }}" alt="{{ $comment->user->name }}">
                                    @else
                                    <img src="{{ url('upload/no_image.jpg') }}" alt="{{ $comment->user->name }}">
                                    @endif
                                </figure>
                                <div class="comment-inner">
                                    <div class="comment-info clearfix">
                                        <h5>{{ $comment->user->name }}</h5>
                                        <span>{{ $comment->created_at->format('d M Y à H:i') }}</span>
                                    </div>
                                    <div class="text">
                                        <p>{{ $comment->comment }}</p>
                                        @auth
                                        <a href="#" class="reply-btn" data-comment-id="{{ $comment->id }}">{{ __('Répondre') }}</a>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Réponses aux commentaires -->
                            @foreach($comment->replies as $reply)
                            <div class="comment replay-comment">
                                <figure class="thumb-box">
                                    @if($reply->user->photo)
                                    <img src="{{ url('upload/user_images/'.$reply->user->photo) }}" alt="{{ $reply->user->name }}">
                                    @else
                                    <img src="{{ url('upload/no_image.jpg') }}" alt="{{ $reply->user->name }}">
                                    @endif
                                </figure>
                                <div class="comment-inner">
                                    <div class="comment-info clearfix">
                                        <h5>{{ $reply->user->name }}</h5>
                                        <span>{{ $reply->created_at->format('d M Y à H:i') }}</span>
                                    </div>
                                    <div class="text">
                                        <p>{{ $reply->comment }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            
                            <!-- Formulaire de réponse (caché par défaut) -->
                            <div class="reply-form" id="reply-form-{{ $comment->id }}" style="display: none;">
                                @auth
                                <form action="{{ route('blog.comment') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                    <div class="form-group">
                                        <textarea name="comment" placeholder="{{ __('Votre réponse...') }}" required></textarea>
                                    </div>
                                    <div class="form-group message-btn">
                                        <button type="submit" class="theme-btn btn-one">{{ __('Répondre') }}</button>
                                    </div>
                                </form>
                                @endauth
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- Formulaire de commentaire -->
                    <div class="comments-form-area">
                        <div class="title">
                            <h4>{{ __('Laisser un commentaire') }}</h4>
                        </div>
                        @auth
                        <form action="{{ route('blog.comment') }}" method="post" class="comment-form">
                            @csrf
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                    <textarea name="comment" placeholder="{{ __('Votre commentaire...') }}" required></textarea>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 form-group message-btn">
                                    <button type="submit" class="theme-btn btn-one">{{ __('Soumettre le commentaire') }}</button>
                                </div>
                            </div>
                        </form>
                        @else
                        <div class="text-center">
                            <p>{{ __('Vous devez être connecté pour laisser un commentaire.') }}</p>
                            <a href="{{ route('login') }}" class="theme-btn btn-one">{{ __('Se connecter') }}</a>
                        </div>
                        @endauth
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
                                    <input type="search" name="query" placeholder="{{ __('Rechercher...') }}" required>
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

@section('scripts')
<script>
    $(document).ready(function() {
        // Afficher/masquer le formulaire de réponse
        $('.reply-btn').on('click', function(e) {
            e.preventDefault();
            var commentId = $(this).data('comment-id');
            $('#reply-form-' + commentId).toggle();
        });
    });
</script>
@endsection
