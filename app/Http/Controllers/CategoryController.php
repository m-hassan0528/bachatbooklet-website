<?php
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display all categories
     */
    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return view('categories.index', compact('categories'));
    }

    /**
     * Show create category form
     */
    public function create()
    {
        return view('categories.create');
    }

    private function generateSlug($name)
    {
        $slug = preg_replace('/[^A-Za-z0-9]+/', '_', strtolower($name));
        $slug = trim($slug, '_');
        return $slug;
    }

    /**
     * Store new category
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|unique:categories,name',
            'is_active' => 'required|boolean',
        ]);

        Category::create([
            'name'      => $request->name,
            'slug'      => $this->generateSlug($request->name),
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('categories.index')
            ->with('success', 'Category created successfully.');
    }

    /**
     * Show edit form
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update category
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name'      => 'required|unique:categories,name,' . $category->id,
            'is_active' => 'required|boolean',
        ]);

        $category->update([
            'name'      => $request->name,
            'slug'      => $this->generateSlug($request->name),
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('categories.index')
            ->with('success', 'Category updated successfully.');
    }

    /**
     * Soft delete category
     */
    public function destroy(Category $category)
    {
        $category->forceDelete(); 

        return redirect()->route('categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
