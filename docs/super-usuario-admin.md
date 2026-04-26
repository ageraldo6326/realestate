# Super Usuario Admin

Fecha de registro: 2026-04-24

## Credenciales

- Email: admin@realestate.local
- Password: Admin12345

## Estado validado

- Usuario existe en base de datos: true
- Activo: 1
- Rol legacy (users.rol): 1
- Rol Spatie: admin
- Hash de password valido: true

## Nota de seguridad

Se recomienda cambiar esta clave despues del primer inicio de sesion.

## Comandos de entorno demo

Objetivo: tener una base limpia y poblarla rapido para pruebas/demos sin perder el superadmin.

1. Limpiar base y dejar solo superadmin:

```bash
php artisan demo:reset-preserve-superadmin
```

Opcional (sin confirmacion):

```bash
php artisan demo:reset-preserve-superadmin --force
```

2. Ejecutar seeders de demo (catalogos + home):

```bash
php artisan demo:seed-all
```

Opcional (sin confirmacion):

```bash
php artisan demo:seed-all --force
```

3. (Opcional) Descargar/actualizar imagenes libres para demo:

```bash
php artisan demo:fetch-images
```

Opcional (re-descargar todo sin preguntar):

```bash
php artisan demo:fetch-images --refresh --force
```

### Flujo recomendado para demos

```bash
php artisan demo:reset-preserve-superadmin --force
php artisan demo:seed-all --force
```

### Que hace cada comando

- `demo:reset-preserve-superadmin`: ejecuta `db:wipe`, corre `migrate`, recrea el superadmin (`admin@realestate.local`) y le asigna rol `admin` de Spatie.
- `demo:fetch-images`: descarga imagenes de demo desde Pexels CDN a `public/assets` (portada, propiedades, blog y testimonios).
- `properties:ensure-cover-images`: completa `foto_portada` en cualquier propiedad que no tenga imagen.
- `demo:seed-all`: corre `demo:fetch-images`, luego `CatalogosSeeder`, `HomeDataSeeder` y finalmente `properties:ensure-cover-images` para garantizar portada en todas las propiedades.

### Nota sobre derechos de uso

Las imagenes de demo se descargan desde Pexels CDN (contenido libre bajo licencia Pexels). Si usaras el proyecto en produccion o campañas pagadas, valida siempre los terminos vigentes de cada activo.
