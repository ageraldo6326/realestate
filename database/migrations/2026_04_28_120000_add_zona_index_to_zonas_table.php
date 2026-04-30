<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('zonas', function (Blueprint $table): void {
            $table->index('zona', 'zonas_zona_index');
        });
    }

    public function down(): void
    {
        Schema::table('zonas', function (Blueprint $table): void {
            $table->dropIndex('zonas_zona_index');
        });
    }
};
