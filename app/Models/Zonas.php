<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zonas extends Model
{
    use HasFactory;

    protected $fillable = [
        'zona'
    ];

    public function setZonaAttribute($value): void
    {
        $normalized = preg_replace('/\s+/u', ' ', trim((string) $value));
        $this->attributes['zona'] = is_string($normalized) ? $normalized : '';
    }
}
