# Actualización en producción

Ejecutar desde `/var/www/html/realestate` después de subir los cambios a la rama `main`.

```bash
cd /var/www/html/realestate

git status --short
git pull --ff-only origin main

COMPOSER_ALLOW_SUPERUSER=1 composer install --no-dev --prefer-dist --optimize-autoloader

npm ci
npm run production

php artisan optimize:clear
php artisan migrate --force
php artisan storage:link
php artisan permission:cache-reset

mkdir -p public/img
chown -R www-data:www-data storage bootstrap/cache public/img
chmod -R 775 storage bootstrap/cache public/img

php artisan optimize
php artisan queue:restart
systemctl reload apache2
```

Si `git status --short` muestra archivos modificados, no ejecutar `git pull` hasta revisar esos cambios. No ejecutar `php artisan key:generate` si `APP_KEY` ya está definido en el archivo `.env` de producción.

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
