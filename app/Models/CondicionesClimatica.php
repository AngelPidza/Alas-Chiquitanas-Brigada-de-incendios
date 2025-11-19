<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CondicionesClimatica
 * 
 * @property string $id
 * @property string $codigo
 * @property string $nombre
 * @property string|null $descripcion
 * @property int|null $factor_riesgo
 * @property bool|null $activo
 * @property Carbon|null $creado
 * 
 * @property Collection|ReportesIncendio[] $reportes_incendios
 *
 * @package App\Models
 */
class CondicionesClimatica extends Model
{
	protected $table = 'condiciones_climaticas';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'string',
		'factor_riesgo' => 'int',
		'activo' => 'bool',
		'creado' => 'datetime'
	];

	protected $fillable = [
		'codigo',
		'nombre',
		'descripcion',
		'factor_riesgo',
		'activo',
		'creado'
	];

	public function reportes_incendios()
	{
		return $this->hasMany(ReportesIncendio::class, 'condicion_climatica_id');
	}
}
