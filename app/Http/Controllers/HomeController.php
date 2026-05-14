<?php
namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;

class HomeController extends Controller
{
  public function index()
{
    // Count brands per category (ENUM)
    $categoryCounts = Brand::where('status', 'active')
        ->get()
        ->groupBy('category')
        ->map(fn($items) => $items->count());

    // Take 5 latest brands per category
    $brands = Brand::where('status', 'active')
        ->latest()
        ->get()
        ->groupBy('category')
        ->map(fn($items) => $items->take(5));

    // Optional: category labels
    $categoryLabels = [
        'health_fitness' => 'Health & Fitness',
        'food_drinks'    => 'Food & Drink',
        'travel'         => 'Travel',
        'services'       => 'Services',
        'salon_spa'      => 'Salon & Spa',
        'leisure'        => 'Leisure',
    ];

    return view('welcome', compact('categoryCounts', 'brands', 'categoryLabels'));
}

}
