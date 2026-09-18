<?php

namespace Tests\Feature;

use App\Services\PropertyCardThumbnailService;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class PropertyCardThumbnailServiceTest extends TestCase
{
    private ?string $sourcePath = null;
    private ?string $thumbnailPath = null;

    protected function tearDown(): void
    {
        foreach ([$this->sourcePath, $this->thumbnailPath] as $path) {
            if ($path && is_file($path)) {
                @unlink($path);
            }
        }

        parent::tearDown();
    }

    public function test_it_creates_a_webp_card_derivative_without_changing_the_source(): void
    {
        $relativeSource = 'assets/testing/property-thumbnail-' . uniqid('', true) . '.jpg';
        $this->sourcePath = public_path($relativeSource);
        File::ensureDirectoryExists(dirname($this->sourcePath));

        $image = imagecreatetruecolor(960, 640);
        imagefill($image, 0, 0, imagecolorallocate($image, 42, 107, 162));
        imagejpeg($image, $this->sourcePath, 85);
        imagedestroy($image);
        $sourceMtime = filemtime($this->sourcePath);

        $service = app(PropertyCardThumbnailService::class);
        $thumbnailUrl = $service->create('/' . $relativeSource);

        $this->assertNotNull($thumbnailUrl);
        $this->assertSame($thumbnailUrl, $service->urlFor('/' . $relativeSource));
        $this->assertSame($sourceMtime, filemtime($this->sourcePath));

        $this->thumbnailPath = public_path(ltrim((string) parse_url($thumbnailUrl, PHP_URL_PATH), '/'));
        $this->assertFileExists($this->thumbnailPath);
        $this->assertSame(480, getimagesize($this->thumbnailPath)[0]);
        $this->assertSame('image/webp', mime_content_type($this->thumbnailPath));
    }

    public function test_it_never_creates_derivatives_for_external_or_unsafe_paths(): void
    {
        $service = app(PropertyCardThumbnailService::class);

        $this->assertNull($service->create('https://example.com/property.jpg'));
        $this->assertNull($service->create('../.env'));
    }
}
