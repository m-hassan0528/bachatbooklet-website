<?php

namespace App\Http\Controllers;

use App\Http\Requests\UniversalCodeRedeemRequest;
use App\Http\Requests\UniversalCodeStoreRequest;
use App\Http\Requests\UniversalCodeUpdateRequest;
use App\Models\Brand;
use App\Models\UniversalCode;
use App\Services\UniversalCodeService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class UniversalCodeController extends Controller
{
    protected UniversalCodeService $universalCodeService;

    public function __construct(UniversalCodeService $universalCodeService)
    {
        $this->universalCodeService = $universalCodeService;
    }

    /**
     * Display a listing of universal codes.
     */
    public function index(Request $request): View
    {
        $query = UniversalCode::with('redemptions')->latest();

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Search by code
        if ($request->has('search') && $request->search !== '') {
            $query->where('code', 'like', '%' . $request->search . '%');
        }

        $codes = $query->paginate(25);
        $stats = $this->universalCodeService->getCodeStats();

        return view('universal-codes.index', [
            'codes' => $codes,
            'stats' => $stats,
        ]);
    }

    /**
     * Show the form for creating a new universal code.
     */
    public function create(): View
    {
        return view('universal-codes.create');
    }

    /**
     * Store a newly created universal code in storage.
     */
    public function store(UniversalCodeStoreRequest $request): RedirectResponse
    {
        try {
            if ($request->bulk_count && $request->bulk_count > 1) {
                // Bulk creation
                $codes = $this->universalCodeService->bulkCreateCodes(
                    $request->bulk_count,
                    $request->notes
                );

                return Redirect::route('universal-codes.index')
                    ->with('status', "{$codes->count()} codes created successfully.");
            } else {
                // Single creation
                $code = $this->universalCodeService->createCode($request->notes);

                return Redirect::route('universal-codes.show', $code)
                    ->with('status', 'Code created successfully.');
            }
        } catch (\Exception $e) {
            return Redirect::back()
                ->withInput()
                ->withErrors(['error' => 'Failed to create code: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified universal code.
     */
    public function show(UniversalCode $universalCode): View
    {
        $universalCode->load(['redemptions.brand']);

        return view('universal-codes.show', [
            'code' => $universalCode,
        ]);
    }

    /**
     * Show the form for editing the specified universal code.
     */
    public function edit(UniversalCode $universalCode): View
    {
        return view('universal-codes.edit', [
            'code' => $universalCode,
        ]);
    }

    /**
     * Update the specified universal code in storage.
     */
    public function update(
        UniversalCodeUpdateRequest $request,
        UniversalCode $universalCode
    ): RedirectResponse {
        $universalCode->update([
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        return Redirect::route('universal-codes.show', $universalCode)
            ->with('status', 'Code updated successfully.');
    }

    /**
     * Remove the specified universal code from storage.
     */
    public function destroy(UniversalCode $universalCode): RedirectResponse
    {
        $universalCode->delete();

        return Redirect::route('universal-codes.index')
            ->with('status', 'Code deleted successfully.');
    }

    /**
     * Process code redemption.
     */
    public function redeem(UniversalCodeRedeemRequest $request): JsonResponse
    {
        try {
            $brand = Brand::findOrFail($request->brand_id);

            // Validate code for this specific brand
            $validation = $this->universalCodeService->validateCode($request->code, $brand->id);

            if (!$validation['valid']) {
                return response()->json([
                    'success' => false,
                    'message' => $validation['message'],
                ], 422);
            }

            $redemption = $this->universalCodeService->redeemCode(
                $validation['code'],
                $brand,
                $request->customer_info,
                Auth::user()->name,
                $request->notes
            );

            $remainingForBrand = $validation['code']->fresh()->getRemainingRedemptionsForBrand($brand->id);

            return response()->json([
                'success' => true,
                'message' => "Code redeemed successfully for {$brand->name}.",
                'remaining_for_brand' => $remainingForBrand,
                'redemption_id' => $redemption->id,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Process public code redemption from QR scan.
     */
    public function redeemPublic(Request $request, string $qr_code): RedirectResponse
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        try {
            $brand = Brand::where('qr_code', $qr_code)->firstOrFail();

            // Validate code for this specific brand
            $validation = $this->universalCodeService->validateCode($request->code, $brand->id);

            if (!$validation['valid']) {
                return Redirect::back()
                    ->withInput()
                    ->withErrors(['code' => $validation['message']]);
            }

            $redemption = $this->universalCodeService->redeemCode(
                $validation['code'],
                $brand,
                null,
                'Public QR Scan',
                null
            );

            return Redirect::route('brands.vouchers.success', [
                'qr_code' => $qr_code,
                'redemption_id' => $redemption->id,
            ]);

        } catch (\Exception $e) {
            return Redirect::back()
                ->withInput()
                ->withErrors(['code' => 'An error occurred: ' . $e->getMessage()]);
        }
    }

    /**
     * Export codes to CSV.
     */
    public function export(Request $request): Response
    {
        $codes = UniversalCode::when($request->status, function ($query, $status) {
            return $query->where('status', $status);
        })->get();

        $filename = 'universal-codes-' . now()->format('Y-m-d-His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($codes) {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['Code', 'Status', 'Redemptions', 'Created At']);

            foreach ($codes as $code) {
                fputcsv($file, [
                    $code->code,
                    $code->status,
                    "{$code->redemption_count}/{$code->max_redemptions}",
                    $code->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
