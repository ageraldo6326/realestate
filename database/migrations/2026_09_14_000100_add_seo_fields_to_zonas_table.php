<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('zonas', function (Blueprint $table): void {
            $table->string('slug')->nullable()->unique()->after('zona');
            $table->boolean('is_public')->default(true)->index()->after('slug');
            $table->string('seo_h1', 120)->nullable()->after('is_public');
            $table->string('seo_title', 70)->nullable()->after('seo_h1');
            $table->string('meta_description', 160)->nullable()->after('seo_title');
            $table->text('seo_description')->nullable()->after('meta_description');
            $table->string('image')->nullable()->after('seo_description');
            $table->string('image_alt', 160)->nullable()->after('image');
        });

        $usedSlugs = [];

        DB::table('zonas')->select('id', 'zona')->orderBy('id')->get()->each(
            static function ($zone) use (&$usedSlugs): void {
                $base = Str::slug((string) $zone->zona) ?: 'zona-' . $zone->id;
                $slug = $base;
                $suffix = 2;

                while (isset($usedSlugs[$slug])) {
                    $slug = $base . '-' . $suffix;
                    $suffix++;
                }

                $usedSlugs[$slug] = true;
                DB::table('zonas')->where('id', $zone->id)->update(['slug' => $slug]);
            }
        );
    }

    public function down(): void
    {
        Schema::table('zonas', function (Blueprint $table): void {
            $table->dropUnique('zonas_slug_unique');
            $table->dropIndex('zonas_is_public_index');
            $table->dropColumn([
                'slug',
                'is_public',
                'seo_h1',
                'seo_title',
                'meta_description',
                'seo_description',
                'image',
                'image_alt',
            ]);
        });
    }
};
