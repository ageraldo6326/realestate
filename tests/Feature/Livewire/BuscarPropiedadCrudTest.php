<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\BuscarPropiedad;
use App\Models\Disponible_para;
use App\Models\Estados;
use App\Models\Inmobiliaria;
use App\Models\Propiedad;
use App\Models\TiposDePropiedad;
use App\Models\User;
use App\Models\Zonas;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class BuscarPropiedadCrudTest extends TestCase
{
  use RefreshDatabase;

  private function makeUser(array $attributes = []): User
  {
    /** @var User $user */
    $user = User::factory()->createOne($attributes);

    return $user;
  }

  protected function setUp(): void
  {
    parent::setUp();

    Storage::fake('local');

    $inmobiliaria = new Inmobiliaria();
    $inmobiliaria->nombre = 'Demo Inmobiliaria';
    $inmobiliaria->correo = 'info@example.test';
    $inmobiliaria->save();
  }

  public function test_store_persists_property_and_main_photo_path(): void
  {
    $user = $this->makeUser([
      'email' => 'asesor@example.test',
      'rol' => 1,
    ]);

    $zona = new Zonas();
    $zona->zona = 'Naco';
    $zona->save();

    $tipo = new TiposDePropiedad();
    $tipo->tipo = 'Apartamento';
    $tipo->save();

    $estado = new Estados();
    $estado->estado = 'Nuevo';
    $estado->save();

    $disponible = new Disponible_para();
    $disponible->disponible_para = 'Venta';
    $disponible->save();

    $this->actingAs($user);

    Livewire::test(BuscarPropiedad::class)
      ->set('titulo', 'Apartamento moderno en Naco premium')
      ->set('descripcion', '<p>Descripcion larga con detalles relevantes.</p>')
      ->set('descripcion_corta', 'Descripcion corta valida para SEO con mas de veinte caracteres.')
      ->set('metadescription', 'Meta description valida y bien redactada para el listado.')
      ->set('zona_id', (string) $zona->id)
      ->set('provincia', '1')
      ->set('moneda', 'RD$')
      ->set('precio', '25,000,000')
      ->set('tipo', (string) $tipo->id)
      ->set('habitaciones', '3')
      ->set('banos', '2')
      ->set('parqueos', '2')
      ->set('metraje', '185')
      ->set('disponible_para', (string) $disponible->id)
      ->set('estado_id', $estado->id)
      ->set('foto_portada', UploadedFile::fake()->image('cover.jpg'))
      ->call('store')
      ->assertHasNoErrors();

    $propiedad = Propiedad::query()->first();

    $this->assertNotNull($propiedad);
    $this->assertSame('RD$', $propiedad->Moneda);
    $this->assertSame('25000000', (string) ((int) $propiedad->precio));
    $this->assertNotEmpty($propiedad->foto_portada);
    $this->assertStringContainsString('propiedades/', $propiedad->foto_portada);
    Storage::assertExists($propiedad->foto_portada);
  }

  public function test_update_allows_same_title_for_existing_property(): void
  {
    $user = $this->makeUser([
      'email' => 'asesor2@example.test',
      'rol' => 1,
    ]);

    $zona = new Zonas();
    $zona->zona = 'Piantini';
    $zona->save();

    $tipo = new TiposDePropiedad();
    $tipo->tipo = 'Penthouse';
    $tipo->save();

    $estado = new Estados();
    $estado->estado = 'Usado';
    $estado->save();

    $disponible = new Disponible_para();
    $disponible->disponible_para = 'Alquiler';
    $disponible->save();

    $propiedad = new Propiedad();
    $propiedad->referencia = 'PROP-0000000001';
    $propiedad->titulo = 'Penthouse con terraza privada de lujo';
    $propiedad->slug = 'penthouse-con-terraza-privada-de-lujo-1';
    $propiedad->descripcion = 'Descripcion base';
    $propiedad->descripcion_corta = 'Descripcion corta inicial superior a veinte caracteres.';
    $propiedad->metadescription = 'Meta description inicial superior a veinte caracteres.';
    $propiedad->metadescripcion = 'Meta description inicial superior a veinte caracteres.';
    $propiedad->zona_id = $zona->id;
    $propiedad->provincia = 1;
    $propiedad->Moneda = 'US$';
    $propiedad->precio = 350000;
    $propiedad->tipo = $tipo->id;
    $propiedad->habitaciones = 3;
    $propiedad->banos = 3;
    $propiedad->parqueos = 2;
    $propiedad->metraje = 210;
    $propiedad->disponible_para = (string) $disponible->id;
    $propiedad->estado_id = $estado->id;
    $propiedad->asignada_a = $user->email;
    $propiedad->captada_por = $user->id;
    $propiedad->activa = 1;
    $propiedad->save();

    $this->actingAs($user);

    Livewire::test(BuscarPropiedad::class)
      ->set('Id', $propiedad->id)
      ->set('titulo', 'Penthouse con terraza privada de lujo')
      ->set('descripcion', 'Descripcion actualizada para la propiedad.')
      ->set('descripcion_corta', 'Descripcion corta actualizada que supera los veinte caracteres.')
      ->set('metadescription', 'Meta description actualizada para validar la edicion.')
      ->set('zona_id', (string) $zona->id)
      ->set('provincia', '1')
      ->set('moneda', 'US$')
      ->set('precio', '355,000')
      ->set('tipo', (string) $tipo->id)
      ->set('habitaciones', '3')
      ->set('banos', '3')
      ->set('parqueos', '2')
      ->set('metraje', '210')
      ->set('disponible_para', (string) $disponible->id)
      ->set('estado_id', $estado->id)
      ->set('foto_portada', '')
      ->set('foto1', '')
      ->set('foto2', '')
      ->set('foto3', '')
      ->set('foto4', '')
      ->set('foto5', '')
      ->set('foto6', '')
      ->set('foto7', '')
      ->set('foto8', '')
      ->call('update', $propiedad->id)
      ->assertHasNoErrors();

    $propiedad->refresh();

    $this->assertSame('Penthouse con terraza privada de lujo', $propiedad->titulo);
    $this->assertSame('355000', (string) ((int) $propiedad->precio));
    $this->assertSame('Meta description actualizada para validar la edicion.', $propiedad->metadescription);
    $this->assertSame('Meta description actualizada para validar la edicion.', $propiedad->metadescripcion);
  }

  public function test_delete_removes_property_and_photo_files(): void
  {
    $user = $this->makeUser([
      'email' => 'asesor3@example.test',
      'rol' => 1,
    ]);

    $zona = new Zonas();
    $zona->zona = 'Ensanche Paraiso';
    $zona->save();

    $tipo = new TiposDePropiedad();
    $tipo->tipo = 'Casa';
    $tipo->save();

    $estado = new Estados();
    $estado->estado = 'Activa';
    $estado->save();

    $disponible = new Disponible_para();
    $disponible->disponible_para = 'Venta';
    $disponible->save();

    $propiedad = new Propiedad();
    $propiedad->referencia = 'PROP-0000000003';
    $propiedad->titulo = 'Casa familiar con patio amplio en Paraiso';
    $propiedad->slug = 'casa-familiar-con-patio-amplio-en-paraiso-3';
    $propiedad->descripcion = 'Descripcion base';
    $propiedad->descripcion_corta = 'Descripcion corta para validar eliminacion de fotos.';
    $propiedad->metadescription = 'Meta description para validar eliminacion de recursos.';
    $propiedad->metadescripcion = 'Meta description para validar eliminacion de recursos.';
    $propiedad->zona_id = $zona->id;
    $propiedad->provincia = 1;
    $propiedad->Moneda = 'RD$';
    $propiedad->precio = 12000000;
    $propiedad->tipo = $tipo->id;
    $propiedad->habitaciones = 4;
    $propiedad->banos = 3;
    $propiedad->parqueos = 2;
    $propiedad->metraje = 320;
    $propiedad->disponible_para = (string) $disponible->id;
    $propiedad->estado_id = $estado->id;
    $propiedad->asignada_a = $user->email;
    $propiedad->captada_por = $user->id;
    $propiedad->activa = 1;
    $propiedad->foto_portada = 'propiedades/3/casa-familiar-portada.jpg';
    $propiedad->save();

    Storage::disk('local')->put($propiedad->foto_portada, 'fake-image-content');

    $publicPhotoPath = public_path('assets/' . $propiedad->foto_portada);
    File::ensureDirectoryExists(dirname($publicPhotoPath));
    File::put($publicPhotoPath, 'fake-image-content');

    $this->actingAs($user);

    Livewire::test(BuscarPropiedad::class)
      ->call('borrarPropiedad', $propiedad->id)
      ->assertHasNoErrors();

    $this->assertDatabaseMissing('propiedads', ['id' => $propiedad->id]);
    Storage::assertMissing($propiedad->foto_portada);
    $this->assertFileDoesNotExist($publicPhotoPath);
  }
}
