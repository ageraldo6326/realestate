<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('id_propiedad');
            $table->string('refPropiedad',30);
            $table->string('tituloPropiedad',100);
            $table->string('tipoPropiedad',30);
            $table->string('zonaPropiedad',60);
            $table->string('estadoPropiedad',30);
            $table->date('fechaPropiedadCreada');
            $table->double('precio',15,2);
            $table->double('comision',4,2);            
            $table->integer('id_vendedor');
            $table->string('nombre_vendedor',100);
            $table->integer('id_comprador');
            $table->string('nombre_comprador',100);
            $table->string('medio_comprador',30);
            $table->integer('id_asesor');
            $table->string('nombre_asesor',100);
            $table->date('fechaVentaCierre');
            $table->date('fechacreadocomprador');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ventas');
    }
}
