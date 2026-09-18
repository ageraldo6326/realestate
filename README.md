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
  public/img \
  public/assets/usuario \
  public/media \
  storage/app/media/originals
sudo chown -R www-data:www-data storage bootstrap/cache public/img public/assets/usuario public/media
sudo find storage bootstrap/cache public/img public/assets/usuario public/media -type d -exec chmod 2775 {} +
sudo find storage bootstrap/cache public/img public/assets/usuario public/media -type f -exec chmod 664 {} +

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

## Procesamiento centralizado de imágenes y colas

Las nuevas imágenes integradas con `ImageUploadService` guardan el original privado en `storage/app/media/originals` y publican solo variantes optimizadas bajo `public/media`. No se eliminan ni migran automáticamente imágenes antiguas.

En producción, configura estas variables en `.env` antes de desplegar. AVIF debe permanecer desactivado hasta confirmar que el PHP de producción tiene GD con `imageavif` o Imagick con soporte AVIF.

```dotenv
QUEUE_CONNECTION=database
QUEUE_FAILED_DRIVER=database-uuids
IMAGE_ORIGINAL_DISK=local
IMAGE_DELIVERY_DISK=real_public
IMAGE_QUEUE=images
IMAGE_AVIF_ENABLED=false
```

Después de ejecutar las migraciones, deja un worker supervisado en ejecución. Crea `/etc/supervisor/conf.d/realestate-images.conf` con la ruta de producción real:

```ini
[program:realestate-images]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/html/realestate/artisan queue:work database --queue=images,default --sleep=3 --tries=3 --timeout=180 --memory=512 --max-time=3600
directory=/var/www/html/realestate
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=1
redirect_stderr=true
stdout_logfile=/var/www/html/realestate/storage/logs/images-worker.log
stopwaitsecs=200
```

Activa y verifica el worker:

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start realestate-images:*
sudo supervisorctl status realestate-images:*

sudo -u www-data php artisan queue:failed
sudo -u www-data php artisan queue:restart
```

Para regenerar variantes de imágenes ya registradas, sin eliminar sus originales, usa:

```bash
sudo -u www-data php artisan media:images:regenerate
sudo -u www-data php artisan media:images:regenerate 42 --profile=property_gallery
sudo -u www-data php artisan media:properties:import-legacy 12
```

No uses `queue:flush` ni `queue:clear` en producción: eliminarían trabajos pendientes. Para reintentar un error concreto, primero revisa `php artisan queue:failed` y después ejecuta `php artisan queue:retry <uuid>`.

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

## Carga de fotos de usuarios

Las fotos de perfil se convierten a WebP y se guardan en `public/assets/usuario`. El usuario del proceso PHP debe tener permisos de escritura sobre ese directorio; de lo contrario el sistema mostrará el avatar predeterminado y el log registrará `photo_processing.failed` con el mensaje `Can't write image data to path`.

El bloque de despliegue anterior crea y asigna los permisos correctos. Para corregir un servidor ya desplegado, ejecuta:

```bash
cd /var/www/html/realestate
sudo install -d -o www-data -g www-data -m 2775 public/assets/usuario
sudo chown -R www-data:www-data public/assets/usuario
sudo find public/assets/usuario -type d -exec chmod 2775 {} +
sudo find public/assets/usuario -type f -exec chmod 664 {} +
```

Si PHP-FPM/Apache usa otro usuario, sustituye `www-data` por el usuario real del proceso. No uses `chmod 777`.

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

## Publicación SEO y dominio canónico

Las URL públicas canónicas se generan desde variables de entorno, no desde el dominio de la petición. En producción configura:

```dotenv
APP_URL=https://www.merkelbienesraices.com.do
SEO_CANONICAL_URL=https://www.merkelbienesraices.com.do
SEO_INDEXING_ENABLED=true
```

En desarrollo y en `realestate.voipcom.net` conserva `SEO_INDEXING_ENABLED=false`. Esto publica `robots.txt` con `Disallow: /`, añade `X-Robots-Tag: noindex, nofollow` y evita que staging compita con el dominio final. Después de cambiar estas variables ejecuta `php artisan optimize:clear` y `php artisan optimize` con el usuario del proceso PHP.

El servidor web debe redirigir con 301, conservando ruta y query string, todas las variantes HTTP y sin `www` hacia `https://www.merkelbienesraices.com.do`. Laravel mantiene además estas compatibilidades:

- `/propiedad/{slug}` → `/propiedades/{slug}`
- `/post/{slug}` → `/blog/{slug}`
- `/{zona}` → `/propiedades/zona/{slug}`

Antes de habilitar la indexación confirma que `/robots.txt` y `/sitemap.xml` respondan 200 y que el sitemap no contenga el dominio de staging, propiedades ocultas/vendidas ni borradores.
