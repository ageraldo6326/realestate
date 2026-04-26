<?php

return [
  /*
    |--------------------------------------------------------------------------
    | Required Columns By Table
    |--------------------------------------------------------------------------
    |
    | Keep here the columns that the application expects to exist. This does
    | not modify schema automatically; it only reports drift so you can add a
    | reconciliation migration.
    |
    */
  'required_columns' => [
    'users' => [
      'activo',
      'rol',
      'mostrar',
      'orden',
    ],
  ],
];
