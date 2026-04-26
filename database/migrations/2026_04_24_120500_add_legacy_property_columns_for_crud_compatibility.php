<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    if (!Schema::hasTable('propiedads')) {
      return;
    }

    Schema::table('propiedads', function (Blueprint $table): void {
      if (!Schema::hasColumn('propiedads', 'foto5')) {
        $table->string('foto5', 100)->nullable()->after('foto4');
      }

      if (!Schema::hasColumn('propiedads', 'foto6')) {
        $table->string('foto6', 100)->nullable()->after('foto5');
      }

      if (!Schema::hasColumn('propiedads', 'foto7')) {
        $table->string('foto7', 100)->nullable()->after('foto6');
      }

      if (!Schema::hasColumn('propiedads', 'foto8')) {
        $table->string('foto8', 100)->nullable()->after('foto7');
      }

      if (!Schema::hasColumn('propiedads', 'comision')) {
        $table->decimal('comision', 10, 2)->default(0)->after('precio');
      }

      if (!Schema::hasColumn('propiedads', 'aprobada')) {
        $table->boolean('aprobada')->default(0)->after('activa');
      }

      if (!Schema::hasColumn('propiedads', 'fechacierre')) {
        $table->date('fechacierre')->nullable()->after('updated_at');
      }

      if (!Schema::hasColumn('propiedads', 'marcadeagua')) {
        $table->boolean('marcadeagua')->default(0)->after('aprobada');
      }
    });
  }

  public function down(): void
  {
    if (!Schema::hasTable('propiedads')) {
      return;
    }

    Schema::table('propiedads', function (Blueprint $table): void {
      $columns = [
        'foto5',
        'foto6',
        'foto7',
        'foto8',
        'comision',
        'aprobada',
        'fechacierre',
        'marcadeagua',
      ];

      $existingColumns = array_filter($columns, static fn(string $column): bool => Schema::hasColumn('propiedads', $column));

      if ($existingColumns !== []) {
        $table->dropColumn($existingColumns);
      }
    });
  }
};
