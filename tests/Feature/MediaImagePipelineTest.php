<?php

namespace Tests\Feature;

use App\Jobs\ProcessMediaImage;
use App\Models\MediaImage;
use App\Models\MediaImageVariant;
use App\Services\Images\ImageUploadService;
use App\Services\Images\PropertyImageService;
use App\Models\Propiedad;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MediaImagePipelineTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('local');
        Storage::fake('real_public');
        config()->set('images.delivery_disk', 'real_public');
        config()->set('images.original_disk', 'local');
        config()->set('images.formats.avif.enabled', false);
    }

    public function test_upload_stores_a_private_original_and_queues_the_requested_profile(): void
    {
        Queue::fake();
        $file = UploadedFile::fake()->image('casa.jpg', 1000, 750)->size(300);

        $image = app(ImageUploadService::class)->store($file, 'home_card', null, null, 'Casa frente al mar');

        $this->assertDatabaseHas('media_images', [
            'id' => $image->id,
            'status' => MediaImage::STATUS_PENDING,
            'original_mime_type' => 'image/jpeg',
        ]);
        Storage::disk('local')->assertExists($image->original_path);
        Queue::assertPushed(ProcessMediaImage::class, 1);
    }

    public function test_job_generates_only_variants_for_the_selected_profile(): void
    {
        Queue::fake();
        $file = UploadedFile::fake()->image('casa.jpg', 1000, 750)->size(300);
        $image = app(ImageUploadService::class)->store($file, 'home_card');

        (new ProcessMediaImage($image->id, 'home_card'))->handle(app(\App\Services\Images\ImageProcessingService::class));

        $this->assertSame(MediaImage::STATUS_READY, $image->fresh()->status);
        $this->assertSame(8, MediaImageVariant::where('media_image_id', $image->id)->count());
        $this->assertSame(4, MediaImageVariant::where('media_image_id', $image->id)->where('format', 'webp')->count());
        Storage::disk('real_public')->assertExists(MediaImageVariant::where('media_image_id', $image->id)->firstOrFail()->path);
    }

    public function test_responsive_component_renders_picture_sources_and_reserved_dimensions(): void
    {
        $image = MediaImage::create([
            'disk' => 'local', 'original_path' => 'media/originals/test.jpg', 'original_mime_type' => 'image/jpeg',
            'original_width' => 960, 'original_height' => 720, 'original_bytes' => 123, 'checksum' => str_repeat('a', 64),
            'alt_text' => 'Propiedad de prueba', 'status' => MediaImage::STATUS_READY,
        ]);
        foreach (['webp', 'jpg'] as $format) {
            MediaImageVariant::create([
                'media_image_id' => $image->id, 'disk' => 'real_public', 'profile' => 'home_card', 'format' => $format,
                'width' => 480, 'height' => 360, 'bytes' => 100, 'path' => "media/{$format}.{$format}", 'checksum' => str_repeat($format === 'webp' ? 'b' : 'c', 64),
            ]);
        }

        $this->blade('<x-responsive-image :image="$image" profile="home_card" sizes="50vw" />', ['image' => $image])
            ->assertSee('<picture>', false)
            ->assertSee('type="image/webp"', false)
            ->assertSee('width="480"', false)
            ->assertSee('height="360"', false)
            ->assertSee('loading="lazy"', false)
            ->assertSee('alt="Propiedad de prueba"', false);
    }

    public function test_property_upload_is_kept_private_until_the_webp_variant_is_ready(): void
    {
        Queue::fake();
        $property = Propiedad::create([
            'referencia' => 'PROP-TEST-0001',
            'titulo' => 'Propiedad con imagen centralizada',
            'foto_portada' => '',
        ]);
        $media = app(PropertyImageService::class)->store(
            UploadedFile::fake()->image('portada.jpg', 1000, 750)->size(300),
            $property,
            'foto_portada'
        );

        Storage::disk('local')->assertExists($media->original_path);
        $this->assertSame('', $property->fresh()->foto_portada);

        (new \App\Jobs\ProcessPropertyMediaImage($media->id))->handle(
            app(\App\Services\Images\ImageProcessingService::class),
            app(PropertyImageService::class)
        );

        $this->assertSame(MediaImage::STATUS_READY, $media->fresh()->status);
        $this->assertStringContainsString('/media/images/', $property->fresh()->foto_portada);
    }
}
