<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    if (!Schema::hasColumn('users', 'mostrar')) {
      Schema::table('users', function (Blueprint $table) {
        $table->boolean('mostrar')->default(1)->after('rol');
      });
    }
  }

  public function down(): void
  {
    if (Schema::hasColumn('users', 'mostrar')) {
      Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('mostrar');
      });
    }
  }
};
