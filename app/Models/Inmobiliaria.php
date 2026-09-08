<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Inmobiliaria extends Model
{
    use HasFactory;

    protected $casts = [
        'aprobacion' => 'boolean',
    ];

    protected $fillable = [
        'nombre',
        'correo',
        'direccion',
        'telefono',
        'titulo',
        'metadescription',
        'facebook',
        'instagram',
        'tiktok',
        'whatsapp',
        'quienessomos',
        'logo',
        'favicon',
        'slogan',
        'palabrasclaves',
        'aprobacion',
        'dias_propiedad_contactos',
        'dominio',
        'logo_color_1',
        'logo_color_2',
        'logo_color_3',
        'logo_color_4',
        'theme_color_primary',
        'theme_color_secondary',
        'theme_color_accent',
        'theme_color_neutral',
        'theme_source',
        'theme_last_logo_hash',
        'previous_theme_color_primary',
        'previous_theme_color_secondary',
        'previous_theme_color_accent',
        'previous_theme_color_neutral',
        'previous_theme_source',
    ];

    public function publicLogoUrl(): ?string
    {
        return $this->publicAssetUrl($this->logo);
    }

    public function publicFaviconUrl(): ?string
    {
        return $this->publicAssetUrl($this->favicon);
    }

    private function publicAssetUrl(?string $path): ?string
    {
        $path = trim((string) $path);

        if ($path === '') {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://', '//', 'data:'])) {
            return $path;
        }

        if (Str::startsWith($path, ['/img/', 'img/', '/assets/', 'assets/', '/storage/', 'storage/'])) {
            return url('/' . ltrim($path, '/'));
        }

        return asset('assets/' . ltrim($path, '/'));
    }
}
