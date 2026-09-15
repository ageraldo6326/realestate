<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('inmobiliarias', function (Blueprint $table): void {
            if (!Schema::hasColumn('inmobiliarias', 'seo_canonical_url')) {
                $table->string('seo_canonical_url', 255)->nullable()->after('dominio');
            }

            if (!Schema::hasColumn('inmobiliarias', 'seo_alternate_hosts')) {
                $table->json('seo_alternate_hosts')->nullable()->after('seo_canonical_url');
            }

            if (!Schema::hasColumn('inmobiliarias', 'seo_indexable')) {
                $table->boolean('seo_indexable')->default(false)->after('seo_alternate_hosts');
            }

            if (!Schema::hasColumn('inmobiliarias', 'social_image')) {
                $table->string('social_image', 255)->nullable()->after('seo_indexable');
            }

            if (!Schema::hasColumn('inmobiliarias', 'search_console_verification_token')) {
                $table->string('search_console_verification_token', 255)->nullable()->after('social_image');
            }
        });
    }

    public function down(): void
    {
        Schema::table('inmobiliarias', function (Blueprint $table): void {
            $columns = [
                'seo_canonical_url',
                'seo_alternate_hosts',
                'seo_indexable',
                'social_image',
                'search_console_verification_token',
            ];
            $existing = array_values(array_filter(
                $columns,
                static fn (string $column): bool => Schema::hasColumn('inmobiliarias', $column)
            ));

            if ($existing !== []) {
                $table->dropColumn($existing);
            }
        });
    }
};
