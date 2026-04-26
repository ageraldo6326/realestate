<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMesesTable extends Migration
{
  public function up()
  {
    Schema::create('meses', function (Blueprint $table) {
      $table->id();
      $table->unsignedTinyInteger('numero')->unique()->comment('Número de mes 1-12');
      $table->string('mes', 20)->comment('Nombre del mes en español');
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('meses');
  }
}
