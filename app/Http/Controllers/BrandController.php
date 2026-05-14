<?php
namespace App\Http\Controllers;

use App\Http\Requests\BrandStoreRequest;
use App\Http\Requests\BrandUpdateRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Services\QrCodeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BrandController extends Controller
{
    protected QrCodeService $qrCodeService;

    public function __construct(QrCodeService $qrCodeService)
    {
        $this->qrCodeService = $qrCodeService;
    }

    /**
     * Display a listing of brands.
     */
    public function index(): View
    {
        $brands = Brand::latest()->paginate(15);
        return view('brands.index', [
            'brands' => $brands,
        ]);
    }

    /**
     * Show the form for creating a new brand.
     */
    public function create(): View
    {
        $categories = [
            'food_drink' => 'Food & Drink',
            'beauty_fitness' => 'Beauty & Fitness',
            'fashion_retail' => 'Fashion & Retail',
            'entertainment' => 'Entertainment',
            'travel_tourism' => 'Travel & Tourism',
            'services' => 'Services',
            'health_wellness' => 'Health & Wellness',
            'home_lifestyle' => 'Home & Lifestyle',
        ];
        $brand      = null;
        return view('brands.create', compact('categories'));
    }

    /**
     * Store a newly created brand in storage.
     */
    public function store(BrandStoreRequest $request): RedirectResponse
    {
        try {
            // Generate unique QR code
            $qrCode = $this->qrCodeService->generateUniqueCode();

            // Generate unique slug
            $slug = $this->qrCodeService->generateSlug($request->name);

            // Get the URL for the QR code
            $qrUrl = $this->qrCodeService->getQrUrl($qrCode);

            // Generate and store QR image
            $qrImagePath = $this->qrCodeService->generateQrImage($qrCode, $qrUrl);

            $logoPath = null;
            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('brands/logos', 'public');
            }
            // Create brand
            $brand = Brand::create([
                'name'          => $request->name,
                'slug'          => $slug,
                'description'   => $request->description,
               'category'      => $request->category,
                'logo'          => $logoPath,
                'qr_code'       => $qrCode,
                'qr_code_image' => $qrImagePath,
                'is_active'     => $request->boolean('is_active', true),
            ]);

            return Redirect::route('brands.index')
                ->with('status', 'Brand created successfully.');

        } catch (\Exception $e) {
            return Redirect::back()
                ->withInput()
                ->withErrors(['error' => 'Failed to create brand: ' . $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified brand.
     */
    public function edit(Brand $brand): View
    {
        $categories = [
            'food_drink' => 'Food & Drink',
            'beauty_fitness' => 'Beauty & Fitness',
            'fashion_retail' => 'Fashion & Retail',
            'entertainment' => 'Entertainment',
            'travel_tourism' => 'Travel & Tourism',
            'services' => 'Services',
            'health_wellness' => 'Health & Wellness',
            'home_lifestyle' => 'Home & Lifestyle',
        ];
        return view('brands.edit', compact('brand', 'categories'));
    }

    /**
     * Update the specified brand in storage.
     */
    public function update(BrandUpdateRequest $request, Brand $brand): RedirectResponse
    {

        if ($request->hasFile('logo')) {

            // delete old logo
            if ($brand->logo && Storage::disk('public')->exists($brand->logo)) {
                Storage::disk('public')->delete($brand->logo);
            }

            $brand->logo = $request->file('logo')->store('brands/logos', 'public');
        }
        $brand->update([
            'name'        => $request->name,
            'description' => $request->description,
            'category'      => $request->category,
            'is_active'   => $request->boolean('is_active', $brand->is_active),
        ]);

        return Redirect::route('brands.edit', $brand)
            ->with('status', 'Brand updated successfully.');
    }

    /**
     * Remove the specified brand from storage (soft delete).
     */
    public function destroy(Brand $brand): RedirectResponse
    {
        // Delete QR code image
        $this->qrCodeService->deleteQrImage($brand->qr_code_image);

        // Soft delete the brand
        $brand->delete();

        return Redirect::route('brands.index')
            ->with('status', 'Brand deleted successfully.');
    }
}
