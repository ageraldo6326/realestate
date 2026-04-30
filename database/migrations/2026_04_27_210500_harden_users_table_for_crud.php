<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('users')) {
            // Evita truncamientos al guardar biografias desde CKEditor.
            DB::statement('ALTER TABLE users MODIFY descripcion TEXT NULL');

            Schema::table('users', function (Blueprint $table) {
                $table->index(['rol', 'activo'], 'users_rol_activo_index');
                $table->index('mostrar', 'users_mostrar_index');
                $table->index('deleted_at', 'users_deleted_at_index');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('users')) {
            DB::statement('ALTER TABLE users MODIFY descripcion VARCHAR(255) NULL');

            Schema::table('users', function (Blueprint $table) {
                $table->dropIndex('users_rol_activo_index');
                $table->dropIndex('users_mostrar_index');
                $table->dropIndex('users_deleted_at_index');
            });
        }
    }
};
