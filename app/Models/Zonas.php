<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Zonas extends Model
{
    use HasFactory;

    protected $fillable = [
        'zona',
        'slug',
        'is_public',
        'seo_h1',
        'seo_title',
        'meta_description',
        'seo_description',
        'image',
        'image_alt',
    ];

    protected $casts = [
        'is_public' => 'boolean',
    ];

    public function setZonaAttribute($value): void
    {
        $normalized = preg_replace('/\s+/u', ' ', trim((string) $value));
        $this->attributes['zona'] = is_string($normalized) ? $normalized : '';
    }

    public function propiedades(): HasMany
    {
        return $this->hasMany(Propiedad::class, 'zona_id');
    }
}
