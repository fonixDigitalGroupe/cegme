<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of published blog posts.
     */
    public function index(Request $request)
    {
        $query = Post::with(['user', 'category', 'tags'])
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->orderBy('published_at', 'desc');

        // Filter by category
        if ($request->filled('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Filter by tag
        if ($request->filled('tag')) {
            $query->whereHas('tags', function($q) use ($request) {
                $q->where('slug', $request->tag);
            });
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $posts = $query->paginate(12);
        $categories = Category::withCount('posts')->get();

        return view('blog', compact('posts', 'categories'));
    }

    /**
     * Display the specified blog post.
     */
    public function show($slug)
    {
        $post = Post::with(['user', 'category', 'tags'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->firstOrFail();

        // Get related posts
        $relatedPosts = Post::with(['category', 'tags'])
            ->where('status', 'published')
            ->where('id', '!=', $post->id)
            ->where(function($query) use ($post) {
                if ($post->category_id) {
                    $query->where('category_id', $post->category_id);
                }
                $query->orWhereHas('tags', function($q) use ($post) {
                    $q->whereIn('tags.id', $post->tags->pluck('id'));
                });
            })
            ->limit(3)
            ->orderBy('published_at', 'desc')
            ->get();

        return view('blog-show', compact('post', 'relatedPosts'));
    }
}

