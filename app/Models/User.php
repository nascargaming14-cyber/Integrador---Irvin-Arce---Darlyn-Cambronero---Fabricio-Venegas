<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use App\Traits\LogsActivity;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, LogsActivity;

    // password y remember_token ya se excluyen siempre desde el trait,
    // pero los dejamos explícitos aquí por claridad.
    protected array $auditExclude = ['password', 'remember_token'];

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
     * Envía el correo de restablecer contraseña (en español y con el botón).
     */
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPasswordNotification($token));
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
