<?php

return [
    'original_disk' => env('IMAGE_ORIGINAL_DISK', 'local'),
    'delivery_disk' => env('IMAGE_DELIVERY_DISK', 'real_public'),
    'queue' => env('IMAGE_QUEUE', 'images'),

    'max_upload_bytes' => (int) env('IMAGE_MAX_UPLOAD_BYTES', 12 * 1024 * 1024),
    'max_width' => (int) env('IMAGE_MAX_WIDTH', 6000),
    'max_height' => (int) env('IMAGE_MAX_HEIGHT', 6000),
    'max_pixels' => (int) env('IMAGE_MAX_PIXELS', 36000000),

    'accepted_mime_types' => [
        'image/jpeg',
        'image/png',
        'image/webp',
    ],

    'formats' => [
        'webp' => ['enabled' => true, 'quality' => 76],
        'jpg' => ['enabled' => true, 'quality' => 80],
        'avif' => ['enabled' => env('IMAGE_AVIF_ENABLED', false), 'quality' => 50],
    ],
];
