<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Personas extends Model
{
    protected $primaryKey = 'cedula';
    public $incrementing = false;

    protected $fillable = [
        'nombre',
        'apellido',
        'segundo_nombre',
        'segundo_apellido',
        'nacionalidad',
        'genero',
        'cedula',
        'nacimiento',
        'direccion',
        'telefono',
        'email'
    ];

    protected $hidden = [];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'nacimiento' => 'date',
        ];
    }

    public function usuario(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
