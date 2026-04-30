<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('propiedads', function (Blueprint $table): void {
            $table->index('activa', 'idx_propiedads_activa');
            $table->index('aprobada', 'idx_propiedads_aprobada');
            $table->index('destacada', 'idx_propiedads_destacada');
            $table->index('vendida', 'idx_propiedads_vendida');
            $table->index('zona_id', 'idx_propiedads_zona_id');
            $table->index('estado_id', 'idx_propiedads_estado_id');
            $table->index('tipo', 'idx_propiedads_tipo');
            $table->index('disponible_para', 'idx_propiedads_disponible_para');
            $table->index('asignada_a', 'idx_propiedads_asignada_a');
            $table->index('captada_por', 'idx_propiedads_captada_por');
            $table->index('slug', 'idx_propiedads_slug');
            $table->index('Moneda', 'idx_propiedads_moneda');
            $table->index('created_at', 'idx_propiedads_created_at');
            $table->index(['activa', 'aprobada', 'vendida'], 'idx_propiedads_estado_general');
        });

        Schema::table('clientes', function (Blueprint $table): void {
            $table->index('captado_por', 'idx_clientes_captado_por');
            $table->index('asignado_a', 'idx_clientes_asignado_a');
            $table->index('estatus', 'idx_clientes_estatus');
            $table->index('probabilidades', 'idx_clientes_probabilidades');
            $table->index('created_at', 'idx_clientes_created_at');
            $table->index(['captado_por', 'created_at'], 'idx_clientes_owner_date');
        });

        Schema::table('to_dos', function (Blueprint $table): void {
            $table->index('user_id', 'idx_todos_user_id');
            $table->index('cliente_id', 'idx_todos_cliente_id');
            $table->index('todo_estatus', 'idx_todos_estatus');
            $table->index('todo_tipo', 'idx_todos_tipo');
            $table->index('fechaLimite', 'idx_todos_fecha');
        });

        Schema::table('ventas', function (Blueprint $table): void {
            $table->index('id_asesor', 'idx_ventas_asesor');
            $table->index('id_propiedad', 'idx_ventas_propiedad');
            $table->index('fechaVentaCierre', 'idx_ventas_fecha_cierre');
        });
    }

    public function down(): void
    {
        Schema::table('propiedads', function (Blueprint $table): void {
            $table->dropIndex('idx_propiedads_activa');
            $table->dropIndex('idx_propiedads_aprobada');
            $table->dropIndex('idx_propiedads_destacada');
            $table->dropIndex('idx_propiedads_vendida');
            $table->dropIndex('idx_propiedads_zona_id');
            $table->dropIndex('idx_propiedads_estado_id');
            $table->dropIndex('idx_propiedads_tipo');
            $table->dropIndex('idx_propiedads_disponible_para');
            $table->dropIndex('idx_propiedads_asignada_a');
            $table->dropIndex('idx_propiedads_captada_por');
            $table->dropIndex('idx_propiedads_slug');
            $table->dropIndex('idx_propiedads_moneda');
            $table->dropIndex('idx_propiedads_created_at');
            $table->dropIndex('idx_propiedads_estado_general');
        });

        Schema::table('clientes', function (Blueprint $table): void {
            $table->dropIndex('idx_clientes_captado_por');
            $table->dropIndex('idx_clientes_asignado_a');
            $table->dropIndex('idx_clientes_estatus');
            $table->dropIndex('idx_clientes_probabilidades');
            $table->dropIndex('idx_clientes_created_at');
            $table->dropIndex('idx_clientes_owner_date');
        });

        Schema::table('to_dos', function (Blueprint $table): void {
            $table->dropIndex('idx_todos_user_id');
            $table->dropIndex('idx_todos_cliente_id');
            $table->dropIndex('idx_todos_estatus');
            $table->dropIndex('idx_todos_tipo');
            $table->dropIndex('idx_todos_fecha');
        });

        Schema::table('ventas', function (Blueprint $table): void {
            $table->dropIndex('idx_ventas_asesor');
            $table->dropIndex('idx_ventas_propiedad');
            $table->dropIndex('idx_ventas_fecha_cierre');
        });
    }
};
