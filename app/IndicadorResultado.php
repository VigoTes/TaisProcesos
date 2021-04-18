<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IndicadorResultado extends Model
{
    public $timestamps = false;

    protected $table = 'indicador_resultado';

    protected $primaryKey = 'codIndicadorResultado';

    protected $fillable = [
        'descripcion','codResultadoEsperado'
    ];
}
