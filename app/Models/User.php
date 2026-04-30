<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @method bool hasAnyRole(...$roles)
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'titulo',
        'metadescription',
        'descripcion',
        'telefono',
        'foto',
        'activo',
        'rol',
        'mostrar',
        'orden',
        'facebook',
        'instagram',
        'tiktok',
        'whatsapp',
        'requiere_aprobacion_propiedades',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'activo'            => 'boolean',
        'mostrar'           => 'boolean',
        'rol'               => 'integer',
        'orden'             => 'integer',
        'requiere_aprobacion_propiedades' => 'boolean',
    ];

    public function contacto(): BelongsTo
    {
        return $this->belongsTo(Clientes::class, 'captado_por', 'id');
    }

    public function adminlte_image()
    {
        return optional(Auth::user())->resolvePhotoUrl();
    }

    public function resolvePhotoUrl(?string $fallback = null): string
    {
        $defaultFallback = $fallback ?: asset('vendor/adminlte/dist/img/AdminLTELogo.png');
        $photo = trim((string) $this->foto);

        if ($photo === '') {
            return $defaultFallback;
        }

        if (Str::startsWith($photo, ['http://', 'https://', '//', 'data:'])) {
            return $photo;
        }

        if (Str::startsWith($photo, ['/assets/', 'assets/', '/img/', 'img/'])) {
            return asset(ltrim($photo, '/'));
        }

        return asset('assets/' . ltrim($photo, '/'));
    }

    public static function configuredSuperadminEmail(): ?string
    {
        $email = trim((string) config('security.superadmin_email'));

        return $email !== '' ? mb_strtolower($email) : null;
    }

    public static function superadminMutationsAllowed(): bool
    {
        return (bool) config('security.allow_superadmin_mutations', false);
    }

    public function isConfiguredSuperadmin(): bool
    {
        $configuredEmail = self::configuredSuperadminEmail();
        if (!$configuredEmail) {
            return false;
        }

        return mb_strtolower((string) $this->email) === $configuredEmail;
    }

    public function usesBootstrapSuperadminPassword(): bool
    {
        if (!$this->isConfiguredSuperadmin()) {
            return false;
        }

        $bootstrapPassword = trim((string) config('security.superadmin_bootstrap_password', ''));
        if ($bootstrapPassword === '') {
            return false;
        }

        return Hash::check($bootstrapPassword, (string) $this->password);
    }
}
