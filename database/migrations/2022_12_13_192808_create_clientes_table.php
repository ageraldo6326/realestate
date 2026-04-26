<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre',60);
            $table->string('titulo')->nullable();
            $table->string('tipo_contacto');
            $table->string('telefono',20)->unique('telefono');
            $table->string('email',150)->unique('email');
            $table->text("comentario")->nullable();
            $table->boolean('activo');
            $table->string('tipo_contacto2');
            $table->integer('captado_por');
            $table->integer('asignado_a');
            $table->string('medio')->nullable();
            $table->text('testimonio')->nullable();
            $table->double('precio_mini',12,2)->nullable();
            $table->double('precio_max',12,2)->nullable();
            $table->integer("zona_id")->nullable();
            $table->integer("tipo")->nullable();
            $table->integer("habitaciones")->nullable();
            $table->integer("parqueos")->nullable();
            $table->integer("estado")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clientes');
    }
}
