<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::with('author')->latest()->paginate(9);
        return view('frontend.blogs', compact('blogs'));
    }

    // Public single blog page — /blogs/{slug}
    public function show(string $slug)
    {
        $blog = Blog::with('author')->where('slug', $slug)->firstOrFail();
        return view('frontend.blog-show', compact('blog'));
    }


    public function dashboardIndex()
    {
        $blogs = Blog::with('author')->latest()->paginate(10);
        return view('admin-blogs.index', compact('blogs'));
    }

    public function create()
    {
        return view('admin-blogs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('blogs', 'public');
        }

        Blog::create([
            'title'    => $validated['title'],
            'content'  => $validated['content'],
            'added_by' => Auth::id(),
            'image'    => $imagePath,
        ]);

        return redirect()
            ->route('admin-blogs.index')
            ->with('success', 'Blog post created successfully.');
    }


    public function edit(Blog $blog)
    {
        return view('admin-blogs.edit', compact('blog'));
    }

    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imagePath = $blog->image;

        if ($request->hasFile('image')) {
            if ($blog->image) {
                Storage::disk('public')->delete($blog->image);
            }
            $imagePath = $request->file('image')->store('blogs', 'public');
        }

        $blog->update([
            'title'   => $validated['title'],
            'content' => $validated['content'],
            'image'   => $imagePath,
        ]);

        return redirect()
            ->route('admin-blogs.index')
            ->with('success', 'Blog post updated successfully.');
    }

    public function destroy(Blog $blog)
    {
        if ($blog->image) {
            Storage::disk('public')->delete($blog->image);
        }

        $blog->delete();

        return redirect()
            ->route('admin-blogs.index')
            ->with('success', 'Blog post deleted successfully.');
    }
}