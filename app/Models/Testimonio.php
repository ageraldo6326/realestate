<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonio extends Model
{
    use HasFactory;

    protected $fillable = [
        'testimonio',
        'cliente',
        'cliente_foto',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    /**
     * Normalize legacy cliente_foto paths that are bare filenames (no directory prefix).
     * New uploads use /img/testimonios/uuid.webp; old records may have just the filename.
     */
    public function getClienteFotoAttribute(?string $value): ?string
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
