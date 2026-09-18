<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media_images', function (Blueprint $table): void {
            $table->id();
            $table->nullableMorphs('imageable');
            $table->string('disk', 64);
            $table->string('original_path')->unique();
            $table->string('original_mime_type', 127);
            $table->unsignedInteger('original_width');
            $table->unsignedInteger('original_height');
            $table->unsignedBigInteger('original_bytes');
            $table->string('checksum', 64);
            $table->string('alt_text')->nullable();
            $table->string('status', 16)->default('pending')->index();
            $table->text('processing_error')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['imageable_type', 'imageable_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media_images');
    }
};
