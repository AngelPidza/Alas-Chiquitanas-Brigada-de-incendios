<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TiposSangre
 * 
 * @property string $id
 * @property string $codigo
 * @property string|null $descripcion
 * @property bool|null $activo
 * @property Carbon|null $creado
 * 
 * @property Collection|Usuario[] $usuarios
 *
 * @package App\Models
 */
class TiposSangre extends Model
{
	protected $table = 'tipos_sangre';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'string',
		'activo' => 'bool',
		'creado' => 'datetime'
	];

	protected $fillable = [
		'codigo',
		'descripcion',
		'activo',
		'creado'
	];

	public function usuarios()
	{
		return $this->hasMany(Usuario::class, 'tipo_sangre_id');
	}
}
