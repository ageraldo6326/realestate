<?php

namespace App\Listeners;

use App\Events\PropertySaved;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Queue\ShouldQueue;

class ImagePropertyOptimizer implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\PropertySaved  $event
     * @return void
     */
    public function handle(PropertySaved $event)
    {




        try {

            if ($event->propiedad->foto_portada != null && $event->propiedad->foto_portada != "") {
                if ($event->propiedad->marcadeagua == 1) {

                    Image::make(Storage::disk('local')->get($event->propiedad->foto_portada))
                        ->encode('webp', 90)
                        ->limitColors(255)->fit(850, 650)
                        ->insert(Storage::disk('local')->get('inmobiliaria/logo.png'), 'center', 10, 10, 20)
                        ->save(public_path('assets/' . $event->propiedad->foto_portada));
                } else {
                    Image::make(Storage::disk('local')->get($event->propiedad->foto_portada))
                        ->encode('webp', 90)
                        ->limitColors(255)->fit(850, 650)
                        ->save(public_path('assets/' . $event->propiedad->foto_portada));
                }
            }

            if ($event->propiedad->foto1 != null && $event->propiedad->foto1 != "") {
                if ($event->propiedad->marcadeagua == 1) {
                    Image::make(Storage::disk('local')->get($event->propiedad->foto1))
                        ->encode('webp', 90)
                        ->limitColors(255)->fit(850, 650)
                        ->insert(Storage::disk('local')->get('inmobiliaria/logo.png'), 'center', 10, 10, 20)
                        ->save(public_path('assets/' . $event->propiedad->foto1));
                } else {
                    Image::make(Storage::disk('local')->get($event->propiedad->foto1))
                        ->encode('webp', 90)
                        ->limitColors(255)->fit(850, 650)
                        ->save(public_path('assets/' . $event->propiedad->foto1));
                }
            }

            if ($event->propiedad->foto2 != null && $event->propiedad->foto2 != "") {
                if ($event->propiedad->marcadeagua == 1) {
                    Image::make(Storage::disk('local')->get($event->propiedad->foto2))
                        ->encode('webp', 90)
                        ->limitColors(255)->fit(850, 650)
                        ->insert(Storage::disk('local')->get('inmobiliaria/logo.png'), 'center', 10, 10, 20)
                        ->save(public_path('assets/' . $event->propiedad->foto2));
                } else {
                    Image::make(Storage::disk('local')->get($event->propiedad->foto2))
                        ->encode('webp', 90)
                        ->limitColors(255)->fit(850, 650)
                        ->save(public_path('assets/' . $event->propiedad->foto2));
                }
            }

            if ($event->propiedad->foto3 != null && $event->propiedad->foto3 != "") {
                if ($event->propiedad->marcadeagua == 1) {
                    Image::make(Storage::disk('local')->get($event->propiedad->foto3))
                        ->encode('webp', 90)
                        ->limitColors(255)->fit(850, 650)
                        ->insert(Storage::disk('local')->get('inmobiliaria/logo.png'), 'center', 10, 10, 20)
                        ->save(public_path('assets/' . $event->propiedad->foto3));
                } else {
                    Image::make(Storage::disk('local')->get($event->propiedad->foto3))
                        ->encode('webp', 90)
                        ->limitColors(255)->fit(850, 650)
                        ->save(public_path('assets/' . $event->propiedad->foto3));
                }
            }

            if ($event->propiedad->foto4 != null && $event->propiedad->foto4 != "") {
                if ($event->propiedad->marcadeagua == 1) {
                    Image::make(Storage::disk('local')->get($event->propiedad->foto4))
                        ->encode('webp', 90)
                        ->limitColors(255)->fit(850, 650)
                        ->insert(Storage::disk('local')->get('inmobiliaria/logo.png'), 'center', 10, 10, 20)
                        ->save(public_path('assets/' . $event->propiedad->foto4));
                } else {
                    Image::make(Storage::disk('local')->get($event->propiedad->foto4))
                        ->encode('webp', 90)
                        ->limitColors(255)->fit(850, 650)
                        ->save(public_path('assets/' . $event->propiedad->foto4));
                }
            }

            if ($event->propiedad->foto5 != null && $event->propiedad->foto5 != "") {
                if ($event->propiedad->marcadeagua == 1) {
                    Image::make(Storage::disk('local')->get($event->propiedad->foto5))
                        ->encode('webp', 90)
                        ->limitColors(255)->fit(850, 650)
                        ->insert(Storage::disk('local')->get('inmobiliaria/logo.png'), 'center', 10, 10, 20)
                        ->save(public_path('assets/' . $event->propiedad->foto5));
                } else {
                    Image::make(Storage::disk('local')->get($event->propiedad->foto5))
                        ->encode('webp', 90)
                        ->limitColors(255)->fit(850, 650)
                        ->save(public_path('assets/' . $event->propiedad->foto5));
                }
            }

            if ($event->propiedad->foto6 != null && $event->propiedad->foto6 != "") {
                if ($event->propiedad->marcadeagua == 1) {
                    Image::make(Storage::disk('local')->get($event->propiedad->foto6))
                        ->encode('webp', 90)
                        ->limitColors(255)->fit(850, 650)
                        ->insert(Storage::disk('local')->get('inmobiliaria/logo.png'), 'center', 10, 10, 20)
                        ->save(public_path('assets/' . $event->propiedad->foto6));
                } else {
                    Image::make(Storage::disk('local')->get($event->propiedad->foto6))
                        ->encode('webp', 90)
                        ->limitColors(255)->fit(850, 650)
                        ->save(public_path('assets/' . $event->propiedad->foto6));
                }
            }

            if ($event->propiedad->foto7 != null && $event->propiedad->foto7 != "") {
                if ($event->propiedad->marcadeagua == 1) {
                    Image::make(Storage::disk('local')->get($event->propiedad->foto7))
                        ->encode('webp', 90)
                        ->limitColors(255)->fit(850, 650)
                        ->insert(Storage::disk('local')->get('inmobiliaria/logo.png'), 'center', 10, 10, 20)
                        ->save(public_path('assets/' . $event->propiedad->foto7));
                } else {
                    Image::make(Storage::disk('local')->get($event->propiedad->foto7))
                        ->encode('webp', 90)
                        ->limitColors(255)->fit(850, 650)
                        ->save(public_path('assets/' . $event->propiedad->foto7));
                }
            }

            if ($event->propiedad->foto8 != null && $event->propiedad->foto8 != "") {
                if ($event->propiedad->marcadeagua == 1) {
                    Image::make(Storage::disk('local')->get($event->propiedad->foto8))
                        ->encode('webp', 90)
                        ->limitColors(255)->fit(850, 650)
                        ->insert(Storage::disk('local')->get('inmobiliaria/logo.png'), 'center', 10, 10, 20)
                        ->save(public_path('assets/' . $event->propiedad->foto8));
                } else {
                    Image::make(Storage::disk('local')->get($event->propiedad->foto8))
                        ->encode('webp', 90)
                        ->limitColors(255)->fit(850, 650)
                        ->save(public_path('assets/' . $event->propiedad->foto8));
                }
            }
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }
}
