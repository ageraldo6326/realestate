<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sector extends Model
{
  use HasFactory;

  protected $table = 'sectores';

  protected $fillable = [
    'provincia_id',
    'sector',
  ];

  public function provincia(): BelongsTo
  {
    return $this->belongsTo(provincia::class, 'provincia_id');
  }

  public function barrios(): HasMany
  {
    return $this->hasMany(\App\Models\Barrio::class, 'sector_id');
  }
}
