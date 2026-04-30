<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Throwable;

class DemoEnsureAdvisorAvatars extends Command
{
    protected $signature = 'demo:ensure-advisor-avatars
                            {--refresh : Reemplaza tambien fotos existentes de asesores demo}
                            {--force : Ejecutar sin confirmacion interactiva}';

    protected $description = 'Completa avatares faltantes de asesores demo para mantener el detalle de propiedad consistente.';

    public function handle(): int
    {
        if (!$this->option('force') && !$this->confirm('Deseas completar avatares de asesores demo?', true)) {
            $this->info('Operacion cancelada.');

            return self::SUCCESS;
        }

        try {
            $avatarMap = [
                'kelly@realestate.local' => 'cliente-1.jpg',
                'lavinia@realestate.local' => 'cliente-2.jpg',
                'mario@realestate.local' => 'cliente-3.jpg',
            ];

            $updated = 0;
            $skipped = 0;
            $missingUsers = 0;

            foreach ($avatarMap as $email => $avatarFile) {
                $advisor = User::query()->where('email', $email)->first();

                if (!$advisor) {
                    $this->warn("- Usuario no encontrado: {$email}");
                    $missingUsers++;
                    continue;
                }

                $shouldRefresh = (bool) $this->option('refresh');
                $hasAvatar = !empty($advisor->foto);

                if ($hasAvatar && !$shouldRefresh) {
                    $this->line("- Ya tiene avatar: {$email}");
                    $skipped++;
                    continue;
                }

                $avatarPath = public_path('assets/' . $avatarFile);
                if (!File::exists($avatarPath)) {
                    $this->warn("- Avatar no disponible en assets: {$avatarFile} (usuario {$email})");
                    $skipped++;
                    continue;
                }

                $advisor->foto = $avatarFile;
                $advisor->save();

                $this->info("- Avatar asignado a {$email}: {$avatarFile}");
                $updated++;
            }

            $this->newLine();
            $this->table(
                ['Metric', 'Count'],
                [
                    ['Updated', (string) $updated],
                    ['Skipped', (string) $skipped],
                    ['Missing users', (string) $missingUsers],
                ]
            );

            if ($updated > 0) {
                $this->info('Avatares demo verificados correctamente.');
            } else {
                $this->line('No se realizaron cambios en avatares demo.');
            }

            return self::SUCCESS;
        } catch (Throwable $e) {
            $this->error('Error ejecutando demo:ensure-advisor-avatars');
            $this->error($e->getMessage());

            return self::FAILURE;
        }
    }
}
