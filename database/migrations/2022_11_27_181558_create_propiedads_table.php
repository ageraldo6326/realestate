<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropiedadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('propiedads', function (Blueprint $table) {
            $table->increments('id');
            $table->string('foto_portada')->nullable();
            $table->integer('provincia')->nullable();
            $table->integer('zona_id')->nullable();
            $table->string('direccion',200)->nullable();
            $table->double('precio',15,2)->nullable();
            $table->string('titulo',60)->nullable();
            $table->string('descripcion_corta',160)->nullable();
            $table->text('descripcion')->nullable();
            $table->text('metadescripcion')->nullable();
            $table->integer('habitaciones')->nullable();
            $table->integer('banos')->nullable();
            $table->integer('parqueos')->nullable();
            $table->double('metraje',8,2)->nullable();
            $table->double('metraje_construccion',8,2)->nullable();
            $table->integer('asignada_a')->nullable();
            $table->integer('captada_por')->nullable();
            $table->integer('tipo')->nullable();
            $table->string('foto_vendedor')->nullable();
            $table->string('disponible_para')->nullable();
            $table->boolean('destacada')->default(1);
            $table->string('foto1',100)->nullable();
            $table->string('foto2',100)->nullable();
            $table->string('foto3',100)->nullable();
            $table->string('foto4',100)->nullable();
            $table->string('video1',100)->nullable();
            $table->string('video2',100)->nullable();
            $table->string('video3',100)->nullable();
            $table->string('video4',100)->nullable();
            $table->string('Moneda')->default('RD$');
            $table->boolean('vendida')->default(0);
            $table->boolean('lobby')->default(0);
            $table->boolean('plantaelectrica')->default(0);
            $table->boolean('camaravigilancia')->default(0);
            $table->boolean('escaleraemergencia')->default(0);
            $table->boolean('maderapreciosa')->default(0);
            $table->boolean('balcon')->default(0);
            $table->boolean('walkincloset')->default(0);
            $table->boolean('jacuzzi')->default(0);
            $table->boolean('areainfantil')->default(0);
            $table->boolean('banovisitas')->default(0);
            $table->boolean('cisterna')->default(0);
            $table->boolean('inversorareacomun')->default(0);
            $table->boolean('gascomun')->default(0);
            $table->boolean('gazebo')->default(0);
            $table->boolean('pozo')->default(0);
            $table->boolean('piscina')->default(0);
            $table->boolean('familyroom')->default(0);
            $table->boolean('cuartodeservicio')->default(0);
            $table->boolean('patio')->default(0);
            $table->boolean('portonelectrico')->default(0);
            $table->boolean('seguridad24horas')->default(0);
            $table->boolean('ascensor')->default(0);
            $table->boolean('parqueostechados')->default(0);
            $table->boolean('preinstalacionairetinacoinversor')->default(0);
            $table->boolean('terraza')->default(0);
            $table->boolean('estudio')->default(0);
            $table->boolean('gimnasio')->default(0);
            $table->boolean('controldeacceso')->default(0);
            $table->integer('clicks')->default(0);
            $table->string('metadescription',160)->nullable();

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
        Schema::dropIfExists('propiedads');
    }
}
