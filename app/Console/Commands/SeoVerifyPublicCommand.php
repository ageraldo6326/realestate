<?php

namespace App\Console\Commands;

use App\Services\SeoPublicVerificationService;
use Illuminate\Console\Command;

class SeoVerifyPublicCommand extends Command
{
    protected $signature = 'seo:verify-public';
    protected $description = 'Falla si la configuración pública SEO no permite indexación segura.';

    public function handle(SeoPublicVerificationService $verification): int
    {
        $issues = $verification->issues();
        if ($issues === []) {
            $this->info('Verificación SEO pública completada correctamente.');

            return self::SUCCESS;
        }

        foreach ($issues as $issue) {
            $this->error($issue);
        }

        return self::FAILURE;
    }
}
