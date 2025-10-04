<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ambito extends Model
{
    protected $table = 'ambitos';

    protected $primaryKey = 'ambito_id';

    protected $fillable = [
        'titulo',
        'descripcion'
    ];

    public function solicitudes(): HasMany
    {
        return $this->hasMany(Solicitud::class, 'ambito_id');
    }

    public function visitas(): HasMany
    {
        return $this->hasMany(Visita::class, 'ambito_id');
    }
}