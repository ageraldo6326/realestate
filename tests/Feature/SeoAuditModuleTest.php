<?php

namespace Tests\Feature;

use App\Models\Inmobiliaria;
use App\Models\SeoAuditResult;
use App\Services\InmobiliariaService;
use App\Services\SeoAuditService;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Mockery;
use Tests\TestCase;

class SeoAuditModuleTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => ':memory:',
            'seo.canonical_url' => 'https://realestate.voipcom.net',
            'seo.indexing_enabled' => true,
        ]);
        DB::purge('sqlite');
        DB::reconnect('sqlite');
        DB::setDefaultConnection('sqlite');
        Cache::flush();
        $this->createContentTables();
        (require database_path('migrations/2026_09_15_000300_create_seo_audit_tables.php'))->up();
    }

    public function test_audit_persists_indexability_findings_and_sitemap_version(): void
    {
        Inmobiliaria::query()->create([
            'nombre' => 'ALIS Demo',
            'seo_canonical_url' => 'https://realestate.voipcom.net',
            'seo_indexable' => true,
        ]);
        InmobiliariaService::forget();
        $zoneId = DB::table('zonas')->insertGetId([
            'zona' => 'Piantini', 'slug' => 'piantini', 'is_public' => true, 'seo_description' => 'Guía de Piantini.',
            'created_at' => now(), 'updated_at' => now(),
        ]);
        $typeId = DB::table('tipos_de_propiedads')->insertGetId([
            'tipo' => 'Apartamento', 'created_at' => now(), 'updated_at' => now(),
        ]);
        DB::table('propiedads')->insert([
            ['titulo' => 'Apartamento público', 'slug' => 'apartamento-publico', 'zona_id' => $zoneId, 'tipo' => $typeId, 'activa' => true, 'aprobada' => true, 'vendida' => false, 'foto_portada' => '/img/a.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['titulo' => 'Pendiente', 'slug' => 'apartamento-pendiente', 'zona_id' => $zoneId, 'tipo' => $typeId, 'activa' => true, 'aprobada' => false, 'vendida' => false, 'foto_portada' => null, 'created_at' => now(), 'updated_at' => now()],
        ]);

        $run = app(SeoAuditService::class)->run('test');

        $this->assertSame('completed', $run->status);
        $public = SeoAuditResult::query()->where('canonical_url', 'https://realestate.voipcom.net/propiedades/apartamento-publico')->firstOrFail();
        $pending = SeoAuditResult::query()->where('canonical_url', 'https://realestate.voipcom.net/propiedades/apartamento-pendiente')->firstOrFail();

        $this->assertTrue($public->is_indexable);
        $this->assertTrue($public->is_in_sitemap);
        $this->assertFalse($pending->is_indexable);
        $this->assertFalse($pending->is_in_sitemap);
        $this->assertDatabaseHas('seo_audit_findings', ['seo_audit_result_id' => $pending->id, 'rule_code' => 'SEO-URL-002']);
        $this->assertDatabaseHas('sitemap_versions', ['canonical_host' => 'realestate.voipcom.net']);
    }

    public function test_seo_dashboard_view_renders_summary_filters_and_action(): void
    {
        $user = Mockery::mock();
        $user->name = 'Admin';
        $user->email = 'admin@example.test';
        $user->shouldReceive('resolvePhotoUrl')->andReturn('https://example.test/avatar.png');
        $user->shouldReceive('hasAnyRole')->andReturn(true);
        $user->shouldReceive('hasRole')->andReturn(true);
        Auth::shouldReceive('user')->andReturn($user);

        $html = view('admin.seo-audit.index', [
            'summary' => ['green' => 2, 'yellow' => 1, 'red' => 3, 'in_sitemap' => 2, 'last_run' => null],
            'results' => new LengthAwarePaginator(collect(), 0, 25),
            'lastSitemap' => null,
        ])->render();

        $this->assertStringContainsString('Ejecutar auditoría', $html);
        $this->assertStringContainsString('Filtros de auditoría SEO', $html);
        $this->assertStringContainsString('Resultados por URL', $html);
    }

    private function createContentTables(): void
    {
        Schema::create('inmobiliarias', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('nombre')->nullable();
            $table->string('dominio')->nullable();
            $table->string('seo_canonical_url')->nullable();
            $table->boolean('seo_indexable')->default(false);
            $table->timestamps();
        });
        Schema::create('zonas', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('zona')->nullable();
            $table->string('slug')->nullable();
            $table->boolean('is_public')->default(true);
            $table->text('seo_description')->nullable();
            $table->string('seo_title')->nullable();
            $table->timestamps();
        });
        Schema::create('tipos_de_propiedads', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('tipo');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('propiedads', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('titulo')->nullable();
            $table->string('slug')->nullable();
            $table->unsignedInteger('zona_id')->nullable();
            $table->unsignedInteger('tipo')->nullable();
            $table->boolean('activa')->default(false);
            $table->boolean('aprobada')->default(false);
            $table->boolean('vendida')->default(false);
            $table->string('foto_portada')->nullable();
            $table->timestamps();
        });
        Schema::create('posts', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('titulo')->nullable();
            $table->string('slug')->nullable();
            $table->boolean('activo')->default(false);
            $table->string('status')->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->text('contenido')->nullable();
            $table->text('metadescription')->nullable();
            $table->timestamps();
        });
    }
}
