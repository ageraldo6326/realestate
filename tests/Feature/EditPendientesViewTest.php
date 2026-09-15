<?php

namespace Tests\Feature;

use App\Models\Inmobiliaria;
use App\Models\Propiedad;
use App\Models\User;
use Illuminate\Support\ViewErrorBag;
use Tests\TestCase;

class EditPendientesViewTest extends TestCase
{
    public function test_pending_property_edit_view_renders(): void
    {
        $user = new User([
            'name' => 'Usuario de prueba',
            'email' => 'usuario@example.test',
            'rol' => 0,
        ]);
        $user->setRelation('roles', collect());
        $this->actingAs($user);

        $propiedad = new Propiedad([
            'id' => 8,
            'titulo' => 'Apartamento de prueba para editar',
            'descripcion_corta' => 'Descripcion corta de prueba para la propiedad.',
            'descripcion' => 'Descripcion de prueba para la propiedad.',
            'direccion' => 'Santo Domingo',
            'metadescription' => 'Meta descripcion de prueba para la propiedad.',
            'Moneda' => 'RD$',
            'precio' => 15000000,
        ]);

        $html = view('admin.propiedades.edit', [
            'propiedad' => $propiedad,
            'provincias' => collect(),
            'sectores' => collect(),
            'zonas' => collect(),
            'barrios' => collect(),
            'disponibles_para' => collect(),
            'tipos_propiedades' => collect(),
            'estados_propiedad' => collect(),
            'inmobiliaria' => new Inmobiliaria(['aprobacion' => true]),
            'errors' => new ViewErrorBag(),
            'reviewMode' => true,
            'formAction' => route('updatependientes', $propiedad->id),
            'returnUrl' => route('poraprobar'),
        ])->render();

        $this->assertStringContainsString('Apartamento de prueba para editar', $html);
        $this->assertStringContainsString('Revisar y editar propiedad', $html);
        $this->assertStringContainsString(route('updatependientes', $propiedad->id), $html);
        $this->assertStringContainsString('ClassicEditor', $html);
    }

    public function test_property_review_view_renders_without_exposing_rich_html(): void
    {
        $user = new User([
            'name' => 'Usuario de revisión',
            'email' => 'revision@example.test',
        ]);
        $user->setRelation('roles', collect());
        $this->actingAs($user);

        $propiedad = new Propiedad([
            'id' => 9,
            'titulo' => 'Apartamento seguro para revisión',
            'descripcion_corta' => 'Resumen visible de la propiedad.',
            'descripcion' => '<script>alert("xss")</script><p>Descripción segura</p>',
            'Moneda' => 'RD$',
            'precio' => 12500000,
        ]);

        $html = view('admin.propiedades.revision', [
            'propiedad' => $propiedad,
            'inmobiliaria' => new Inmobiliaria(['aprobacion' => true]),
        ])->render();

        $this->assertStringContainsString('Apartamento seguro para revisión', $html);
        $this->assertStringContainsString('Descripción segura', $html);
        $this->assertStringNotContainsString('<script>alert("xss")</script>', $html);
    }
}
