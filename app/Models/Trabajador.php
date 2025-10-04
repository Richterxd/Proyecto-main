<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trabajador extends Model
{
    use HasFactory;

    protected $table = 'trabajadores';
    protected $primaryKey = 'cedula';
    protected $keyType = 'int';
    public $incrementing = false;

    protected $fillable = [
        'nombres',
        'apellidos',
        'nacionalidad',
        'cedula',
        'fecha_nacimiento',
        'telefono',
        'correo',
        'direccion',
        'zona_trabajo',
        'cantidad_hijos'
    ];
}
