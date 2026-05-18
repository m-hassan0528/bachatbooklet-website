<?php

use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BookOrderController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryBrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UniversalCodeController;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

//  frontend pages

Route::get('/about', function () {
    return view('frontend.about-us');
})->name('about');

Route::get('/contact', function () {
    return view('frontend.contact');
})->name('contact');

Route::get('/faq', function () {
    return view('frontend.faqs');
})->name('faq');

Route::get('/privacy', function () {
    return view('frontend.privacy-policy');
})->name('privacy');

Route::get('/terms-and-services', function () {
    return view('frontend.term-service');
})->name('terms-and-services');

Route::get('/category', function () {
    $categories = [
        'food_drink'      => 'Food & Drink',
        'beauty_fitness'  => 'Beauty & Fitness',
        'fashion_retail'  => 'Fashion & Retail',
        'entertainment'   => 'Entertainment',
        'travel_tourism'  => 'Travel & Tourism',
        'services'        => 'Services',
        'health_wellness' => 'Health & Wellness',
        'home_lifestyle'  => 'Home & Lifestyle',
    ];

    return view('frontend.categories', compact('categories'));
})->name('category');

// Book order route (public)
Route::post('/book-order', [BookOrderController::class, 'store'])->name('book-order.store');

// ─── Public Blog Routes ───────────────────────────────────────────────────────
// ORDER IS CRITICAL — specific routes must come before wildcard routes
Route::get('/blogs', [BlogController::class, 'index'])->name('blogs');
Route::get('/blogs/category/{categorySlug}', [BlogController::class, 'filterByCategory'])
    ->name('blogs.category');

Route::get('/blogs/{slug}', [BlogController::class, 'show'])
    ->name('blogs.show');
// ─────────────────────────────────────────────────────────────────────────────

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Brand management routes (admin only)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('brands', BrandController::class);

    // Universal Codes Management
    Route::get('universal-codes-export', [UniversalCodeController::class, 'export'])->name('universal-codes.export');
    Route::post('universal-codes/redeem', [UniversalCodeController::class, 'redeem'])->name('universal-codes.redeem');
    Route::resource('universal-codes', UniversalCodeController::class);

    // Book Orders Management
    Route::resource('book-orders', BookOrderController::class)->only(['index', 'edit', 'update', 'destroy']);

    // Category Management
    Route::resource('categories', CategoryController::class);

    // Blog Management
    Route::get('admin-blogs',                  [BlogController::class, 'dashboardIndex'])->name('admin-blogs.index');
    Route::get('admin-blogs/create',           [BlogController::class, 'create'])->name('admin-blogs.create');
    Route::post('admin-blogs',                 [BlogController::class, 'store'])->name('admin-blogs.store');
    Route::get('admin-blogs/{blog}/edit',      [BlogController::class, 'edit'])->name('admin-blogs.edit');
    Route::put('admin-blogs/{blog}',           [BlogController::class, 'update'])->name('admin-blogs.update');
    Route::delete('admin-blogs/{blog}',        [BlogController::class, 'destroy'])->name('admin-blogs.destroy');

    // Blog Category Management
    Route::get('blog-categories',                        [BlogCategoryController::class, 'dashboardIndex'])->name('blog-categories.index');
    Route::get('blog-categories/create',                 [BlogCategoryController::class, 'create'])->name('blog-categories.create');
    Route::post('blog-categories',                       [BlogCategoryController::class, 'store'])->name('blog-categories.store');
    Route::get('blog-categories/{blogCategory}/edit',    [BlogCategoryController::class, 'edit'])->name('blog-categories.edit');
    Route::put('blog-categories/{blogCategory}',         [BlogCategoryController::class, 'update'])->name('blog-categories.update');
    Route::delete('blog-categories/{blogCategory}',      [BlogCategoryController::class, 'destroy'])->name('blog-categories.destroy');
});

// Public routes for QR code scanning (no authentication required)
Route::get('/brands/{qr_code}/vouchers', function ($qr_code) {
    $brand = Brand::where('qr_code', $qr_code)->firstOrFail();

    return view('brands.vouchers', [
        'brand' => $brand,
    ]);
})->name('brands.vouchers');

Route::post('/brands/{qr_code}/vouchers/redeem', [UniversalCodeController::class, 'redeemPublic'])
    ->name('brands.vouchers.redeem');

Route::get('/brands/{qr_code}/vouchers/success', function ($qr_code, Request $request) {
    $brand = Brand::where('qr_code', $qr_code)->firstOrFail();

    return view('brands.vouchers-success', [
        'brand'        => $brand,
        'redemption_id' => $request->query('redemption_id'),
    ]);
})->name('brands.vouchers.success');

// Public brand detail page
Route::get('/brand/{brand:slug}', function (Brand $brand) {
    abort_if($brand->status !== 'active', 404);

    return view('frontend.brand-show', [
        'brand' => $brand,
    ]);
})->name('brand.show');

Route::get('/category/{slug}', [CategoryBrandController::class, 'show'])
    ->name('category.brands');

require __DIR__.'/auth.php';