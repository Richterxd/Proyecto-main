<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Reunion extends Model
{
    protected $table = 'reuniones';

    protected $fillable = [
        'titulo',
        'descripcion',
        'fecha_reunion',
        'ubicacion',
        'institucion_id',
        'solicitud_id'
    ];

    protected $casts = [
        'fecha_reunion' => 'datetime',
    ];

    public function institucion(): BelongsTo
    {
        return $this->belongsTo(Institucion::class, 'institucion_id');
    }

    public function solicitud(): BelongsTo
    {
        return $this->belongsTo(Solicitud::class, 'solicitud_id', 'solicitud_id');
    }

    public function asisten(): HasMany
    {
        return $this->hasMany(Asisten::class, 'reunion_id');
    }

    public function asistentes(): BelongsToMany
    {
        return $this->belongsToMany(Personas::class, 'asisten', 'reunion_id', 'persona_cedula', 'id', 'cedula')
                    ->withPivot(['es_consejal', 'rol_asistencia'])
                    ->withTimestamps();
    }

    public function consejales(): BelongsToMany
    {
        return $this->belongsToMany(Personas::class, 'asisten', 'reunion_id', 'persona_cedula', 'id', 'cedula')
                    ->wherePivot('es_consejal', true)
                    ->withPivot(['rol_asistencia'])
                    ->withTimestamps();
    }
}