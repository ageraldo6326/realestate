<?php

namespace App\Services;

use App\Models\Post;
use App\Models\Propiedad;
use App\Models\Zonas;
use InvalidArgumentException;

class CanonicalUrlService
{
    public function for(string $type, $entity = null): string
    {
        switch ($type) {
            case 'page':
                return $this->forPage((string) $entity);
            case 'property':
                return app(SeoMetadataService::class)->canonicalForRoute('propiedad', ['slug' => $entity->slug]);
            case 'zone':
                return app(SeoMetadataService::class)->canonicalForRoute('propiedadesPorZona', ['zona' => $entity->slug]);
            case 'post':
                return app(SeoMetadataService::class)->canonicalForRoute('post.show', ['slug' => $entity->slug]);
            case 'type':
                return app(SeoMetadataService::class)->canonicalForRoute('propiedadesPorTipo', ['tipo' => $entity]);
        }

        throw new InvalidArgumentException("Tipo de URL SEO no soportado: {$type}");
    }

    public function typeFor($entity): string
    {
        if ($entity instanceof Propiedad) {
            return 'property';
        }

        if ($entity instanceof Zonas) {
            return 'zone';
        }

        if ($entity instanceof Post) {
            return 'post';
        }

        throw new InvalidArgumentException('La entidad no tiene un tipo SEO compatible.');
    }

    public function publicPages(): array
    {
        return ['home', 'catalog', 'blog', 'contact', 'about', 'team'];
    }

    private function forPage(string $page): string
    {
        $routeByPage = [
            'home' => 'home',
            'catalog' => 'listapropiedades',
            'blog' => 'blog',
            'contact' => 'contactos',
            'about' => 'quienessomos',
            'team' => 'equipo',
        ];

        if (!isset($routeByPage[$page])) {
            throw new InvalidArgumentException("Página SEO no soportada: {$page}");
        }

        return app(SeoMetadataService::class)->canonicalForRoute($routeByPage[$page]);
    }
}
