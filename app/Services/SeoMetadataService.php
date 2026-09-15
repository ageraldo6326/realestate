<?php

namespace App\Services;

use App\Models\Post;
use App\Models\Zonas;
use Illuminate\Support\Str;

class SeoMetadataService
{
    public function canonicalForRoute(string $routeName, array $parameters = [], ?int $page = null): string
    {
        $path = route($routeName, $parameters, false);
        $canonical = $this->absoluteUrl($path);

        if ($page !== null && $page > 1) {
            $canonical .= '?page=' . $page;
        }

        return $canonical;
    }

    public function canonicalForCurrentPath(): string
    {
        return $this->absoluteUrl('/' . ltrim(request()->path(), '/'));
    }

    public function forHome($company): array
    {
        $name = $this->companyName($company);
        $description = $this->description(
            optional($company)->metadescription,
            'Compra, venta y alquiler de propiedades con asesoría inmobiliaria profesional en República Dominicana.'
        );
        $canonical = $this->canonicalForRoute('home');
        $logo = $this->absoluteAssetUrl(optional($company)->logo);

        $organization = array_filter([
            '@context' => 'https://schema.org',
            '@type' => ['Organization', 'RealEstateAgent'],
            '@id' => $canonical . '#organization',
            'name' => $name,
            'url' => $canonical,
            'logo' => $logo,
            'email' => optional($company)->correo,
            'telephone' => optional($company)->telefono,
            'address' => optional($company)->direccion,
        ]);

        return $this->metadata(
            $name . ' | Bienes raíces en República Dominicana',
            $description,
            $canonical,
            $logo,
            'website',
            [$organization]
        );
    }

    public function forCatalog($company, ?int $page = null): array
    {
        return $this->metadata(
            'Propiedades en venta y alquiler | ' . $this->companyName($company),
            'Explora propiedades disponibles en venta y alquiler y encuentra la opción ideal para vivir o invertir.',
            $this->canonicalForRoute('listapropiedades', [], $page),
            $this->absoluteAssetUrl(optional($company)->logo),
            'website',
            [$this->breadcrumb([
                ['name' => 'Inicio', 'url' => $this->canonicalForRoute('home')],
                ['name' => 'Propiedades', 'url' => $this->canonicalForRoute('listapropiedades')],
            ])]
        );
    }

    public function forProperty($property, $company): array
    {
        $canonical = $this->canonicalForRoute('propiedad', ['slug' => $property->slug]);
        $title = $this->title(($property->titulo ?: 'Propiedad disponible') . ' | ' . $this->companyName($company));
        $description = $this->description(
            $property->metadescription ?? $property->metadescripcion ?? null,
            $property->descripcion_corta ?? $property->descripcion ?? $title
        );
        $image = $this->absoluteAssetUrl($property->foto_portada ?? null);

        $schema = array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            '@id' => $canonical . '#listing',
            'name' => $property->titulo,
            'description' => $description,
            'url' => $canonical,
            'image' => $image ? [$image] : null,
            'sku' => $property->referencia ?? null,
            'offers' => !empty($property->precio) ? array_filter([
                '@type' => 'Offer',
                'price' => (float) $property->precio,
                'priceCurrency' => $this->currencyCode($property->Moneda ?? null),
                'availability' => 'https://schema.org/InStock',
                'url' => $canonical,
            ]) : null,
        ]);

        $breadcrumbs = [
            ['name' => 'Inicio', 'url' => $this->canonicalForRoute('home')],
            ['name' => 'Propiedades', 'url' => $this->canonicalForRoute('listapropiedades')],
        ];

        if (!empty($property->zona_slug) && !empty($property->zona_publica)) {
            $breadcrumbs[] = [
                'name' => (string) $property->zona,
                'url' => $this->canonicalForRoute('propiedadesPorZona', ['zona' => $property->zona_slug]),
            ];
        }

        $breadcrumbs[] = ['name' => (string) $property->titulo, 'url' => $canonical];

        return $this->metadata($title, $description, $canonical, $image, 'product', [
            $schema,
            $this->breadcrumb($breadcrumbs),
        ]);
    }

    public function forZone(Zonas $zone, $company, ?int $page = null): array
    {
        $canonical = $this->canonicalForRoute('propiedadesPorZona', ['zona' => $zone->slug], $page);
        $name = $zone->seo_h1 ?: $zone->zona;

        return $this->metadata(
            $zone->seo_title ?: 'Propiedades en ' . $zone->zona . ' | ' . $this->companyName($company),
            $this->description($zone->meta_description, 'Descubre propiedades disponibles en ' . $zone->zona . '.'),
            $canonical,
            $this->absoluteAssetUrl($zone->image),
            'website',
            [$this->breadcrumb([
                ['name' => 'Inicio', 'url' => $this->canonicalForRoute('home')],
                ['name' => 'Propiedades', 'url' => $this->canonicalForRoute('listapropiedades')],
                ['name' => $name, 'url' => $canonical],
            ])]
        );
    }

    public function forBlog($company, ?int $page = null): array
    {
        return $this->metadata(
            'Blog inmobiliario | ' . $this->companyName($company),
            'Consejos, noticias y análisis para comprar, vender e invertir en bienes raíces.',
            $this->canonicalForRoute('blog', [], $page),
            $this->absoluteAssetUrl(optional($company)->logo),
            'website',
            [$this->breadcrumb([
                ['name' => 'Inicio', 'url' => $this->canonicalForRoute('home')],
                ['name' => 'Blog', 'url' => $this->canonicalForRoute('blog')],
            ])]
        );
    }

    public function forPost(Post $post, $company): array
    {
        $canonical = $this->canonicalForRoute('post.show', ['slug' => $post->slug]);
        $description = $this->description($post->metadescription, $post->contenido);
        $image = $this->absoluteAssetUrl($post->foto);
        $publishedAt = optional($post->published_at ?: $post->created_at)->toAtomString();
        $modifiedAt = optional($post->updated_at)->toAtomString();

        $posting = array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            '@id' => $canonical . '#article',
            'headline' => $post->seo_title ?: $post->titulo,
            'description' => $description,
            'url' => $canonical,
            'mainEntityOfPage' => $canonical,
            'image' => $image,
            'datePublished' => $publishedAt,
            'dateModified' => $modifiedAt,
            'author' => $post->autor ? ['@type' => 'Person', 'name' => $post->autor] : null,
            'publisher' => ['@type' => 'Organization', 'name' => $this->companyName($company)],
        ]);

        return $this->metadata(
            $post->seo_title ?: $post->titulo . ' | ' . $this->companyName($company),
            $description,
            $canonical,
            $image,
            'article',
            [$posting, $this->breadcrumb([
                ['name' => 'Inicio', 'url' => $this->canonicalForRoute('home')],
                ['name' => 'Blog', 'url' => $this->canonicalForRoute('blog')],
                ['name' => $post->titulo, 'url' => $canonical],
            ])]
        );
    }

    public function forType($type, $company): array
    {
        $slug = Str::slug((string) $type->tipo);
        $canonical = $this->canonicalForRoute('propiedadesPorTipo', ['tipo' => $slug]);

        return $this->metadata(
            $type->tipo . ' en venta | ' . $this->companyName($company),
            'Explora ' . strtolower((string) $type->tipo) . ' disponibles y recibe asesoría inmobiliaria profesional.',
            $canonical,
            $this->absoluteAssetUrl(optional($company)->logo),
            'website',
            [$this->breadcrumb([
                ['name' => 'Inicio', 'url' => $this->canonicalForRoute('home')],
                ['name' => 'Propiedades', 'url' => $this->canonicalForRoute('listapropiedades')],
                ['name' => (string) $type->tipo, 'url' => $canonical],
            ])]
        );
    }

    public function forContact($company): array
    {
        $canonical = $this->canonicalForRoute('contactos');
        $name = $this->companyName($company);
        $logo = $this->absoluteAssetUrl(optional($company)->logo);

        return $this->metadata(
            'Contacto | ' . $name,
            'Contacta a nuestro equipo para comprar, vender o alquilar propiedades en República Dominicana.',
            $canonical,
            $logo,
            'website',
            [array_filter([
                '@context' => 'https://schema.org',
                '@type' => ['Organization', 'RealEstateAgent'],
                'name' => $name,
                'url' => $this->canonicalForRoute('home'),
                'logo' => $logo,
                'email' => optional($company)->correo,
                'telephone' => optional($company)->telefono,
                'address' => optional($company)->direccion,
            ])]
        );
    }

    private function metadata(
        string $title,
        string $description,
        string $canonical,
        ?string $image,
        string $type,
        array $schema
    ): array {
        return [
            'title' => $this->title($title),
            'description' => $this->description($description, ''),
            'canonical' => $canonical,
            'image' => $image,
            'type' => $type,
            'robots' => config('seo.indexing_enabled') ? 'index, follow' : 'noindex, nofollow',
            'schema' => array_values(array_filter($schema)),
        ];
    }

    private function breadcrumb(array $items): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => array_map(static function (array $item, int $index): array {
                return [
                    '@type' => 'ListItem',
                    'position' => $index + 1,
                    'name' => $item['name'],
                    'item' => $item['url'],
                ];
            }, $items, array_keys($items)),
        ];
    }

    private function absoluteUrl(string $path): string
    {
        $baseUrl = rtrim((string) config('seo.canonical_url', config('app.url')), '/');

        return $baseUrl . '/' . ltrim($path, '/');
    }

    private function absoluteAssetUrl(?string $path): ?string
    {
        $path = trim((string) $path);

        if ($path === '') {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://', '//'])) {
            return Str::startsWith($path, '//') ? 'https:' . $path : $path;
        }

        if (!Str::startsWith($path, ['/assets/', 'assets/', '/img/', 'img/', '/storage/', 'storage/'])) {
            $path = 'assets/' . ltrim($path, '/');
        }

        return $this->absoluteUrl($path);
    }

    private function title(string $value): string
    {
        return Str::limit(trim(strip_tags($value)), 65, '');
    }

    private function description(?string $preferred, ?string $fallback): string
    {
        $value = trim(strip_tags((string) ($preferred ?: $fallback)));
        $value = preg_replace('/\s+/u', ' ', $value) ?: '';

        return Str::limit($value, 160, '');
    }

    private function companyName($company): string
    {
        return trim((string) (optional($company)->titulo ?: optional($company)->nombre ?: 'Merkel Bienes Raíces'));
    }

    private function currencyCode(?string $currency): string
    {
        return strtoupper(trim((string) $currency)) === 'US$' ? 'USD' : 'DOP';
    }
}
