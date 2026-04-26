<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::table('inmobiliarias', function (Blueprint $table): void {
      if (!Schema::hasColumn('inmobiliarias', 'logo')) {
        $table->string('logo')->nullable()->after('quienessomos');
      }
      if (!Schema::hasColumn('inmobiliarias', 'favicon')) {
        $table->string('favicon')->nullable()->after('logo');
      }
      if (!Schema::hasColumn('inmobiliarias', 'slogan')) {
        $table->string('slogan', 200)->nullable()->after('favicon');
      }
      if (!Schema::hasColumn('inmobiliarias', 'palabrasclaves')) {
        $table->string('palabrasclaves', 300)->nullable()->after('slogan');
      }
      if (!Schema::hasColumn('inmobiliarias', 'aprobacion')) {
        $table->boolean('aprobacion')->default(1)->after('palabrasclaves');
      }
      if (!Schema::hasColumn('inmobiliarias', 'dominio')) {
        $table->string('dominio')->nullable()->after('aprobacion');
      }
    });
  }

  public function down(): void
  {
    Schema::table('inmobiliarias', function (Blueprint $table): void {
      $columns = ['logo', 'favicon', 'slogan', 'palabrasclaves', 'aprobacion', 'dominio'];
      $existing = array_filter($columns, fn($c) => Schema::hasColumn('inmobiliarias', $c));
      if ($existing) {
        $table->dropColumn(array_values($existing));
      }
    });
  }
};
