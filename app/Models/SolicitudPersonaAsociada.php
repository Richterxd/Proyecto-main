<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SolicitudPersonaAsociada extends Model
{
    protected $table = 'solicitud_personas_asociadas';

    protected $fillable = [
        'solicitud_id',
        'nombre_completo',
        'cedula',
        'telefono'
    ];

    public function solicitud(): BelongsTo
    {
        return $this->belongsTo(Solicitud::class, 'solicitud_id');
    }
}