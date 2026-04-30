<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('propiedads', function (Blueprint $table) {
            $table->unsignedInteger('asignada_a_id')->nullable()->after('asignada_a');
            $table->index('asignada_a_id', 'idx_propiedads_asignada_a_id');
        });

        DB::table('propiedads')
            ->select('id', 'asignada_a')
            ->orderBy('id')
            ->chunk(500, function ($rows): void {
                foreach ($rows as $row) {
                    $asignadaA = trim((string) ($row->asignada_a ?? ''));
                    if ($asignadaA === '') {
                        continue;
                    }

                    $asignadaAId = null;

                    if (is_numeric($asignadaA)) {
                        $asignadaAId = (int) $asignadaA;
                    } else {
                        $asignadaAId = DB::table('users')
                            ->where('email', $asignadaA)
                            ->value('id');
                    }

                    if ($asignadaAId) {
                        DB::table('propiedads')
                            ->where('id', $row->id)
                            ->update(['asignada_a_id' => $asignadaAId]);
                    }
                }
            });
    }

    public function down(): void
    {
        Schema::table('propiedads', function (Blueprint $table) {
            $table->dropIndex('idx_propiedads_asignada_a_id');
            $table->dropColumn('asignada_a_id');
        });
    }
};
