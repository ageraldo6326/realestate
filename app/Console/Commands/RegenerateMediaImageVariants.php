<?php

namespace App\Console\Commands;

use App\Jobs\ProcessMediaImage;
use App\Models\MediaImage;
use App\Services\Images\ImageProfile;
use Illuminate\Console\Command;

class RegenerateMediaImageVariants extends Command
{
    protected $signature = 'media:images:regenerate {imageId? : ID de una imagen del catálogo} {--profile= : Perfil concreto a regenerar}';
    protected $description = 'Encola la regeneración segura de variantes de imágenes ya registradas.';

    public function handle(): int
    {
        $profile = $this->option('profile');
        if ($profile !== null && $profile !== '' && ! array_key_exists($profile, ImageProfile::all())) {
            $this->error('El perfil indicado no existe.');

            return self::INVALID;
        }

        $query = MediaImage::query()->orderBy('id');
        if ($id = $this->argument('imageId')) {
            $query->whereKey($id);
        }

        $count = 0;
        $query->chunkById(100, function ($images) use ($profile, &$count): void {
            foreach ($images as $image) {
                ProcessMediaImage::dispatch($image->id, $profile)
                    ->onQueue((string) config('images.queue'));
                $count++;
            }
        });

        $this->info("Se encolaron {$count} imágenes para procesar.");

        return self::SUCCESS;
    }
}
