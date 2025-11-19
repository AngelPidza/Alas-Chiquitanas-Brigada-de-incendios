<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class NivelesEntrenamiento
 * 
 * @property string $id
 * @property string $nivel
 * @property string|null $descripcion
 * @property int|null $orden
 * @property bool|null $activo
 * @property Carbon|null $creado
 * 
 * @property Collection|Usuario[] $usuarios
 *
 * @package App\Models
 */
class NivelesEntrenamiento extends Model
{
	protected $table = 'niveles_entrenamiento';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'string',
		'orden' => 'int',
		'activo' => 'bool',
		'creado' => 'datetime'
	];

	protected $fillable = [
		'nivel',
		'descripcion',
		'orden',
		'activo',
		'creado'
	];

	public function usuarios()
	{
		return $this->hasMany(Usuario::class, 'nivel_entrenamiento_id');
	}
}
