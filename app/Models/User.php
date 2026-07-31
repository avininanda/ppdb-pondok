<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Helper untuk cek role
    public function isPanitia(): bool
    {
        return $this->role === 'panitia';
    }

    public function isCalonSantri(): bool
    {
        return $this->role === 'calon santri';
    }

    public function isPimpinan(): bool
    {
        return $this->role === 'pimpinan';
    }
}