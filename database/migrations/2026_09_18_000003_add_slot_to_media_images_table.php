<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('media_images', function (Blueprint $table): void {
            $table->string('slot', 32)->nullable()->after('alt_text');
            $table->index(['imageable_type', 'imageable_id', 'slot']);
        });
    }

    public function down(): void
    {
        Schema::table('media_images', function (Blueprint $table): void {
            $table->dropIndex(['imageable_type', 'imageable_id', 'slot']);
            $table->dropColumn('slot');
        });
    }
};
