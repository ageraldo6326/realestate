<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'autor',
        'palabraclave',
        'contenido',
        'foto',
        'metadescription',
        'seo_title',
        'activo',
        'status',
        'published_at',
        'image_alt',
        'image_credit',
        'slug',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('activo', true)
            ->where('status', 'published')
            ->where(function (Builder $nested): void {
                $nested->whereNull('published_at')->orWhere('published_at', '<=', now());
            });
    }

    /**
     * Normalize legacy foto paths that are bare filenames (no directory prefix).
     * New uploads use /img/posts/uuid.webp; old records may have just the filename.
     */
    public function getFotoAttribute(?string $value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (str_contains($value, '/')) {
            return $value;
        }

        return 'assets/' . $value;
    }
}
