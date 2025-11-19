<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class NivelesGravedad
 * 
 * @property string $id
 * @property string $codigo
 * @property string $nombre
 * @property string|null $descripcion
 * @property int|null $orden
 * @property string|null $color
 * @property bool|null $activo
 * @property Carbon|null $creado
 * 
 * @property Collection|Reporte[] $reportes
 *
 * @package App\Models
 */
class NivelesGravedad extends Model
{
	protected $table = 'niveles_gravedad';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'string',
		'orden' => 'int',
		'activo' => 'bool',
		'creado' => 'datetime'
	];

	protected $fillable = [
		'codigo',
		'nombre',
		'descripcion',
		'orden',
		'color',
		'activo',
		'creado'
	];

	public function reportes()
	{
		return $this->hasMany(Reporte::class, 'gravedad_id');
	}
}
