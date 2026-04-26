<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePortadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portadas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('minititulo',100)->nullable();
            $table->string('titulo',100)->nullable();
            $table->text('descripcion')->nullable();
            $table->string('enlace1',100)->nullable();
            $table->string('enlace2',100)->nullable();
            $table->string('url1',100)->nullable();
            $table->string('url2',100)->nullable();            
            $table->string('video',100)->nullable();
            $table->string('foto',100)->nullable();
            $table->string('slug',100)->nullable();
            $table->boolean('activo')->default(1);            
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
        Schema::dropIfExists('portadas');
    }
}
