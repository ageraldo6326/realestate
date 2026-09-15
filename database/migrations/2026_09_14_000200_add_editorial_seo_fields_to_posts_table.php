<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table): void {
            $table->string('status', 20)->default('published')->index()->after('activo');
            $table->timestamp('published_at')->nullable()->index()->after('status');
            $table->string('seo_title', 70)->nullable()->after('metadescription');
            $table->string('image_alt', 160)->nullable()->after('foto');
            $table->string('image_credit', 160)->nullable()->after('image_alt');
        });

        DB::table('posts')->select('id', 'activo', 'created_at')->orderBy('id')->get()->each(
            static function ($post): void {
                $published = (bool) $post->activo;
                DB::table('posts')->where('id', $post->id)->update([
                    'status' => $published ? 'published' : 'draft',
                    'published_at' => $published ? ($post->created_at ?: now()) : null,
                ]);
            }
        );
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table): void {
            $table->dropIndex('posts_status_index');
            $table->dropIndex('posts_published_at_index');
            $table->dropColumn(['status', 'published_at', 'seo_title', 'image_alt', 'image_credit']);
        });
    }
};
