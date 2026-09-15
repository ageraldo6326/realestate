<?php

namespace Tests\Feature;

use App\Models\Inmobiliaria;
use App\Models\Propiedad;
use App\Models\User;
use App\Support\PropertyDescriptionSanitizer;
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

    public function test_property_review_view_preserves_safe_rich_html_and_removes_active_content(): void
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
            'descripcion' => '<script>alert("xss")</script><p>Primer párrafo.</p><p>Segundo párrafo.</p><ul><li>Con balcón</li></ul><a href="javascript:alert(1)" onclick="alert(1)">Enlace</a>',
            'Moneda' => 'RD$',
            'precio' => 12500000,
        ]);

        $html = view('admin.propiedades.revision', [
            'propiedad' => $propiedad,
            'inmobiliaria' => new Inmobiliaria(['aprobacion' => true]),
        ])->render();

        $this->assertStringContainsString('Apartamento seguro para revisión', $html);
        $this->assertStringContainsString('<p>Primer párrafo.</p>', $html);
        $this->assertStringContainsString('<p>Segundo párrafo.</p>', $html);
        $this->assertStringContainsString('<li>Con balcón</li>', $html);
        $this->assertStringNotContainsString('<script>alert("xss")</script>', $html);
        $this->assertStringNotContainsString('javascript:alert(1)', $html);

        $sanitized = PropertyDescriptionSanitizer::sanitize($propiedad->descripcion);
        $this->assertStringNotContainsString('onclick=', $sanitized);
    }
}
