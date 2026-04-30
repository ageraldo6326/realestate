<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftDeletesToTiposDePropiedadsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('tipos_de_propiedads', function (Blueprint $table) {
      // Agregar soft deletes y índice en tipo
      if (!Schema::hasColumn('tipos_de_propiedads', 'deleted_at')) {
        $table->softDeletes();
      }

      if (!Schema::hasColumn('tipos_de_propiedads', 'created_at')) {
        $table->timestamps();
      }

      // Agregar índice en columna tipo para mejorar búsquedas
      $table->index('tipo');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('tipos_de_propiedads', function (Blueprint $table) {
      // Solo eliminar si fue agregado por esta migración
      if (Schema::hasColumn('tipos_de_propiedads', 'deleted_at')) {
        $table->dropSoftDeletes();
      }

      $table->dropIndex(['tipo']);
    });
  }
}
