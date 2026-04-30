<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserPropertyApprovalOverride extends Migration
{
  public function up(): void
  {
    Schema::table('users', function (Blueprint $table) {
      if (!Schema::hasColumn('users', 'requiere_aprobacion_propiedades')) {
        $table->boolean('requiere_aprobacion_propiedades')
          ->nullable()
          ->after('rol');
      }
    });
  }

  public function down(): void
  {
    Schema::table('users', function (Blueprint $table) {
      if (Schema::hasColumn('users', 'requiere_aprobacion_propiedades')) {
        $table->dropColumn('requiere_aprobacion_propiedades');
      }
    });
  }
}
