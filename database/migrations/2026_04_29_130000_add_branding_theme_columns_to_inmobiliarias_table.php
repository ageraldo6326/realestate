<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('inmobiliarias', function (Blueprint $table): void {
            if (!Schema::hasColumn('inmobiliarias', 'logo_color_1')) {
                $table->string('logo_color_1', 7)->nullable()->after('dominio');
            }
            if (!Schema::hasColumn('inmobiliarias', 'logo_color_2')) {
                $table->string('logo_color_2', 7)->nullable()->after('logo_color_1');
            }
            if (!Schema::hasColumn('inmobiliarias', 'logo_color_3')) {
                $table->string('logo_color_3', 7)->nullable()->after('logo_color_2');
            }
            if (!Schema::hasColumn('inmobiliarias', 'logo_color_4')) {
                $table->string('logo_color_4', 7)->nullable()->after('logo_color_3');
            }
            if (!Schema::hasColumn('inmobiliarias', 'theme_color_primary')) {
                $table->string('theme_color_primary', 7)->nullable()->after('logo_color_4');
            }
            if (!Schema::hasColumn('inmobiliarias', 'theme_color_secondary')) {
                $table->string('theme_color_secondary', 7)->nullable()->after('theme_color_primary');
            }
            if (!Schema::hasColumn('inmobiliarias', 'theme_color_accent')) {
                $table->string('theme_color_accent', 7)->nullable()->after('theme_color_secondary');
            }
            if (!Schema::hasColumn('inmobiliarias', 'theme_color_neutral')) {
                $table->string('theme_color_neutral', 7)->nullable()->after('theme_color_accent');
            }
            if (!Schema::hasColumn('inmobiliarias', 'theme_source')) {
                $table->string('theme_source', 20)->default('default')->after('theme_color_neutral');
            }
            if (!Schema::hasColumn('inmobiliarias', 'theme_last_logo_hash')) {
                $table->string('theme_last_logo_hash', 64)->nullable()->after('theme_source');
            }
            if (!Schema::hasColumn('inmobiliarias', 'previous_theme_color_primary')) {
                $table->string('previous_theme_color_primary', 7)->nullable()->after('theme_last_logo_hash');
            }
            if (!Schema::hasColumn('inmobiliarias', 'previous_theme_color_secondary')) {
                $table->string('previous_theme_color_secondary', 7)->nullable()->after('previous_theme_color_primary');
            }
            if (!Schema::hasColumn('inmobiliarias', 'previous_theme_color_accent')) {
                $table->string('previous_theme_color_accent', 7)->nullable()->after('previous_theme_color_secondary');
            }
            if (!Schema::hasColumn('inmobiliarias', 'previous_theme_color_neutral')) {
                $table->string('previous_theme_color_neutral', 7)->nullable()->after('previous_theme_color_accent');
            }
            if (!Schema::hasColumn('inmobiliarias', 'previous_theme_source')) {
                $table->string('previous_theme_source', 20)->nullable()->after('previous_theme_color_neutral');
            }
        });
    }

    public function down(): void
    {
        Schema::table('inmobiliarias', function (Blueprint $table): void {
            $columns = [
                'logo_color_1',
                'logo_color_2',
                'logo_color_3',
                'logo_color_4',
                'theme_color_primary',
                'theme_color_secondary',
                'theme_color_accent',
                'theme_color_neutral',
                'theme_source',
                'theme_last_logo_hash',
                'previous_theme_color_primary',
                'previous_theme_color_secondary',
                'previous_theme_color_accent',
                'previous_theme_color_neutral',
                'previous_theme_source',
            ];

            $existing = array_filter($columns, fn($column) => Schema::hasColumn('inmobiliarias', $column));

            if ($existing) {
                $table->dropColumn(array_values($existing));
            }
        });
    }
};
