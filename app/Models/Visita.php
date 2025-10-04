<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Visita extends Model
{
    protected $table = 'visitas';

    protected $fillable = [
        'titulo',
        'descripcion',
        'fecha',
        'estado',
        'persona_cedula',
        'ambito_id'
    ];

    protected $casts = [
        'fecha' => 'datetime',
    ];

    public function persona(): BelongsTo
    {
        return $this->belongsTo(Personas::class, 'persona_cedula', 'cedula');
    }

    public function ambito(): BelongsTo
    {
        return $this->belongsTo(Ambito::class, 'ambito_id');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'persona_cedula', 'persona_cedula');
    }
}