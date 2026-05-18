<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
public function index(Request $request)
{
    $categories = \App\Models\BlogCategory::orderBy('name')->get();

    $blogs = Blog::with(['author', 'category'])

        // SEARCH
        ->when($request->search, function ($query) use ($request) {
            $query->where('title', 'like', '%' . $request->search . '%');
        })

        ->latest()
        ->paginate(9)
        ->appends(request()->query());

    return view('frontend.blogs', compact(
        'blogs',
        'categories'
    ));
}

public function filterByCategory(Request $request, string $categorySlug)
{
    $categories = \App\Models\BlogCategory::orderBy('name')->get();

    $selectedCategory = \App\Models\BlogCategory::where('slug', $categorySlug)
        ->firstOrFail();

    $blogs = Blog::with(['author', 'category'])
        ->where('blog_category_id', $selectedCategory->id)

        // SEARCH FILTER
        ->when($request->search, function ($query) use ($request) {
            $query->where('title', 'like', '%' . $request->search . '%');
        })

        ->latest()
        ->paginate(9)
        ->appends(request()->query());

    return view('frontend.blogs', compact(
        'blogs',
        'categories',
        'selectedCategory'
    ));
}

public function show(string $slug)
{
    $blog = Blog::with(['author', 'category'])
        ->where('slug', $slug)
        ->firstOrFail();

    return view('frontend.blog-show', compact('blog'));
}


    public function dashboardIndex()
    {
        $blogs = Blog::with(['author', 'category'])->latest()->paginate(10);
        return view('admin-blogs.index', compact('blogs'));
    }

    public function create()
    {
         $categories = \App\Models\BlogCategory::orderBy('name')->get();
        return view('admin-blogs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'blog_category_id' => 'nullable|exists:blog_categories,id',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('blogs', 'public');
        }

        Blog::create([
            'title'    => $validated['title'],
            'content'  => $validated['content'],
            'added_by' => Auth::id(),
            'blog_category_id' => $request->input('blog_category_id'),
            'image'    => $imagePath,
        ]);

        return redirect()
            ->route('admin-blogs.index')
            ->with('success', 'Blog post created successfully.');
    }


    public function edit(Blog $blog)
    {
         $categories = \App\Models\BlogCategory::orderBy('name')->get();
        return view('admin-blogs.edit',compact('blog', 'categories'));
    }

    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'blog_category_id' => 'nullable|exists:blog_categories,id',
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
             'blog_category_id' => $request->input('blog_category_id'),
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