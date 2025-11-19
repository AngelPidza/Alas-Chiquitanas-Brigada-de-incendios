<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TiposIncidente
 * 
 * @property string $id
 * @property string $codigo
 * @property string $nombre
 * @property string|null $descripcion
 * @property string|null $color
 * @property string|null $icono
 * @property bool|null $activo
 * @property Carbon|null $creado
 * @property Carbon|null $actualizado
 * 
 * @property Collection|Reporte[] $reportes
 *
 * @package App\Models
 */
class TiposIncidente extends Model
{
	protected $table = 'tipos_incidente';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'string',
		'activo' => 'bool',
		'creado' => 'datetime',
		'actualizado' => 'datetime'
	];

	protected $fillable = [
		'codigo',
		'nombre',
		'descripcion',
		'color',
		'icono',
		'activo',
		'creado',
		'actualizado'
	];

	public function reportes()
	{
		return $this->hasMany(Reporte::class, 'tipo_incidente_id');
	}
}
