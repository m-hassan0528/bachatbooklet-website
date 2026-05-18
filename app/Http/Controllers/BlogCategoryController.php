<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogCategoryController extends Controller
{
    // ─────────────────────────────────────────────────
    // PUBLIC ROUTES
    // ─────────────────────────────────────────────────

    // Public: all categories listing — /blogs/categories
    public function publicIndex()
    {
        $categories = BlogCategory::withCount('blogs')->latest()->get();
        return view('frontend.blog-categories', compact('categories'));
    }

    // Public: blogs by category — /blogs/{categorySlug}
    public function publicShow(string $categorySlug)
    {
        $category = BlogCategory::where('slug', $categorySlug)->firstOrFail();
        $blogs    = Blog::with('author')
                        ->where('blog_category_id', $category->id)
                        ->latest()
                        ->paginate(9);

        return view('frontend.blog-category-show', compact('category', 'blogs'));
    }

    // ─────────────────────────────────────────────────
    // DASHBOARD / ADMIN ROUTES
    // ─────────────────────────────────────────────────

    // Dashboard: category listing
    public function dashboardIndex()
    {
        $categories = BlogCategory::withCount('blogs')->latest()->paginate(10);
        return view('blog-categories.index', compact('categories'));
    }

    // Show create form
    public function create()
    {
        return view('blog-categories.create');
    }

    // Store new category
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('blog-categories', 'public');
        }

        BlogCategory::create([
            'name'  => $validated['name'],
            'image' => $imagePath,
        ]);

        return redirect()
            ->route('blog-categories.index')
            ->with('success', 'Blog category created successfully.');
    }

    // Show edit form
    public function edit(BlogCategory $blogCategory)
    {
        return view('blog-categories.edit', compact('blogCategory'));
    }

    // Update category
    public function update(Request $request, BlogCategory $blogCategory)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imagePath = $blogCategory->image;

        if ($request->hasFile('image')) {
            if ($blogCategory->image) {
                Storage::disk('public')->delete($blogCategory->image);
            }
            $imagePath = $request->file('image')->store('blog-categories', 'public');
        }

        $blogCategory->update([
            'name'  => $validated['name'],
            'image' => $imagePath,
        ]);

        return redirect()
            ->route('blog-categories.index')
            ->with('success', 'Blog category updated successfully.');
    }

    // Delete category
    public function destroy(BlogCategory $blogCategory)
    {
        if ($blogCategory->image) {
            Storage::disk('public')->delete($blogCategory->image);
        }

        $blogCategory->delete();

        return redirect()
            ->route('blog-categories.index')
            ->with('success', 'Blog category deleted successfully.');
    }
}