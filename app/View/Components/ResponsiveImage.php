<?php

namespace App\View\Components;

use App\Models\MediaImage;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\Component;

class ResponsiveImage extends Component
{
    public Collection $avif;
    public Collection $webp;
    public ?object $fallback;

    public function __construct(
        public MediaImage $image,
        public string $profile,
        public string $sizes = '100vw',
        public ?string $alt = null,
        public string $loading = 'lazy',
        public string $fetchpriority = 'auto',
        public bool $decodingAsync = true
    ) {
        $variants = $image->variants()
            ->where('profile', $profile)
            ->orderBy('width')
            ->get()
            ->groupBy('format');

        $this->avif = $variants->get('avif', collect());
        $this->webp = $variants->get('webp', collect());
        $this->fallback = $variants->get('jpg', collect())->last() ?? $this->webp->last();
    }

    public function url(object $variant): string
    {
        return Storage::disk($variant->disk)->url($variant->path);
    }

    public function srcset(Collection $variants): string
    {
        return $variants->map(fn (object $variant): string => $this->url($variant) . ' ' . $variant->width . 'w')->implode(', ');
    }

    public function render(): View
    {
        return view('components.responsive-image');
    }
}
