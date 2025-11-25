<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TiposRecurso
 * 
 * @property string $id
 * @property string $codigo
 * @property string $nombre
 * @property string|null $categoria
 * @property string|null $descripcion
 * @property string|null $unidad_medida
 * @property bool|null $activo
 * @property Carbon|null $creado
 * @property Carbon|null $actualizado
 * 
 * @property Collection|Recurso[] $recursos
 *
 * @package App\Models
 */
class TiposRecurso extends Model
{
	protected $table = 'tipos_recurso';
	public $incrementing = false;
	protected $keyType = 'string';
	public $timestamps = false;

	protected $casts = [
		'id' => 'string',
		'unidad_medida' => 'string',
		'activo' => 'bool',
		'creado' => 'datetime',
		'actualizado' => 'datetime'
	];

	protected $fillable = [
		'codigo',
		'nombre',
		'categoria',
		'descripcion',
		'unidad_medida',
		'activo',
		'creado',
		'actualizado'
	];

	public function recursos()
	{
		return $this->hasMany(Recurso::class, 'tipo_recurso_id');
	}
}
