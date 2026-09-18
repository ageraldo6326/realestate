<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media_image_variants', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('media_image_id')->constrained()->cascadeOnDelete();
            $table->string('disk', 64);
            $table->string('profile', 64);
            $table->string('format', 8);
            $table->unsignedInteger('width');
            $table->unsignedInteger('height');
            $table->unsignedBigInteger('bytes');
            $table->string('path')->unique();
            $table->string('checksum', 64);
            $table->timestamp('created_at')->useCurrent();

            $table->unique(['media_image_id', 'profile', 'format', 'width']);
            $table->index(['profile', 'format']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media_image_variants');
    }
};
