<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Barrio extends Model
{
  use HasFactory;

  protected $table = 'barrios';

  protected $fillable = [
    'sector_id',
    'barrio',
  ];

  public function sector(): BelongsTo
  {
    return $this->belongsTo(\App\Models\Sector::class, 'sector_id');
  }
}
