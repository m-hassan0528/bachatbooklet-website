# Brand Management - Quick Reference Guide

## 🚀 Quick Start

### Access Brand Management
1. Login: `http://localhost/login`
   - Email: `admin@bachatbooket.com`
   - Password: `BB@@1800`
2. Click "Brands" in navigation menu
3. Start managing brands!

---

## 📖 Common Tasks

### Create a Brand
```
1. Click "Create Brand" button
2. Enter Brand Name (required)
3. Enter Description (optional)
4. Check/uncheck "Active" checkbox
5. Click "Create"

✓ QR code auto-generated
✓ Slug auto-created from name
✓ QR image saved as SVG
```

### Edit a Brand
```
1. Find brand in listing
2. Click "Edit"
3. Update name/description/status
4. Click "Update"

Note: QR code and slug cannot be changed
```

### Delete a Brand
```
1. Find brand in listing
2. Click "Delete"
3. Confirm deletion

✓ Brand soft-deleted (data retained)
✓ QR image removed from storage
```

### View QR Code
```
1. Click "Edit" on any brand
2. Scroll to "QR Code Information" section
3. View QR code and image
4. Click destination URL to test
```

---

## 🔑 Key Features

### Auto-Generated Fields
When you create a brand, the system automatically generates:

| Field | Example | Description |
|-------|---------|-------------|
| QR Code | `AB12XYZ789` | Unique 10-character code |
| Slug | `test-restaurant` | SEO-friendly URL |
| QR Image | `qrcode_AB12XYZ789.svg` | SVG format, 300x300px |

### QR Code Destination
All QR codes redirect to:
```
http://localhost/brands/{QR_CODE}/vouchers
```

Example:
```
http://localhost/brands/AB12XYZ789/vouchers
```

---

## 📁 File Locations

### QR Code Images
```
Storage: storage/app/public/qrcodes/
Public URL: /storage/qrcodes/qrcode_{CODE}.svg
Format: SVG (Scalable Vector Graphics)
Size: ~5-6 KB per file
```

### Views
```
List: resources/views/brands/index.blade.php
Create: resources/views/brands/create.blade.php
Edit: resources/views/brands/edit.blade.php
Public: resources/views/brands/vouchers.blade.php
```

### Controllers
```
Main: app/Http/Controllers/BrandController.php
Methods: index, create, store, edit, update, destroy
```

### Models
```
Brand: app/Models/Brand.php
Soft Deletes: Enabled
Fillable: name, slug, qr_code, qr_code_image, description, status
```

---

## 🛠️ Troubleshooting

### QR Codes Not Displaying
```bash
# Check storage link exists
ls -la public/storage

# If not, create it
php artisan storage:link

# Check file permissions
chmod -R 755 storage/app/public/qrcodes
```

### Can't Access Brands Page (403 Error)
```sql
-- Check if user is admin
SELECT id, name, email, is_admin FROM users;

-- Make user admin
UPDATE users SET is_admin = 1 WHERE email = 'your@email.com';
```

### Routes Not Working
```bash
# Clear route cache
php artisan route:clear

# List routes to verify
php artisan route:list --path=brands
```

### Views Not Updating
```bash
# Clear view cache
php artisan view:clear

# Clear all caches
php artisan optimize:clear
```

---

## 🔒 Security Notes

### Who Can Access What?

| Route | Access | Middleware |
|-------|--------|-----------|
| `/brands` (all CRUD) | Admin only | `auth, admin` |
| `/brands/{qr}/vouchers` | Everyone | None |

### Admin Check
```php
// In Blade views
@if(Auth::user()->is_admin)
    // Admin only content
@endif

// In controllers (handled by middleware)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('brands', BrandController::class);
});
```

---

## 🧪 Testing

### Test QR Code Generation
```bash
php artisan tinker

# Generate test QR code
$service = new \App\Services\QrCodeService();
$code = $service->generateUniqueCode();
$path = $service->generateQrImage($code, 'http://test.com');

# Check file exists
\Storage::disk('public')->exists($path);
```

### Test Brand Creation
```bash
php artisan tinker

# Create test brand
$brand = \App\Models\Brand::create([
    'name' => 'Test Brand',
    'slug' => 'test-brand',
    'description' => 'Test Description',
    'qr_code' => 'TEST123456',
    'qr_code_image' => 'qrcodes/test.svg',
    'status' => 'active'
]);

# Verify
$brand->is_active; // Should return true
```

---

## 📊 Database Queries

### Get All Active Brands
```php
Brand::where('status', 'active')->get();
```

### Get Brands with Pagination
```php
Brand::latest()->paginate(15);
```

### Find Brand by QR Code
```php
Brand::where('qr_code', 'AB12XYZ789')->first();
```

### Get Deleted Brands (Soft Deleted)
```php
Brand::onlyTrashed()->get();
```

### Restore Deleted Brand
```php
$brand = Brand::onlyTrashed()->find($id);
$brand->restore();
```

### Permanently Delete Brand
```php
$brand = Brand::onlyTrashed()->find($id);
$brand->forceDelete();
```

---

## 💡 Tips & Best Practices

### Brand Names
- Keep names concise (max 255 characters)
- Use descriptive names (e.g., "ABC Restaurant" not "ABC")
- Avoid special characters that break URLs

### Descriptions
- Optional but recommended
- Max 1000 characters
- Include key information about the brand
- Visible on public QR scan page

### QR Codes
- QR codes are **immutable** (cannot be changed)
- Each QR code is unique
- Test QR codes on real devices before printing
- SVG format scales perfectly for any size

### Performance
- Pagination is set to 15 brands per page
- QR images are lightweight (~5KB each)
- Use soft deletes to maintain data integrity

---

## 🔄 Maintenance Tasks

### Clean Up Old QR Images
```bash
# List all QR images
ls -lh storage/app/public/qrcodes/

# Remove orphaned images (manually for now)
# Future: implement cleanup command
```

### Backup QR Images
```bash
# Backup entire qrcodes directory
tar -czf qrcodes-backup-$(date +%Y%m%d).tar.gz storage/app/public/qrcodes/

# Or use rsync
rsync -av storage/app/public/qrcodes/ /backup/location/
```

### Export Brands List
```bash
php artisan tinker

# Export to JSON
file_put_contents('brands.json', \App\Models\Brand::all()->toJson());

# Export to CSV (requires maatwebsite/excel - already installed)
# Implement in future version
```

---

## 📞 Quick Commands Reference

```bash
# Clear all caches
php artisan optimize:clear

# Clear specific caches
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Create storage link
php artisan storage:link

# List all routes
php artisan route:list

# List brand routes only
php artisan route:list --path=brands

# Open Laravel tinker
php artisan tinker

# Run migrations
php artisan migrate

# Check migration status
php artisan migrate:status
```

---

## 📚 Related Documentation

- **Full Work Log:** `WORK_LOG.md`
- **Changelog:** `CHANGELOG.md`
- **Laravel Docs:** https://laravel.com/docs/10.x
- **QR Package:** https://github.com/SimpleSoftwareIO/simple-qrcode

---

## ❓ FAQ

### Can I change a brand's QR code after creation?
**No.** QR codes are immutable to prevent broken links. If you need a new QR code, create a new brand.

### Why use SVG format for QR codes?
**Benefits:**
- No PHP extensions required (no imagick)
- Scalable to any size without quality loss
- Smaller file size than PNG
- Perfect for web and print

### How do I make a regular user an admin?
```sql
UPDATE users SET is_admin = 1 WHERE email = 'user@example.com';
```

### Can I customize QR code colors?
**Not currently.** Default is black on white. This can be added as a future feature.

### What happens to vouchers when I delete a brand?
**Currently:** Brands can be deleted independently. In the future, you may want to prevent deletion of brands with active vouchers or cascade the deletion.

### How do I restore a deleted brand?
```php
php artisan tinker
$brand = \App\Models\Brand::onlyTrashed()->where('id', 1)->first();
$brand->restore();
```

---

## 🎯 Next Steps

After mastering brand management, consider:
1. Implementing voucher listing on QR scan page
2. Adding brand logo upload
3. Tracking QR code scans with analytics
4. Implementing bulk operations
5. Adding advanced search and filters

---

**Need Help?**
- Check `WORK_LOG.md` for detailed technical documentation
- Review `CHANGELOG.md` for recent changes
- Test features in `php artisan tinker`

---

*Last Updated: December 21, 2025*
