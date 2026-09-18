<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    if (DB::connection()->getDriverName() === 'mysql') {
      DB::statement('ALTER TABLE users MODIFY rol INT NOT NULL DEFAULT 0');
    }
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    if (DB::connection()->getDriverName() === 'mysql') {
      DB::statement('ALTER TABLE users MODIFY rol INT NOT NULL DEFAULT 1');
    }
  }
};
