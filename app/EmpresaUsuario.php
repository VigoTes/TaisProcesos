<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmpresaUsuario extends Model
{
    protected $table = "empresausuario";
    protected $primaryKey = 'idAI';

    public $timestamps = false;  //para que no trabaje con los campos fecha 

        // le indicamos los campos de la tabla 
    protected $fillable = [
            'idUsuario', 'idEmpresa'
    ];

}
