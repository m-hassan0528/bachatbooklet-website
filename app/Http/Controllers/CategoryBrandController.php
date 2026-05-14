<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\View\View;
use Illuminate\Http\Request;

class CategoryBrandController extends Controller
{
public function show(string $slug): View
    {
         $category = str_replace('-', '_', $slug);
        $brands = Brand::where('category', $category)
            ->where('status', 'active')
            ->latest()
            ->paginate(20);

        abort_if($brands->isEmpty(), 404);

        return view('frontend.category-brands', compact('brands', 'category'));
    }
}
