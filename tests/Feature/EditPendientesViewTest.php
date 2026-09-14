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

        $html = view('admin.propiedades.editPendientes', [
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
        ])->render();

        $this->assertStringContainsString('Apartamento de prueba para editar', $html);
        $this->assertStringContainsString('name="grabar"', $html);
    }
}
