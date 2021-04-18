<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Matriz extends Model
{
    protected $table = "matrizprocorg";
    protected $primaryKey = "idMatriz";

    public $timestamps = false;  //para que no trabaje con los campos fecha 

        // le indicamos los campos de la tabla 
        protected $fillable = ['nroEnEmpresa','idEmpresa','tipoDeMatriz','descripcion'];



}
