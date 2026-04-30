<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLocationFieldsToPropiedadsTable extends Migration
{
  public function up(): void
  {
    Schema::table('propiedads', function (Blueprint $table) {
      $table->string('ciudad', 120)->nullable()->after('provincia');
      $table->unsignedBigInteger('sector_id')->nullable()->after('ciudad');
      $table->unsignedBigInteger('barrio_id')->nullable()->after('sector_id');

      $table->index('ciudad');
      $table->index('sector_id');
      $table->index('barrio_id');

      $table->foreign('sector_id')->references('id')->on('sectores')->nullOnDelete();
      $table->foreign('barrio_id')->references('id')->on('barrios')->nullOnDelete();
    });
  }

  public function down(): void
  {
    Schema::table('propiedads', function (Blueprint $table) {
      $table->dropForeign(['sector_id']);
      $table->dropForeign(['barrio_id']);
      $table->dropIndex(['ciudad']);
      $table->dropIndex(['sector_id']);
      $table->dropIndex(['barrio_id']);
      $table->dropColumn(['ciudad', 'sector_id', 'barrio_id']);
    });
  }
}
