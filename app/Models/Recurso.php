<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Recurso
 * 
 * @property string $id
 * @property string|null $codigo
 * @property string|null $tipo_recurso_id
 * @property string $descripcion
 * @property float|null $cantidad
 * @property Carbon|null $fecha_pedido
 * @property string|null $estado_id
 * @property float|null $lat
 * @property float|null $lng
 * @property uuid|null $equipoid
 * @property Carbon|null $creado
 * @property Carbon|null $actualizado
 * 
 * @property TiposRecurso|null $tipos_recurso
 * @property EstadosSistema|null $estados_sistema
 * @property Equipo|null $equipo
 *
 * @package App\Models
 */
class Recurso extends Model
{
	protected $table = 'recursos';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'string',
		'tipo_recurso_id' => 'string',
		'cantidad' => 'float',
		'fecha_pedido' => 'datetime',
		'estado_id' => 'string',
		'lat' => 'float',
		'lng' => 'float',
		'equipoid' => 'string',
		'creado' => 'datetime',
		'actualizado' => 'datetime'
	];

	protected $fillable = [
		'codigo',
		'tipo_recurso_id',
		'descripcion',
		'cantidad',
		'fecha_pedido',
		'estado_id',
		'lat',
		'lng',
		'equipoid',
		'creado',
		'actualizado'
	];

	public function tipos_recurso()
	{
		return $this->belongsTo(TiposRecurso::class, 'tipo_recurso_id');
	}

	public function estados_sistema()
	{
		return $this->belongsTo(EstadosSistema::class, 'estado_id');
	}

	public function equipo()
	{
		return $this->belongsTo(Equipo::class, 'equipoid');
	}
}
