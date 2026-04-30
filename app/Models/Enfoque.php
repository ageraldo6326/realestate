<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enfoque extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'enfoque',
        'foto',
    ];

    /**
     * Normalize legacy foto paths that are bare filenames (no directory prefix).
     * New uploads use /img/enfoques/uuid.webp; old records may have just the filename.
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
