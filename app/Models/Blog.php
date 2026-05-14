<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'added_by',
        'image',
    ];

    protected static function booted(): void
    {
        static::creating(function ($blog) {
            $blog->slug = static::generateUniqueSlug($blog->title);
        });

        static::updating(function ($blog) {
            if ($blog->isDirty('title')) {
                $blog->slug = static::generateUniqueSlug($blog->title, $blog->id);
            }
        });
    }

    public static function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $slug     = Str::slug($title);
        $original = $slug;
        $count    = 1;

        while (
            static::where('slug', $slug)
                ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $original . '-' . $count++;
        }

        return $slug;
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    public function getImageUrlAttribute(): string
    {
        return $this->image
            ? asset('storage/' . $this->image)
            : asset('images/blog-placeholder.png');
    }
}