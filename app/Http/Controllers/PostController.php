<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Show the landing page with a sneak peek of recent posts.
     */
    public function welcome()
    {
        // Fetch only 3 published posts for the sneak peek
        $posts = Post::with('user')->where('status', 'published')->latest()->take(3)->get(); 
        
        return view('welcome', compact('posts'));
    }
    
    /**
     * Show all PUBLISHED blog posts (Public Page).
     */
    public function index()
    {
        // Only show posts that are explicitly 'published'
        $posts = Post::with('user')
                    ->where('status', 'published') 
                    ->latest()
                    ->get();
        
        return view('posts.index', compact('posts'));
    }

    /**
     * Show a single blog post.
     */
    public function show(Post $post)
    {
        // Authorization: Guest can only see published posts. Author can see their own drafts.
        if ($post->status !== 'published' && (!Auth::check() || Auth::id() !== $post->user_id)) {
            abort(404);
        }
        
        return view('posts.show', compact('post'));
    }

    /**
     * Show the authenticated user's post queue/dashboard.
     */
    public function dashboard()
    {
        // Fetch only the posts created by the currently authenticated user
        $posts = Auth::user()->posts()->latest()->get();

        // Calculate counts for the stats bar
        $totalPosts = $posts->count();
        $publishedCount = $posts->where('status', 'published')->count();
        $draftCount = $posts->where('status', 'draft')->count();

        return view('posts.dashboard', compact('posts', 'totalPosts', 'publishedCount', 'draftCount'));
    }

    /**
     * Show the form to create a new post.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Handle form submission and store the new post.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'blog_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
            'blog_video' => 'nullable|mimes:mp4,mov,ogg,qt|max:50000',
        ]);

        $imagePath = null;
         $videoPath = null; 
        if ($request->hasFile('blog_image')) {
            $imagePath = $request->file('blog_image')->store('blog_images', 'public');
        }
         if ($request->hasFile('blog_video')) {
        // Videos are stored in a separate folder
        $videoPath = $request->file('blog_video')->store('blog_videos', 'public');
        }

        Post::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => $imagePath,
            'video_path' => $videoPath,
            'status' => 'draft', // New posts default to draft
        ]);

        return redirect()->route('dashboard')->with('success', 'Blog post created and saved as DRAFT successfully!');
    }

    /**
     * Show the edit form for a specific post.
     */
    public function edit(Post $post)
    {
        // Authorization: Ensure the logged-in user owns the post
        if (Auth::id() !== $post->user_id) {
            abort(403);
        }
        return view('posts.edit', compact('post'));
    }

    /**
     * Handle the update logic.
     */
    public function update(Request $request, Post $post)
    {
        // Authorization
        if (Auth::id() !== $post->user_id) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'blog_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published', // Validate the status
        ]);

        $imagePath = $post->image_path;
        
        // Handle Image Replacement/Deletion
        if ($request->hasFile('blog_image')) {
            // Delete old image if it exists
            if ($post->image_path) {
                 Storage::disk('public')->delete($post->image_path); 
            }
            $imagePath = $request->file('blog_image')->store('blog_images', 'public');
        }

        // Update the Post
        $post->update([
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => $imagePath,
            'status' => $request->status, // Update status
        ]);

        return redirect()->route('dashboard')->with('success', 'Blog post updated successfully!');
    }

    /**
     * Handle the delete logic.
     */
    public function destroy(Post $post)
    {
        // Authorization
        if (Auth::id() !== $post->user_id) {
            abort(403);
        }

        // Optionally delete associated image file
        if ($post->image_path) {
             Storage::disk('public')->delete($post->image_path); 
        }

        $post->delete();
        
        return redirect()->route('dashboard')->with('success', 'Blog post deleted successfully!');
    }
}