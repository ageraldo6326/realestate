<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MediaImageVariant extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'media_image_id', 'disk', 'profile', 'format', 'width', 'height',
        'bytes', 'path', 'checksum',
    ];

    protected $casts = [
        'width' => 'integer',
        'height' => 'integer',
        'bytes' => 'integer',
    ];

    public function mediaImage(): BelongsTo
    {
        return $this->belongsTo(MediaImage::class);
    }
}
