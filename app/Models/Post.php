<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'activo',
        'slug',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

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
