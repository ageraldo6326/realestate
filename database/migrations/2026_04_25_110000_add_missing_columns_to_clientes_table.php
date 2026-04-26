<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissingColumnsToClientesTable extends Migration
{
    public function up()
    {
        Schema::table('clientes', function (Blueprint $table) {
            if (!Schema::hasColumn('clientes', 'contact_at')) {
                $table->date('contact_at')->nullable()->after('comentario');
            }
            if (!Schema::hasColumn('clientes', 'estatus')) {
                $table->string('estatus', 30)->nullable()->after('contact_at');
            }
            if (!Schema::hasColumn('clientes', 'probabilidades')) {
                $table->string('probabilidades', 30)->nullable()->after('estatus');
            }
            if (!Schema::hasColumn('clientes', 'captadas_por')) {
                $table->string('captadas_por', 10)->nullable()->after('probabilidades');
            }
            if (!Schema::hasColumn('clientes', 'precio_mini_dolar')) {
                $table->double('precio_mini_dolar', 12, 2)->nullable()->after('precio_max');
            }
            if (!Schema::hasColumn('clientes', 'precio_max_dolar')) {
                $table->double('precio_max_dolar', 12, 2)->nullable()->after('precio_mini_dolar');
            }
            if (!Schema::hasColumn('clientes', 'estado_en_dolares')) {
                $table->integer('estado_en_dolares')->nullable()->after('precio_max_dolar');
            }
            if (!Schema::hasColumn('clientes', 'tipo_en_dolares')) {
                $table->integer('tipo_en_dolares')->nullable()->after('estado_en_dolares');
            }
            if (!Schema::hasColumn('clientes', 'fechacierre')) {
                $table->date('fechacierre')->nullable()->after('tipo_en_dolares');
            }
        });
    }

    public function down()
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropColumn([
                'contact_at',
                'estatus',
                'probabilidades',
                'captadas_por',
                'precio_mini_dolar',
                'precio_max_dolar',
                'estado_en_dolares',
                'tipo_en_dolares',
                'fechacierre',
            ]);
        });
    }
}
