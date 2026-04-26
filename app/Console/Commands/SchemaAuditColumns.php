<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class SchemaAuditColumns extends Command
{
  protected $signature = 'schema:audit-columns';

  protected $description = 'Audit required columns defined in config/schema_audit.php against current database schema';

  public function handle(): int
  {
    $requiredColumns = config('schema_audit.required_columns', []);

    if (empty($requiredColumns)) {
      $this->warn('No required columns configured in config/schema_audit.php');
      return self::SUCCESS;
    }

    $hasIssues = false;

    foreach ($requiredColumns as $table => $columns) {
      if (!Schema::hasTable($table)) {
        $hasIssues = true;
        $this->error("Table '{$table}' does not exist.");
        continue;
      }

      $missing = [];
      foreach ($columns as $column) {
        if (!Schema::hasColumn($table, $column)) {
          $missing[] = $column;
        }
      }

      if (empty($missing)) {
        $this->info("OK: {$table}");
        continue;
      }

      $hasIssues = true;
      $this->error("Missing columns in {$table}: " . implode(', ', $missing));
    }

    if ($hasIssues) {
      $this->newLine();
      $this->line('Create reconciliation migrations for missing columns and run php artisan migrate.');
      return self::FAILURE;
    }

    $this->newLine();
    $this->info('Schema audit completed with no drift.');

    return self::SUCCESS;
  }
}
