# Actualización en producción

Ejecutar desde `/var/www/html/realestate` después de subir los cambios a la rama `main`.

```bash
cd /var/www/html/realestate

git status --short
git pull --ff-only origin main

# Debe ejecutarse antes de Artisan: PHP/Apache necesita escribir el cache,
# las sesiones, las vistas compiladas y los logs.
sudo install -d -o www-data -g www-data -m 2775 \
  storage/framework/cache/data \
  storage/framework/sessions \
  storage/framework/views \
  storage/logs \
  bootstrap/cache \
  public/img
sudo chown -R www-data:www-data storage bootstrap/cache public/img
sudo find storage bootstrap/cache public/img -type d -exec chmod 2775 {} +
sudo find storage bootstrap/cache public/img -type f -exec chmod 664 {} +

COMPOSER_ALLOW_SUPERUSER=1 composer install --no-dev --prefer-dist --optimize-autoloader

npm ci
npm run production

sudo -u www-data php artisan optimize:clear
sudo -u www-data php artisan migrate --force
sudo -u www-data php artisan storage:link
sudo -u www-data php artisan permission:cache-reset
sudo -u www-data php artisan optimize
sudo -u www-data php artisan queue:restart
sudo systemctl reload apache2
```

Si `git status --short` muestra archivos modificados, no ejecutar `git pull` hasta revisar esos cambios. No ejecutar `php artisan key:generate` si `APP_KEY` ya está definido en el archivo `.env` de producción. En servidores donde PHP-FPM/Apache no utiliza `www-data`, sustituye `www-data` por el usuario real del proceso PHP. No uses `chmod 777`.

## Recuperar el error `file_put_contents(...storage/framework/cache/data...): Permission denied`

Ejecuta el bloque de permisos anterior en el servidor, desde `/var/www/html/realestate`, y luego ejecuta:

```bash
sudo -u www-data php artisan optimize:clear
sudo -u www-data php artisan optimize
sudo systemctl reload apache2
```

El error procede de un propietario o permisos incorrectos en `storage`/`bootstrap/cache`, no de `InmobiliariaService`. Además, verifica que producción tenga `APP_DEBUG=false`; de ese modo no se expone el stack trace al visitante.

## Carga de logo y favicon

Selecciona el archivo desde el campo **Logo** o **Favicon** del formulario; no se carga escribiendo una URL. Los archivos nuevos se guardan en `public/img` y se sirven desde una URL como `/img/logo-<hash>.png`. Una URL bajo `/admin/inmobiliaria/...` es una ruta administrativa y no corresponde a un archivo público.

## Crear superusuario

El usuario necesita solamente el rol `superadmin` de Spatie y `activo=1`. La aplicacion le concede acceso global desde un unico punto para los middlewares de rol/permisos y para Policies/Gates. Usa un correo y una contraseña únicos; nunca incluyas credenciales reales en Git.

1. En el `.env` de producción, define el correo del superusuario y una contraseña inicial segura. Este archivo no se sube al repositorio:

```dotenv
SUPERADMIN_EMAIL=admin@tu-dominio.com
SUPERADMIN_BOOTSTRAP_PASSWORD=REEMPLAZAR_POR_UNA_CLAVE_LARGA_Y_UNICA
ENFORCE_SUPERADMIN_PASSWORD_ROTATION=true
```

2. Desde la carpeta del proyecto, abre Tinker:

```bash
cd /var/www/html/realestate
php artisan tinker
```

3. Dentro de Tinker, reemplaza el nombre, correo y contraseña antes de ejecutar estas líneas:

```php
app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

$superadminRole = \Spatie\Permission\Models\Role::firstOrCreate([
    'name' => 'superadmin',
    'guard_name' => 'web',
]);

$user = \App\Models\User::withTrashed()->firstOrNew([
    'email' => 'admin@tu-dominio.com',
]);

if ($user->exists && $user->trashed()) {
    $user->restore();
}

$user->name = 'Administrador';
$user->password = \Illuminate\Support\Facades\Hash::make('REEMPLAZAR_POR_UNA_CLAVE_LARGA_Y_UNICA');
$user->activo = true;
$user->rol = 1;
$user->mostrar = true;
$user->save();
$user->syncRoles([$superadminRole]);
```

4. Sal con `exit`, reconstruye la caché e inicia sesión. Si la rotación está activa, cambia la contraseña inicial de inmediato. Después puedes vaciar `SUPERADMIN_BOOTSTRAP_PASSWORD` en `.env` y ejecutar `php artisan optimize`.
