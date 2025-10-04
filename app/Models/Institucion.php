<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Institucion extends Model
{
    protected $table = 'instituciones';

    protected $fillable = [
        'titulo',
        'descripcion'
    ];

    public function reuniones(): HasMany
    {
        return $this->hasMany(Reunion::class, 'institucion_id');
    }
}