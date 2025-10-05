<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Asisten extends Model
{
    protected $table = 'asisten';

    protected $fillable = [
        'reunion_id',
        'persona_cedula',
        'es_consejal',
        'rol_asistencia'
    ];

    protected $casts = [
        'es_consejal' => 'boolean',
    ];

    public function reunion(): BelongsTo
    {
        return $this->belongsTo(Reunion::class, 'reunion_id');
    }

    public function persona(): BelongsTo
    {
        return $this->belongsTo(Personas::class, 'persona_cedula', 'cedula');
    }
}