<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Equipo
 * 
 * @property string $id
 * @property string $nombre_equipo
 * @property USER-DEFINED|null $ubicacion
 * @property int|null $cantidad_integrantes
 * @property string|null $estado_id
 * @property Carbon|null $creado
 * @property Carbon|null $actualizado
 * 
 * @property EstadosSistema|null $estados_sistema
 * @property Collection|MiembrosEquipo[] $miembros_equipos
 * @property Collection|Recurso[] $recursos
 * @property Collection|ComunariosApoyo[] $comunarios_apoyos
 *
 * @package App\Models
 */
class Equipo extends Model
{
	protected $table = 'equipos';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'string',
		'ubicacion' => 'USER-DEFINED',
		'cantidad_integrantes' => 'int',
		'estado_id' => 'string',
		'creado' => 'datetime',
		'actualizado' => 'datetime'
	];

	protected $fillable = [
		'nombre_equipo',
		'ubicacion',
		'cantidad_integrantes',
		'estado_id',
		'creado',
		'actualizado'
	];

	public function estados_sistema()
	{
		return $this->belongsTo(EstadosSistema::class, 'estado_id');
	}

	public function miembros_equipos()
	{
		return $this->hasMany(MiembrosEquipo::class, 'id_equipo');
	}

	public function recursos()
	{
		return $this->hasMany(Recurso::class, 'equipoid');
	}

	public function comunarios_apoyos()
	{
		return $this->hasMany(ComunariosApoyo::class, 'equipoid');
	}
}
