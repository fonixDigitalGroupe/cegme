<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Post::with(['user', 'category', 'tags']);

        // Recherche par titre ou contenu
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Filtre par statut
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filtre par catégorie
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filtre par auteur
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filtre par tag
        if ($request->filled('tag_id')) {
            $query->whereHas('tags', function($q) use ($request) {
                $q->where('tags.id', $request->tag_id);
            });
        }

        // Filtre par date de publication (après)
        if ($request->filled('published_after')) {
            $query->where('published_at', '>=', $request->published_after);
        }

        // Filtre par date de publication (avant)
        if ($request->filled('published_before')) {
            $query->where('published_at', '<=', $request->published_before);
        }

        // Tri
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $posts = $query->paginate(15)->withQueryString();

        $categories = Category::all();
        $tags = Tag::all();
        $users = \App\Models\User::whereHas('posts')->distinct()->get();

        return view('admin.posts.index', compact('posts', 'categories', 'tags', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.posts.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:posts,slug'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'featured_image' => ['nullable', 'image', 'max:2048'],
            'header_image' => ['nullable', 'image', 'max:2048'],
            'status' => ['required', 'in:draft,published,archived'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['exists:tags,id'],
        ]);
        
        // Vérifier que le contenu n'est pas vide (après nettoyage HTML)
        $textContent = trim(strip_tags($validated['content']));
        if (empty($textContent) || strlen($textContent) < 10) {
            return back()->withErrors(['content' => 'Le contenu de l\'article doit contenir au moins quelques mots.'])->withInput();
        }

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('posts', 'public');
        }

        if ($request->hasFile('header_image')) {
            $validated['header_image'] = $request->file('header_image')->store('posts', 'public');
        }

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $validated['user_id'] = auth()->id();

        if ($validated['status'] === 'published') {
            $validated['published_at'] = now();
        }

        $tags = $validated['tags'] ?? [];
        unset($validated['tags']);

        $post = Post::create($validated);
        $post->tags()->sync($tags);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Article créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post->load(['user', 'category', 'tags']);
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();
        $post->load('tags');
        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:posts,slug,' . $post->id],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'featured_image' => ['nullable', 'image', 'max:2048'],
            'header_image' => ['nullable', 'image', 'max:2048'],
            'status' => ['required', 'in:draft,published,archived'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['exists:tags,id'],
        ]);
        
        // Vérifier que le contenu n'est pas vide (après nettoyage HTML)
        $textContent = trim(strip_tags($validated['content']));
        if (empty($textContent) || strlen($textContent) < 10) {
            return back()->withErrors(['content' => 'Le contenu de l\'article doit contenir au moins quelques mots.'])->withInput();
        }

        if ($request->hasFile('featured_image')) {
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('posts', 'public');
        }

        if ($request->hasFile('header_image')) {
            if ($post->header_image) {
                Storage::disk('public')->delete($post->header_image);
            }
            $validated['header_image'] = $request->file('header_image')->store('posts', 'public');
        }

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if ($validated['status'] === 'published' && !$post->published_at) {
            $validated['published_at'] = now();
        }

        $tags = $validated['tags'] ?? [];
        unset($validated['tags']);

        $post->update($validated);
        $post->tags()->sync($tags);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Article mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if ($post->featured_image) {
            Storage::disk('public')->delete($post->featured_image);
        }

        if ($post->header_image) {
            Storage::disk('public')->delete($post->header_image);
        }

        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('success', 'Article supprimé avec succès.');
    }

    /**
     * Upload image for editor content
     */
    public function uploadImage(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|image|max:5120', // Augmenté à 5MB
            ]);

            $path = $request->file('file')->store('posts/content', 'public');
            
            // Vérifier que le fichier existe
            if (!Storage::disk('public')->exists($path)) {
                return response()->json([
                    'error' => 'Le fichier n\'a pas pu être sauvegardé',
                    'success' => false
                ], 500);
            }
            
            // Utiliser asset() pour générer l'URL - plus simple et fiable
            $url = asset('storage/' . $path);
            
            // S'assurer que c'est une URL absolue
            if (!str_starts_with($url, 'http://') && !str_starts_with($url, 'https://')) {
                $url = request()->getSchemeAndHttpHost() . '/' . ltrim($url, '/');
            }

            \Log::info('Image uploadée - Chemin: ' . $path . ', URL: ' . $url);

            return response()->json([
                'url' => $url,
                'location' => $url,
                'success' => true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'success' => false
            ], 500);
        }
    }
    
    public function serveImage($path)
    {
        try {
            // Décoder le chemin URL (remplacer %2F par / et autres encodages)
            $decodedPath = urldecode($path);
            
            // Nettoyer le chemin pour éviter les problèmes de sécurité
            $decodedPath = str_replace('..', '', $decodedPath);
            $decodedPath = ltrim($decodedPath, '/');
            
            \Log::info('Tentative de chargement image: ' . $decodedPath);
            
            // Vérifier que le fichier existe
            if (!Storage::disk('public')->exists($decodedPath)) {
                \Log::error('Image non trouvée: ' . $decodedPath);
                // Essayer avec le chemin tel quel si le décodage ne fonctionne pas
                if (!Storage::disk('public')->exists($path)) {
                    abort(404, 'Image non trouvée');
                }
                $decodedPath = $path;
            }
            
            $file = Storage::disk('public')->get($decodedPath);
            $type = Storage::disk('public')->mimeType($decodedPath);
            
            if (!$type) {
                // Déterminer le type MIME à partir de l'extension
                $extension = pathinfo($decodedPath, PATHINFO_EXTENSION);
                $mimeTypes = [
                    'jpg' => 'image/jpeg',
                    'jpeg' => 'image/jpeg',
                    'png' => 'image/png',
                    'gif' => 'image/gif',
                    'webp' => 'image/webp',
                ];
                $type = $mimeTypes[strtolower($extension)] ?? 'image/jpeg';
            }
            
            return response($file, 200)
                ->header('Content-Type', $type)
                ->header('Cache-Control', 'public, max-age=31536000');
        } catch (\Exception $e) {
            \Log::error('Erreur serveImage: ' . $e->getMessage() . ' - Chemin: ' . $path);
            abort(404, 'Erreur lors du chargement de l\'image');
        }
    }
}
