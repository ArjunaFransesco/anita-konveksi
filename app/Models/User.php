<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property int    $id
 * @property string $name
 * @property string $username
 * @property string $password
 * @property string $role
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'username', 'password', 'role'];
    protected $hidden   = ['password', 'remember_token'];

    // ✅ Hapus 'password' => 'hashed' — penyebab double hash
    protected $casts = [];

    public function getAuthIdentifierName(): string
    {
        return 'username';
    }

    public function isOwner(): bool { return $this->role === 'owner'; }
    public function isAdmin(): bool { return $this->role === 'admin'; }
    public function isKasir(): bool { return $this->role === 'kasir'; }
}