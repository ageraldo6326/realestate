<?php

namespace App\Jobs;

use App\Services\SeoAuditService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RunSeoAudit implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $trigger;
    public ?int $initiatedBy;
    public ?string $entityType;
    public ?int $entityId;

    public function __construct(string $trigger = 'manual', ?int $initiatedBy = null, ?string $entityType = null, ?int $entityId = null)
    {
        $this->trigger = $trigger;
        $this->initiatedBy = $initiatedBy;
        $this->entityType = $entityType;
        $this->entityId = $entityId;
    }

    public function handle(SeoAuditService $audits): void
    {
        $audits->run($this->trigger, $this->initiatedBy, $this->entityType, $this->entityId);
    }
}
