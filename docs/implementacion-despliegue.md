# Implementacion y Despliegue

Fecha: 2026-04-25

## Objetivo

Publicar la version actual del proyecto en un servidor nuevo, asegurando que Laravel funcione correctamente despues de clonar desde GitHub.

## Requisitos previos

- PHP compatible con el proyecto (recomendado PHP 8.1+).
- Composer instalado.
- Node.js y npm (solo si vas a compilar assets frontend en servidor).
- MySQL/MariaDB disponible y base de datos creada.
- Acceso a terminal con permisos para escribir en el proyecto.
- Web server configurado (Nginx o Apache) apuntando al directorio `public`.

## Implementacion especifica: Ubuntu + MySQL + Apache

### 1. Instalar stack base

```bash
sudo apt update
sudo apt install -y apache2 mysql-server unzip curl git
sudo apt install -y php php-cli php-common php-mbstring php-xml php-bcmath php-curl php-zip php-mysql php-gd libapache2-mod-php
```

Instalar Composer global si no esta disponible:

```bash
cd /tmp
curl -sS https://getcomposer.org/installer -o composer-setup.php
php composer-setup.php
sudo mv composer.phar /usr/local/bin/composer
composer --version
```

### 2. Configurar MySQL (base y usuario)

```bash
sudo mysql
```

Dentro de MySQL:

```sql
CREATE DATABASE realestate CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'realestate_user'@'localhost' IDENTIFIED BY 'CAMBIA_ESTA_CLAVE_SEGURA';
GRANT ALL PRIVILEGES ON realestate.* TO 'realestate_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### 3. Configurar VirtualHost de Apache

Crear el sitio:

```bash
sudo nano /etc/apache2/sites-available/realestate.conf
```

Contenido sugerido:

```apache
<VirtualHost *:80>
	ServerName tu-dominio.com
	ServerAlias www.tu-dominio.com
	DocumentRoot /var/www/realestate/public

	<Directory /var/www/realestate/public>
		AllowOverride All
		Require all granted
	</Directory>

	ErrorLog ${APACHE_LOG_DIR}/realestate_error.log
	CustomLog ${APACHE_LOG_DIR}/realestate_access.log combined
</VirtualHost>
```

Habilitar modulos y sitio:

```bash
sudo a2enmod rewrite headers expires
sudo a2dissite 000-default.conf
sudo a2ensite realestate.conf
sudo systemctl reload apache2
```

### 4. Permisos recomendados en Ubuntu

```bash
sudo chown -R www-data:www-data /var/www/realestate
sudo find /var/www/realestate -type f -exec chmod 644 {} \;
sudo find /var/www/realestate -type d -exec chmod 755 {} \;
sudo chmod -R 775 /var/www/realestate/storage /var/www/realestate/bootstrap/cache
```

## Flujo de implementacion

### 1. Clonar repositorio

```bash
git clone https://github.com/ageraldo6326/realestate.git
cd realestate
```

### 2. Configurar variables de entorno

```bash
cp .env.example .env
```

Editar `.env` con:

- APP_NAME, APP_URL, APP_ENV
- APP_DEBUG=false en produccion
- DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD
- MAIL\_\* segun proveedor

### 3. Instalar dependencias backend

```bash
composer install --no-dev --optimize-autoloader
```

### 4. Generar clave de aplicacion

```bash
php artisan key:generate
```

### 5. Migraciones

```bash
php artisan migrate --force
```

### 6. Enlace simbolico de storage

```bash
php artisan storage:link
```

### 7. Compilar o instalar assets frontend (si aplica)

Si tu despliegue necesita compilar assets:

```bash
npm ci
npm run prod
```

Si ya despliegas assets compilados desde CI/CD, este paso puede omitirse.

### 8. Limpiar y cachear Laravel

```bash
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 9. Permisos de carpetas

Asegurar permisos de escritura para:

- `storage`
- `bootstrap/cache`

Ejemplo en Linux:

```bash
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

### 10. Procesos recomendados en produccion

- Queue worker (si se usan colas):

```bash
php artisan queue:work --tries=3 --timeout=120
```

- Scheduler (cron):

```cron
* * * * * cd /ruta/al/proyecto && php artisan schedule:run >> /dev/null 2>&1
```

## Verificacion post-deploy

- El home carga sin error 500.
- Login admin/asesor funciona.
- Reportes cargan datos sin romper layout.
- Subida de archivos funciona (storage link correcto).
- No hay errores criticos en logs:

```bash
tail -f storage/logs/laravel.log
```

## Comandos utiles para entorno demo

Flujo recomendado para ambiente de demostracion:

```bash
php artisan demo:reset-preserve-superadmin --force
php artisan demo:seed-all --force
```

Credencial demo actual validada en documentacion:

- Email: admin@realestate.local
- Password: Admin12345

## Riesgos comunes y mitigacion

- Error de conexion DB: validar credenciales en `.env` y acceso de red.
- Error 403/500 por permisos: corregir owner/permisos en `storage` y `bootstrap/cache`.
- Assets rotos: ejecutar build frontend o validar `public/mix-manifest.json`.
- Colas detenidas: configurar supervisor/systemd para queue workers.

## Nota final

La rama `main` remota ya fue publicada en formato limpio, eliminando el historial conflictivo con archivos grandes. Esta guia parte de esa version actual para despliegues nuevos.
