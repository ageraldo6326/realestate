<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @method bool hasAnyRole(...$roles)
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

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
    ];

    public function contacto(): BelongsTo
    {
        return $this->belongsTo(Clientes::class, 'captado_por', 'id');
    }

    public function adminlte_image()
    {
        return asset('assets/' . Auth::user()->foto);
    }
}
