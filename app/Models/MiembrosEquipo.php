<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MiembrosEquipo
 * 
 * @property string $id
 * @property string|null $id_equipo
 * @property string|null $id_usuario
 * @property Carbon|null $fecha_ingreso
 * @property string $es_lider
 * 
 * @property Equipo|null $equipo
 * @property Usuario|null $usuario
 *
 * @package App\Models
 */
class MiembrosEquipo extends Model
{
	protected $table = 'miembros_equipo';
	public $incrementing = false;
	protected $keyType = 'string';
	public $timestamps = false;

	protected $casts = [
		'id' => 'string',
		'id_equipo' => 'string',
		'id_usuario' => 'string',
		'fecha_ingreso' => 'datetime',
		'es_lider' => 'string'
	];

	protected $fillable = [
		'id_equipo',
		'id_usuario',
		'fecha_ingreso',
		'es_lider'
	];

	public function equipo()
	{
		return $this->belongsTo(Equipo::class, 'id_equipo');
	}

	public function usuario()
	{
		return $this->belongsTo(Usuario::class, 'id_usuario');
	}
}
