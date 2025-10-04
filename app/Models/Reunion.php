<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reunion extends Model
{
    protected $table = 'reuniones';

    protected $fillable = [
        'titulo',
        'descripcion',
        'fecha_reunion',
        'ubicacion',
        'institucion_id'
    ];

    protected $casts = [
        'fecha_reunion' => 'datetime',
    ];

    public function institucion(): BelongsTo
    {
        return $this->belongsTo(Institucion::class, 'institucion_id');
    }
}