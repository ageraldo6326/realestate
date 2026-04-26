<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Throwable;

class DemoResetPreserveSuperadmin extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'demo:reset-preserve-superadmin
                            {--email=admin@realestate.local : Email del superadmin a preservar/crear}
                            {--password=Admin12345 : Password por defecto si el superadmin no existe}
                            {--force : Ejecutar sin confirmacion interactiva}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Limpia toda la base de datos, migra de nuevo y deja unicamente el superadmin activo.';

  public function handle(): int
  {
    $email = (string) $this->option('email');
    $password = (string) $this->option('password');

    $this->warn('Este comando eliminara todos los registros de la base de datos.');
    $this->line('Luego recreara estructura y dejara solo el superadmin.');

    if (!$this->option('force') && !$this->confirm('Deseas continuar?', false)) {
      $this->info('Operacion cancelada.');
      return self::SUCCESS;
    }

    try {
      $existing = User::where('email', $email)->first();

      $superadminData = [
        'name' => $existing?->name ?? 'Super Admin',
        'email' => $email,
        'password' => $existing?->password ?? Hash::make($password),
        'activo' => 1,
        'rol' => 1,
        'mostrar' => 1,
        'orden' => 1,
        'titulo' => $existing?->titulo,
        'metadescription' => $existing?->metadescription,
        'descripcion' => $existing?->descripcion,
        'telefono' => $existing?->telefono,
        'foto' => $existing?->foto,
        'facebook' => $existing?->facebook,
        'instagram' => $existing?->instagram,
        'tiktok' => $existing?->tiktok,
        'whatsapp' => $existing?->whatsapp,
      ];

      $this->info('1/4 Limpiando base de datos...');
      Artisan::call('db:wipe', ['--force' => true]);
      $this->output->write(Artisan::output());

      $this->info('2/4 Ejecutando migraciones...');
      Artisan::call('migrate', ['--force' => true]);
      $this->output->write(Artisan::output());

      $this->info('3/4 Re-creando superadmin...');
      $superadmin = User::create($superadminData);

      $this->info('4/4 Asignando rol admin (Spatie)...');
      $role = Role::firstOrCreate([
        'name' => 'admin',
        'guard_name' => 'web',
      ]);
      $superadmin->assignRole($role);

      $this->newLine();
      $this->info('Base limpia y superadmin restaurado correctamente.');
      $this->table(
        ['Campo', 'Valor'],
        [
          ['Email', $superadmin->email],
          ['Activo', (string) $superadmin->activo],
          ['Rol legacy (users.rol)', (string) $superadmin->rol],
          ['Rol Spatie', 'admin'],
        ]
      );

      return self::SUCCESS;
    } catch (Throwable $e) {
      $this->error('Error ejecutando demo:reset-preserve-superadmin');
      $this->error($e->getMessage());

      return self::FAILURE;
    }
  }
}
