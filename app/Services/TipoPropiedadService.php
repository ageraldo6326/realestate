<?php

namespace App\Services;

use App\Models\TiposDePropiedad;
use Illuminate\Pagination\Paginator;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class TipoPropiedadService
{
  /**
   * Buscar tipos de propiedad con paginación
   *
   * @param string $criterio
   * @param int $perPage
   * @return Paginator
   */
  public function buscar($criterio = '', $perPage = 10)
  {
    try {
      return TiposDePropiedad::searchByCriteria($criterio)
        ->orderByDesc('id')
        ->paginate($perPage);
    } catch (Exception $e) {
      Log::error('Error al buscar tipos de propiedad', [
        'criterio' => $criterio,
        'error' => $e->getMessage(),
      ]);
      throw $e;
    }
  }

  /**
   * Obtener todos los tipos de propiedad (sin paginación)
   *
   * @param bool $includeDeleted
   * @return \Illuminate\Database\Eloquent\Collection
   */
  public function getAll($includeDeleted = false)
  {
    try {
      $query = TiposDePropiedad::orderBy('tipo', 'asc');

      if ($includeDeleted) {
        $query->withTrashed();
      }

      return $query->get();
    } catch (Exception $e) {
      Log::error('Error al obtener todos los tipos de propiedad', [
        'error' => $e->getMessage(),
      ]);
      throw $e;
    }
  }

  /**
   * Obtener tipo de propiedad por ID
   *
   * @param int $id
   * @return TiposDePropiedad|null
   */
  public function getById($id)
  {
    try {
      return TiposDePropiedad::findOrFail($id);
    } catch (Exception $e) {
      Log::warning('Tipo de propiedad no encontrado', [
        'id' => $id,
      ]);
      throw $e;
    }
  }

  /**
   * Crear un nuevo tipo de propiedad
   *
   * @param array $data
   * @return TiposDePropiedad
   */
  public function crear($data)
  {
    try {
      return DB::transaction(function () use ($data) {
        $tipoPropiedad = TiposDePropiedad::create([
          'tipo' => trim($data['tipo']),
        ]);

        Log::info('Tipo de propiedad creado', [
          'id' => $tipoPropiedad->id,
          'tipo' => $tipoPropiedad->tipo,
        ]);

        return $tipoPropiedad;
      });
    } catch (Exception $e) {
      Log::error('Error al crear tipo de propiedad', [
        'data' => $data,
        'error' => $e->getMessage(),
      ]);
      throw $e;
    }
  }

  /**
   * Actualizar tipo de propiedad
   *
   * @param TiposDePropiedad $tipoPropiedad
   * @param array $data
   * @return TiposDePropiedad
   */
  public function actualizar(TiposDePropiedad $tipoPropiedad, $data)
  {
    try {
      return DB::transaction(function () use ($tipoPropiedad, $data) {
        $oldTipo = $tipoPropiedad->tipo;

        $tipoPropiedad->update([
          'tipo' => trim($data['tipo']),
        ]);

        Log::info('Tipo de propiedad actualizado', [
          'id' => $tipoPropiedad->id,
          'old_tipo' => $oldTipo,
          'new_tipo' => $tipoPropiedad->tipo,
        ]);

        return $tipoPropiedad;
      });
    } catch (Exception $e) {
      Log::error('Error al actualizar tipo de propiedad', [
        'id' => $tipoPropiedad->id,
        'data' => $data,
        'error' => $e->getMessage(),
      ]);
      throw $e;
    }
  }

  /**
   * Eliminar (soft delete) tipo de propiedad
   *
   * @param TiposDePropiedad $tipoPropiedad
   * @return bool
   */
  public function eliminar(TiposDePropiedad $tipoPropiedad)
  {
    try {
      return DB::transaction(function () use ($tipoPropiedad) {
        Log::info('Tipo de propiedad eliminado', [
          'id' => $tipoPropiedad->id,
          'tipo' => $tipoPropiedad->tipo,
        ]);

        return $tipoPropiedad->delete();
      });
    } catch (Exception $e) {
      Log::error('Error al eliminar tipo de propiedad', [
        'id' => $tipoPropiedad->id,
        'error' => $e->getMessage(),
      ]);
      throw $e;
    }
  }

  /**
   * Restaurar tipo de propiedad eliminado
   *
   * @param int $id
   * @return bool
   */
  public function restaurar($id)
  {
    try {
      return DB::transaction(function () use ($id) {
        $tipoPropiedad = TiposDePropiedad::onlyTrashed()->findOrFail($id);

        Log::info('Tipo de propiedad restaurado', [
          'id' => $tipoPropiedad->id,
          'tipo' => $tipoPropiedad->tipo,
        ]);

        return $tipoPropiedad->restore();
      });
    } catch (Exception $e) {
      Log::error('Error al restaurar tipo de propiedad', [
        'id' => $id,
        'error' => $e->getMessage(),
      ]);
      throw $e;
    }
  }

  /**
   * Eliminar permanentemente
   *
   * @param int $id
   * @return bool
   */
  public function eliminarPermanente($id)
  {
    try {
      return DB::transaction(function () use ($id) {
        $tipoPropiedad = TiposDePropiedad::onlyTrashed()->findOrFail($id);

        Log::warning('Tipo de propiedad eliminado permanentemente', [
          'id' => $tipoPropiedad->id,
          'tipo' => $tipoPropiedad->tipo,
        ]);

        return $tipoPropiedad->forceDelete();
      });
    } catch (Exception $e) {
      Log::error('Error al eliminar permanentemente tipo de propiedad', [
        'id' => $id,
        'error' => $e->getMessage(),
      ]);
      throw $e;
    }
  }
}
