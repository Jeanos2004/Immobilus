<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    // Afficher tous les articles de blog
    public function index()
    {
        $posts = BlogPost::where('status', 1)
            ->with('category', 'user')
            ->orderBy('created_at', 'desc')
            ->paginate(6);
        
        $categories = BlogCategory::where('status', 1)->get();
        $recentPosts = BlogPost::where('status', 1)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
        
        return view('frontend.blog.index', compact('posts', 'categories', 'recentPosts'));
    }

    // Afficher un article de blog spécifique
    public function show($slug)
    {
        $post = BlogPost::where('slug', $slug)
            ->where('status', 1)
            ->with('category', 'user', 'comments.user', 'comments.replies.user')
            ->firstOrFail();
        
        // Incrémenter le nombre de vues
        $post->increment('views');
        
        $categories = BlogCategory::where('status', 1)->get();
        $recentPosts = BlogPost::where('status', 1)
            ->where('id', '!=', $post->id)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
        
        $relatedPosts = BlogPost::where('status', 1)
            ->where('id', '!=', $post->id)
            ->where('category_id', $post->category_id)
            ->orderBy('created_at', 'desc')
            ->take(2)
            ->get();
        
        return view('frontend.blog.show', compact('post', 'categories', 'recentPosts', 'relatedPosts'));
    }

    // Afficher les articles par catégorie
    public function category($slug)
    {
        $category = BlogCategory::where('slug', $slug)
            ->where('status', 1)
            ->firstOrFail();
        
        $posts = BlogPost::where('status', 1)
            ->where('category_id', $category->id)
            ->with('category', 'user')
            ->orderBy('created_at', 'desc')
            ->paginate(6);
        
        $categories = BlogCategory::where('status', 1)->get();
        $recentPosts = BlogPost::where('status', 1)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
        
        return view('frontend.blog.category', compact('posts', 'category', 'categories', 'recentPosts'));
    }

    // Rechercher des articles
    public function search(Request $request)
    {
        $query = $request->input('query');
        
        $posts = BlogPost::where('status', 1)
            ->where(function($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                  ->orWhere('short_description', 'LIKE', "%{$query}%")
                  ->orWhere('content', 'LIKE', "%{$query}%");
            })
            ->with('category', 'user')
            ->orderBy('created_at', 'desc')
            ->paginate(6);
        
        $categories = BlogCategory::where('status', 1)->get();
        $recentPosts = BlogPost::where('status', 1)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
        
        return view('frontend.blog.search', compact('posts', 'query', 'categories', 'recentPosts'));
    }

    // Ajouter un commentaire
    public function addComment(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:blog_posts,id',
            'comment' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:blog_comments,id'
        ]);
        
        $comment = new BlogComment();
        $comment->post_id = $request->post_id;
        $comment->user_id = Auth::id();
        $comment->comment = $request->comment;
        $comment->parent_id = $request->parent_id;
        $comment->save();
        
        return back()->with('success', 'Votre commentaire a été ajouté avec succès.');
    }
}
