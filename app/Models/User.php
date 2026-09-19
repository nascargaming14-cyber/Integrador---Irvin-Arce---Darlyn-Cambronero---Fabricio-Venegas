<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'user_name',
        'email',
        'telephone',
        'password',
        'role_id',
        'status_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

/**
 * Verifica si el usuario tiene acceso a un módulo específico
 * según el mapa definido en config/permissions.php
 */
    public function canAccess(string $module): bool
    {
        $roleName = $this->role->role_name ?? null;

        if (!$roleName) {
            return false;
        }

        $permissions = config('permissions');

        return in_array($module, $permissions[$roleName] ?? []);
    }

    public function isAdmin(): bool
    {
        return $this->role->role_name === 'Administrador';
    }

}