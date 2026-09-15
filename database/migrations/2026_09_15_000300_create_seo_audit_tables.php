<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('seo_audit_runs', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->unsignedInteger('inmobiliaria_id')->nullable()->index();
            $table->string('trigger', 40);
            $table->string('status', 20)->default('running');
            $table->unsignedInteger('initiated_by')->nullable()->index();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->json('summary_json')->nullable();
            $table->timestamps();
        });

        Schema::create('seo_audit_results', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->unsignedInteger('inmobiliaria_id')->nullable()->index();
            $table->unsignedBigInteger('seo_audit_run_id')->nullable()->index();
            $table->string('auditable_type', 40);
            $table->unsignedBigInteger('auditable_id')->nullable();
            $table->string('entity_title')->nullable();
            $table->string('canonical_url', 2048);
            $table->boolean('is_indexable')->default(false);
            $table->boolean('is_in_sitemap')->default(false);
            $table->unsignedTinyInteger('score')->default(0);
            $table->string('status', 20)->default('red')->index();
            $table->unsignedSmallInteger('last_http_status')->nullable();
            $table->timestamp('last_checked_at')->nullable();
            $table->timestamp('lastmod_at')->nullable();
            $table->timestamps();
            $table->index(['auditable_type', 'auditable_id']);
            $table->index(['inmobiliaria_id', 'is_indexable', 'is_in_sitemap'], 'seo_audit_result_indexability_idx');
        });

        Schema::create('seo_audit_findings', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('seo_audit_result_id')->index();
            $table->string('rule_code', 40)->index();
            $table->string('severity', 20)->index();
            $table->text('message');
            $table->json('evidence_json')->nullable();
            $table->boolean('is_resolved')->default(false)->index();
            $table->timestamp('resolved_at')->nullable();
            $table->unsignedInteger('resolved_by')->nullable();
            $table->timestamps();
        });

        Schema::create('sitemap_versions', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->unsignedInteger('inmobiliaria_id')->nullable()->index();
            $table->string('canonical_host', 255);
            $table->string('checksum', 64);
            $table->unsignedInteger('url_count')->default(0);
            $table->string('status', 20)->default('generated');
            $table->timestamp('generated_at');
            $table->timestamps();
            $table->index(['inmobiliaria_id', 'canonical_host']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sitemap_versions');
        Schema::dropIfExists('seo_audit_findings');
        Schema::dropIfExists('seo_audit_results');
        Schema::dropIfExists('seo_audit_runs');
    }
};
