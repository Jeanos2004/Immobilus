<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class BlogController extends Controller
{
    // Liste des articles de blog
    public function index()
    {
        $posts = BlogPost::with('category', 'user')->latest()->get();
        return view('admin.blog.index', compact('posts'));
    }

    // Formulaire de création d'un article
    public function create()
    {
        $categories = BlogCategory::where('status', 1)->get();
        return view('admin.blog.create', compact('categories'));
    }

    // Enregistrer un nouvel article
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:blog_categories,id',
            'short_description' => 'required|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tags' => 'nullable|string|max:255',
            'status' => 'required|boolean',
            'featured' => 'required|boolean',
        ]);

        // Traitement de l'image
        $image = $request->file('featured_image');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        
        // Redimensionner et enregistrer l'image
        Image::make($image)->resize(800, 500)->save('upload/blog/' . $name_gen);
        $save_url = 'upload/blog/' . $name_gen;

        // Créer l'article
        BlogPost::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'category_id' => $request->category_id,
            'user_id' => Auth::id(),
            'short_description' => $request->short_description,
            'content' => $request->content,
            'featured_image' => $save_url,
            'tags' => $request->tags,
            'status' => $request->status,
            'featured' => $request->featured,
        ]);

        $notification = [
            'message' => 'Article de blog créé avec succès',
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.blog.index')->with($notification);
    }

    // Afficher un article
    public function show($id)
    {
        $post = BlogPost::with('category', 'user', 'comments.user')->findOrFail($id);
        return view('admin.blog.show', compact('post'));
    }

    // Formulaire d'édition d'un article
    public function edit($id)
    {
        $post = BlogPost::findOrFail($id);
        $categories = BlogCategory::where('status', 1)->get();
        return view('admin.blog.edit', compact('post', 'categories'));
    }

    // Mettre à jour un article
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:blog_categories,id',
            'short_description' => 'required|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tags' => 'nullable|string|max:255',
            'status' => 'required|boolean',
            'featured' => 'required|boolean',
        ]);

        $post = BlogPost::findOrFail($id);

        // Traitement de l'image si une nouvelle est fournie
        if ($request->hasFile('featured_image')) {
            // Supprimer l'ancienne image
            if (file_exists(public_path($post->featured_image))) {
                unlink(public_path($post->featured_image));
            }

            // Traiter la nouvelle image
            $image = $request->file('featured_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            
            // Redimensionner et enregistrer l'image
            Image::make($image)->resize(800, 500)->save('upload/blog/' . $name_gen);
            $save_url = 'upload/blog/' . $name_gen;
            
            $post->featured_image = $save_url;
        }

        // Mettre à jour l'article
        $post->title = $request->title;
        $post->slug = Str::slug($request->title);
        $post->category_id = $request->category_id;
        $post->short_description = $request->short_description;
        $post->content = $request->content;
        $post->tags = $request->tags;
        $post->status = $request->status;
        $post->featured = $request->featured;
        $post->save();

        $notification = [
            'message' => 'Article de blog mis à jour avec succès',
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.blog.index')->with($notification);
    }

    // Supprimer un article
    public function destroy($id)
    {
        $post = BlogPost::findOrFail($id);
        
        // Supprimer l'image
        if (file_exists(public_path($post->featured_image))) {
            unlink(public_path($post->featured_image));
        }
        
        // Supprimer l'article
        $post->delete();

        $notification = [
            'message' => 'Article de blog supprimé avec succès',
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.blog.index')->with($notification);
    }

    // Gestion des catégories
    public function categories()
    {
        $categories = BlogCategory::latest()->get();
        return view('admin.blog.categories.index', compact('categories'));
    }

    // Formulaire de création d'une catégorie
    public function createCategory()
    {
        return view('admin.blog.categories.create');
    }

    // Enregistrer une nouvelle catégorie
    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|boolean',
        ]);

        $save_url = null;
        
        // Traitement de l'image si fournie
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            
            // Redimensionner et enregistrer l'image
            Image::make($image)->resize(300, 300)->save('upload/blog/categories/' . $name_gen);
            $save_url = 'upload/blog/categories/' . $name_gen;
        }

        // Créer la catégorie
        BlogCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'image' => $save_url,
            'status' => $request->status,
        ]);

        $notification = [
            'message' => 'Catégorie créée avec succès',
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.blog.categories')->with($notification);
    }

    // Formulaire d'édition d'une catégorie
    public function editCategory($id)
    {
        $category = BlogCategory::findOrFail($id);
        return view('admin.blog.categories.edit', compact('category'));
    }

    // Mettre à jour une catégorie
    public function updateCategory(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|boolean',
        ]);

        $category = BlogCategory::findOrFail($id);

        // Traitement de l'image si une nouvelle est fournie
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image
            if ($category->image && file_exists(public_path($category->image))) {
                unlink(public_path($category->image));
            }

            // Traiter la nouvelle image
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            
            // Redimensionner et enregistrer l'image
            Image::make($image)->resize(300, 300)->save('upload/blog/categories/' . $name_gen);
            $save_url = 'upload/blog/categories/' . $name_gen;
            
            $category->image = $save_url;
        }

        // Mettre à jour la catégorie
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->description = $request->description;
        $category->status = $request->status;
        $category->save();

        $notification = [
            'message' => 'Catégorie mise à jour avec succès',
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.blog.categories')->with($notification);
    }

    // Supprimer une catégorie
    public function destroyCategory($id)
    {
        $category = BlogCategory::findOrFail($id);
        
        // Supprimer l'image
        if ($category->image && file_exists(public_path($category->image))) {
            unlink(public_path($category->image));
        }
        
        // Supprimer la catégorie
        $category->delete();

        $notification = [
            'message' => 'Catégorie supprimée avec succès',
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.blog.categories')->with($notification);
    }

    // Gestion des commentaires
    public function comments()
    {
        $comments = BlogComment::with('post', 'user')->latest()->get();
        return view('admin.blog.comments.index', compact('comments'));
    }

    // Approuver/Désapprouver un commentaire
    public function toggleCommentStatus($id)
    {
        $comment = BlogComment::findOrFail($id);
        $comment->status = !$comment->status;
        $comment->save();

        $notification = [
            'message' => 'Statut du commentaire mis à jour avec succès',
            'alert-type' => 'success'
        ];

        return back()->with($notification);
    }

    // Supprimer un commentaire
    public function destroyComment($id)
    {
        $comment = BlogComment::findOrFail($id);
        $comment->delete();

        $notification = [
            'message' => 'Commentaire supprimé avec succès',
            'alert-type' => 'success'
        ];

        return back()->with($notification);
    }
}
