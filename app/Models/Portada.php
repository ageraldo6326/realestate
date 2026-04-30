<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portada extends Model
{
    use HasFactory;

    protected $fillable = [
       'minititulo',
       'titulo',
       'descripcion',
       'enlace1',
       'url1',
       'enlace2',
       'url2',
       'video',
       'foto',
       'slug',
       'activo'
    ];

    /**
     * Normalize legacy foto paths that are bare filenames (no directory prefix).
     * New uploads use /img/portada/uuid.webp; old records may have just the filename.
     */
    public function getFotoAttribute(?string $value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        // Already has a directory component — return as-is
        if (str_contains($value, '/')) {
            return $value;
        }

        // Bare filename from legacy uploads → assume assets/ folder
        return 'assets/' . $value;
    }
}
