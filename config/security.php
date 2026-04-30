<?php

return [
  /*
    |--------------------------------------------------------------------------
    | Superadmin Protegido
    |--------------------------------------------------------------------------
    |
    | Este email identifica al superadmin protegido dentro de la aplicacion.
    | Se usa para bloquear eliminacion/desactivacion desde UI por defecto.
    |
    */
  'superadmin_email' => env('SUPERADMIN_EMAIL', 'admin@realestate.local'),

  /*
    |--------------------------------------------------------------------------
    | Mutaciones del superadmin
    |--------------------------------------------------------------------------
    |
    | Por seguridad, eliminar o desactivar el superadmin esta bloqueado.
    | Activalo de forma explicita solo para mantenimiento controlado.
    |
    */
  'allow_superadmin_mutations' => env('ALLOW_SUPERADMIN_MUTATIONS', false),

  /*
    |--------------------------------------------------------------------------
    | Rotacion de clave inicial
    |--------------------------------------------------------------------------
    |
    | Si esta habilitado y el superadmin sigue usando la clave bootstrap del
    | .env, el sistema obliga a cambiarla antes de continuar en el panel.
    |
    */
  'enforce_superadmin_password_rotation' => env('ENFORCE_SUPERADMIN_PASSWORD_ROTATION', true),

  'superadmin_bootstrap_password' => env('SUPERADMIN_BOOTSTRAP_PASSWORD', ''),
];
