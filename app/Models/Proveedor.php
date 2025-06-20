<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model {
    protected $fillable = [
        'user_id',
        'categoria_servicio',
        'descripcion',
        'ubicacion',
        'telefono',
        'imagen',
    ];
}
