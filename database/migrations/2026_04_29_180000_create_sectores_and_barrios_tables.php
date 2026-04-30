<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSectoresAndBarriosTables extends Migration
{
  public function up(): void
  {
    Schema::create('sectores', function (Blueprint $table) {
      $table->id();
      $table->unsignedInteger('provincia_id');
      $table->string('sector', 120);
      $table->timestamps();

      $table->unique(['provincia_id', 'sector']);
      $table->index('sector');
      $table->foreign('provincia_id')->references('id')->on('provincias')->onDelete('cascade');
    });

    Schema::create('barrios', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('sector_id');
      $table->string('barrio', 120);
      $table->timestamps();

      $table->unique(['sector_id', 'barrio']);
      $table->index('barrio');
      $table->foreign('sector_id')->references('id')->on('sectores')->onDelete('cascade');
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('barrios');
    Schema::dropIfExists('sectores');
  }
}
