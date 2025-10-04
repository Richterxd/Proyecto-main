<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'usuarios';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $primaryKey = 'persona_cedula';

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

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'persona_cedula',
        'role',
        'password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function roleModel(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role', 'role');
    }

    public function persona(): BelongsTo
    {
        return $this->belongsTo(Personas::class, 'persona_cedula', 'cedula');
    }

    /**
     * Get the security answers for this user.
     */
    public function securityAnswers(): HasMany
    {
        return $this->hasMany(UserSecurityAnswer::class, 'user_cedula', 'persona_cedula');
    }

    /**
     * Get the solicitudes for this user.
     */
    public function solicitudes(): HasMany
    {
        return $this->hasMany(Solicitud::class, 'persona_cedula', 'persona_cedula');
    }

    /**
     * Get the visitas for this user.
     */
    public function visitas(): HasMany
    {
        return $this->hasMany(Visita::class, 'persona_cedula', 'persona_cedula');
    }

    /**
     * Check if user has specific role
     */
    public function hasRole($role)
    {
        return $this->role == $role;
    }

    /**
     * Check if user is Usuario (normal user)
     */
    public function isUsuario()
    {
        return $this->role == 3;
    }

    /**
     * Check if user is Administrador
     */
    public function isAdministrador()
    {
        return $this->role == 2;
    }

    /**
     * Check if user is SuperAdministrador
     */
    public function isSuperAdministrador()
    {
        return $this->role == 1;
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
