<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class DiagnoseQrStorage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'qr:diagnose';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Diagnose QR code storage issues on shared hosting';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== QR Code Storage Diagnostic ===');
        $this->newLine();

        // 1. Check storage paths
        $this->info('1. Storage Paths:');
        $publicPath = Storage::disk('public')->path('');
        $this->line("   Public disk path: {$publicPath}");
        $this->line("   Storage path: " . storage_path('app/public'));
        $this->line("   Public path: " . public_path('storage'));
        $this->newLine();

        // 2. Check if storage link exists
        $this->info('2. Storage Symlink:');
        $symlinkPath = public_path('storage');
        if (is_link($symlinkPath)) {
            $this->line("   ✓ Symlink exists at: {$symlinkPath}");
            $this->line("   Points to: " . readlink($symlinkPath));
        } else if (is_dir($symlinkPath)) {
            $this->warn("   ⚠ Directory exists (not a symlink): {$symlinkPath}");
        } else {
            $this->error("   ✗ Symlink does NOT exist at: {$symlinkPath}");
            $this->warn("   Run: php artisan storage:link");
        }
        $this->newLine();

        // 3. Check qrcodes directory
        $this->info('3. QR Codes Directory:');
        $qrcodesDir = 'qrcodes';
        if (Storage::disk('public')->exists($qrcodesDir)) {
            $this->line("   ✓ Directory exists: storage/app/public/{$qrcodesDir}");
            $fullPath = Storage::disk('public')->path($qrcodesDir);
            $this->line("   Full path: {$fullPath}");

            // Check permissions
            if (is_writable($fullPath)) {
                $this->line("   ✓ Directory is writable");
                $perms = substr(sprintf('%o', fileperms($fullPath)), -4);
                $this->line("   Permissions: {$perms}");
            } else {
                $this->error("   ✗ Directory is NOT writable");
                $this->warn("   Run: chmod 755 {$fullPath}");
            }
        } else {
            $this->warn("   ⚠ Directory does NOT exist");
            $this->info("   Creating directory...");
            Storage::disk('public')->makeDirectory($qrcodesDir);
            if (Storage::disk('public')->exists($qrcodesDir)) {
                $this->line("   ✓ Directory created successfully");
            } else {
                $this->error("   ✗ Failed to create directory");
            }
        }
        $this->newLine();

        // 4. Test QR code generation
        $this->info('4. QR Code Generation Test:');
        try {
            $testUrl = 'https://example.com/test';
            $qrCode = QrCode::format('svg')
                ->size(300)
                ->errorCorrection('H')
                ->generate($testUrl);

            if (!empty($qrCode)) {
                $this->line("   ✓ QR code SVG generated successfully");
                $this->line("   SVG size: " . strlen($qrCode) . " bytes");
            } else {
                $this->error("   ✗ QR code generation returned empty result");
            }
        } catch (\Exception $e) {
            $this->error("   ✗ QR code generation failed: " . $e->getMessage());
        }
        $this->newLine();

        // 5. Test file write
        $this->info('5. File Write Test:');
        $testFile = 'qrcodes/test_qr_' . time() . '.svg';
        try {
            $testContent = '<svg>test</svg>';
            $written = Storage::disk('public')->put($testFile, $testContent);

            if ($written) {
                $this->line("   ✓ File written successfully: {$testFile}");

                // Verify file exists
                if (Storage::disk('public')->exists($testFile)) {
                    $this->line("   ✓ File exists after write");
                    $fullPath = Storage::disk('public')->path($testFile);
                    $this->line("   Full path: {$fullPath}");
                    $this->line("   Public URL: " . asset('storage/' . $testFile));

                    // Clean up test file
                    Storage::disk('public')->delete($testFile);
                    $this->line("   ✓ Test file cleaned up");
                } else {
                    $this->error("   ✗ File does NOT exist after write");
                }
            } else {
                $this->error("   ✗ File write returned false");
            }
        } catch (\Exception $e) {
            $this->error("   ✗ File write failed: " . $e->getMessage());
        }
        $this->newLine();

        // 6. Check existing QR files
        $this->info('6. Existing QR Code Files:');
        try {
            $files = Storage::disk('public')->files($qrcodesDir);
            if (count($files) > 0) {
                $this->line("   Found " . count($files) . " QR code file(s):");
                foreach (array_slice($files, 0, 5) as $file) {
                    $size = Storage::disk('public')->size($file);
                    $this->line("   - {$file} ({$size} bytes)");
                }
                if (count($files) > 5) {
                    $this->line("   ... and " . (count($files) - 5) . " more");
                }
            } else {
                $this->line("   No QR code files found");
            }
        } catch (\Exception $e) {
            $this->error("   ✗ Failed to list files: " . $e->getMessage());
        }
        $this->newLine();

        // 7. Summary and recommendations
        $this->info('=== Recommendations ===');
        if (!is_link($symlinkPath)) {
            $this->warn('• Run: php artisan storage:link');
        }
        if (Storage::disk('public')->exists($qrcodesDir)) {
            $fullPath = Storage::disk('public')->path($qrcodesDir);
            if (!is_writable($fullPath)) {
                $this->warn("• Run: chmod 755 {$fullPath}");
            }
        }
        $this->info('• Check storage/logs/laravel.log for detailed error messages');
        $this->info('• Try creating a brand to test QR generation');

        return Command::SUCCESS;
    }
}
