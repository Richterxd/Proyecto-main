<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $primaryKey = 'role';

    /**
     * The table associated with the model.
     *
     * @var int
     */
    protected $keyType = 'int';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    protected $fillable = [
        'role',
        'name',
        'description'
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'role', 'role');
    }

    /**
     * Get role name
     */
    public function getRoleName()
    {
        switch ($this->role) {
            case 1:
                return 'SuperAdministrador';
            case 2:
                return 'Administrador';
            case 3:
                return 'Usuario';
            default:
                return 'Sin Rol';
        }
    }
}
