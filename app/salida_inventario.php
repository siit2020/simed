<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class salida_inventario extends Model
{
    protected $fillable = ['medicamento_id','cantidad','paciente_id','venta_id'];
}
