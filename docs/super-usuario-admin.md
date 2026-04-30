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

## Protecciones activas (2026-04-26)

- El superadmin definido por `SUPERADMIN_EMAIL` queda protegido en UI.
- No se puede eliminar ni desactivar desde administracion mientras `ALLOW_SUPERADMIN_MUTATIONS=false`.
- Si el superadmin mantiene la clave bootstrap de `.env` (`SUPERADMIN_BOOTSTRAP_PASSWORD`), el sistema fuerza rotacion antes de entrar al panel.
- Ruta de rotacion obligatoria: `/admin/security/superadmin/password`.

### Variables de entorno

```bash
SUPERADMIN_EMAIL=admin@realestate.local
SUPERADMIN_BOOTSTRAP_PASSWORD=Admin12345
ENFORCE_SUPERADMIN_PASSWORD_ROTATION=true
ALLOW_SUPERADMIN_MUTATIONS=false
```

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

---

## Cambios recientes al superadmin (2026-04-26)

### Proteccion UI contra eliminacion y desactivacion

Se implemento proteccion de doble capa para el superadmin en el panel de administracion:

1. **Capa de negocio** — El controlador de usuarios verifica si el usuario objetivo es el superadmin (`SUPERADMIN_EMAIL`) antes de procesar eliminaciones o cambios de estado. Si `ALLOW_SUPERADMIN_MUTATIONS=false`, devuelve error 403.

2. **Capa de vista** — En los listados de usuarios, el boton de eliminar y el toggle de activacion quedan visualmente bloqueados para el superadmin (no renderizan la accion destructiva), independientemente del permiso del usuario autenticado.

### Rotacion de clave obligatoria

Si el superadmin inicia sesion con la clave bootstrap (`SUPERADMIN_BOOTSTRAP_PASSWORD`), el sistema detecta la coincidencia y redirige obligatoriamente a `/admin/security/superadmin/password` antes de permitir el acceso al panel.

El campo `ENFORCE_SUPERADMIN_PASSWORD_ROTATION=true` activa este comportamiento. Ponerlo en `false` desactiva la verificacion (util solo en desarrollo local).

### Resumen de variables de entorno relacionadas

| Variable | Descripcion | Valor recomendado en produccion |
|---|---|---|
| `SUPERADMIN_EMAIL` | Email del superadmin protegido | Email real del administrador |
| `SUPERADMIN_BOOTSTRAP_PASSWORD` | Clave inicial usada solo para detectar si ya fue rotada | Vaciar tras primer login |
| `ENFORCE_SUPERADMIN_PASSWORD_ROTATION` | Fuerza rotacion si clave coincide con bootstrap | `true` |
| `ALLOW_SUPERADMIN_MUTATIONS` | Permite eliminar/desactivar el superadmin desde la UI | `false` |
