<?php

namespace App\Policies;

use App\Models\User;
use App\Models\TiposDePropiedad;
use Illuminate\Auth\Access\HandlesAuthorization;

class TipoPropiedadPolicy
{
  use HandlesAuthorization;

  /**
   * Determine whether the user can view any tipo de propiedad.
   *
   * @param  \App\Models\User  $user
   * @return \Illuminate\Auth\Access\Response|bool
   */
  public function viewAny(User $user)
  {
    return $user->hasRole('admin');
  }

  /**
   * Determine whether the user can view the tipo de propiedad.
   *
   * @param  \App\Models\User  $user
   * @param  \App\Models\TiposDePropiedad  $tipoPropiedad
   * @return \Illuminate\Auth\Access\Response|bool
   */
  public function view(User $user, TiposDePropiedad $tipoPropiedad)
  {
    return $user->hasRole('admin');
  }

  /**
   * Determine whether the user can create tipo de propiedad.
   *
   * @param  \App\Models\User  $user
   * @return \Illuminate\Auth\Access\Response|bool
   */
  public function create(User $user)
  {
    return $user->hasRole('admin');
  }

  /**
   * Determine whether the user can update the tipo de propiedad.
   *
   * @param  \App\Models\User  $user
   * @param  \App\Models\TiposDePropiedad  $tipoPropiedad
   * @return \Illuminate\Auth\Access\Response|bool
   */
  public function update(User $user, TiposDePropiedad $tipoPropiedad)
  {
    return $user->hasRole('admin');
  }

  /**
   * Determine whether the user can delete the tipo de propiedad.
   *
   * @param  \App\Models\User  $user
   * @param  \App\Models\TiposDePropiedad  $tipoPropiedad
   * @return \Illuminate\Auth\Access\Response|bool
   */
  public function delete(User $user, TiposDePropiedad $tipoPropiedad)
  {
    return $user->hasRole('admin');
  }

  /**
   * Determine whether the user can restore the tipo de propiedad.
   *
   * @param  \App\Models\User  $user
   * @param  \App\Models\TiposDePropiedad  $tipoPropiedad
   * @return \Illuminate\Auth\Access\Response|bool
   */
  public function restore(User $user, TiposDePropiedad $tipoPropiedad)
  {
    return $user->hasRole('admin');
  }

  /**
   * Determine whether the user can permanently delete the tipo de propiedad.
   *
   * @param  \App\Models\User  $user
   * @param  \App\Models\TiposDePropiedad  $tipoPropiedad
   * @return \Illuminate\Auth\Access\Response|bool
   */
  public function forceDelete(User $user, TiposDePropiedad $tipoPropiedad)
  {
    return $user->hasRole('superadmin'); // Solo superadmin puede eliminar permanentemente
  }
}
