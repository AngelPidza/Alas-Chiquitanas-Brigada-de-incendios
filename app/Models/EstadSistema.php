<?php

namespace App\Models;

use App\Models\Equipo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;;
use App\Models\Recurso;
use App\Models\Reporte;
use App\Models\Usuario;

/**
 * @mixin \Eloquent
 */
class EstadSistema extends Model
{
    use HasFactory;
    
    protected $table = 'estados_sistema';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'creado' => 'datetime',
        ];
    }

    
    
    
    
    public function estadoEquipos(): HasMany
    {
        return $this->hasMany(Equipo::class, 'estado_id', 'id');
    }

    public function estadoRecursos(): HasMany
    {
        return $this->hasMany(Recurso::class, 'estado_id', 'id');
    }

    public function estadoReportes(): HasMany
    {
        return $this->hasMany(Reporte::class, 'estado_id', 'id');
    }

    public function estadoUsuarios(): HasMany
    {
        return $this->hasMany(Usuario::class, 'estado_id', 'id');
    }
}
