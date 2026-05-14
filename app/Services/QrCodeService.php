<?php

namespace App\Services;

use App\Models\Brand;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Exception;

class QrCodeService
{
    /**
     * Generate a unique QR code string.
     *
     * @return string
     */
    public function generateUniqueCode(): string
    {
        do {
            // Generate 10-character alphanumeric code
            $code = strtoupper(Str::random(10));
        } while (Brand::where('qr_code', $code)->exists());

        return $code;
    }

    /**
     * Generate and store QR code image.
     *
     * @param string $qrCode The QR code string
     * @param string $url The URL to encode in the QR code
     * @return string The stored file path
     * @throws Exception If QR code generation or storage fails
     */
    public function generateQrImage(string $qrCode, string $url): string
    {
        try {
            // Ensure qrcodes directory exists
            $this->ensureDirectoryExists();

            // Generate QR code as SVG (no imagick required)
            $qrImage = QrCode::format('svg')
                ->size(300)
                ->errorCorrection('H')
                ->generate($url);

            if (empty($qrImage)) {
                throw new Exception('QR code generation returned empty result');
            }

            // Define file path
            $fileName = "qrcode_{$qrCode}.svg";
            $filePath = "qrcodes/{$fileName}";

            // Store in public disk
            $stored = Storage::disk('public')->put($filePath, $qrImage);

            if (!$stored) {
                throw new Exception("Failed to store QR code image at: {$filePath}");
            }

            // Verify file was actually created
            if (!Storage::disk('public')->exists($filePath)) {
                throw new Exception("QR code file does not exist after storage attempt: {$filePath}");
            }

            Log::info("QR code generated successfully", [
                'qr_code' => $qrCode,
                'file_path' => $filePath,
                'url' => $url,
                'storage_path' => Storage::disk('public')->path($filePath)
            ]);

            return $filePath;

        } catch (Exception $e) {
            Log::error("QR code generation failed", [
                'qr_code' => $qrCode,
                'url' => $url,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            throw new Exception("Failed to generate QR code: " . $e->getMessage());
        }
    }

    /**
     * Ensure the qrcodes directory exists in storage.
     *
     * @return void
     */
    private function ensureDirectoryExists(): void
    {
        $directory = 'qrcodes';

        if (!Storage::disk('public')->exists($directory)) {
            Storage::disk('public')->makeDirectory($directory);
            Log::info("Created qrcodes directory in storage");
        }
    }

    /**
     * Delete QR code image from storage.
     *
     * @param string|null $filePath
     * @return bool
     */
    public function deleteQrImage(?string $filePath): bool
    {
        if ($filePath && Storage::disk('public')->exists($filePath)) {
            return Storage::disk('public')->delete($filePath);
        }

        return false;
    }

    /**
     * Generate a unique slug from brand name.
     *
     * @param string $name
     * @return string
     */
    public function generateSlug(string $name): string
    {
        $slug = Str::slug($name);
        $count = 1;
        $originalSlug = $slug;

        while (Brand::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }

    /**
     * Get the full URL for the QR code destination.
     *
     * @param string $qrCode
     * @return string
     */
    public function getQrUrl(string $qrCode): string
    {
        return route('brands.vouchers', ['qr_code' => $qrCode]);
    }
}
