@if ($fallback !== null)
<picture>
    @if ($avif->isNotEmpty())
        <source type="image/avif" srcset="{{ $srcset($avif) }}" sizes="{{ $sizes }}">
    @endif
    @if ($webp->isNotEmpty())
        <source type="image/webp" srcset="{{ $srcset($webp) }}" sizes="{{ $sizes }}">
    @endif
    <img
        src="{{ $url($fallback) }}"
        width="{{ $fallback->width }}"
        height="{{ $fallback->height }}"
        alt="{{ $alt ?? $image->alt_text ?? '' }}"
        loading="{{ $loading }}"
        @if ($fetchpriority !== 'auto') fetchpriority="{{ $fetchpriority }}" @endif
        @if ($decodingAsync) decoding="async" @endif
        {{ $attributes }}
    >
</picture>
@endif
