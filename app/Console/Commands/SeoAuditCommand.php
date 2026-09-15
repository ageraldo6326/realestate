<?php

namespace App\Console\Commands;

use App\Services\SeoAuditService;
use Illuminate\Console\Command;

class SeoAuditCommand extends Command
{
    protected $signature = 'seo:audit {--entity-type=} {--entity-id=} {--trigger=scheduled}';
    protected $description = 'Ejecuta la auditoría interna de SEO e indexación.';

    public function handle(SeoAuditService $audits): int
    {
        $run = $audits->run(
            (string) $this->option('trigger'),
            null,
            $this->option('entity-type') ?: null,
            $this->option('entity-id') ? (int) $this->option('entity-id') : null
        );

        if ($run === null) {
            $this->warn('Las tablas SEO todavía no han sido migradas.');

            return self::FAILURE;
        }

        $this->info("Auditoría SEO #{$run->id} completada.");

        return self::SUCCESS;
    }
}
