<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProyectoContador extends Model
{
    public $timestamps = false;

    protected $table = 'proyecto_contador';

    protected $primaryKey = 'codProyectoContador';

    protected $fillable = [
        'codEmpleadoContador','codProyecto'
    ];
}
