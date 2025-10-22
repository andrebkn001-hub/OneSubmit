<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'bidang',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the proposals submitted by this user (for mahasiswa).
     */
    public function proposals(): HasMany
    {
        return $this->hasMany(Proposal::class);
    }

    /**
     * Get the proposals assigned to this user as dosen KJFD.
     */
    public function assignedProposals(): HasMany
    {
        return $this->hasMany(Proposal::class, 'dosen_kjfd_id');
    }

    /**
     * Check if user is admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is dosen KJFD.
     */
    public function isDosenKjfd(): bool
    {
        return $this->role === 'dosen_kjfd';
    }

    /**
     * Check if user is mahasiswa.
     */
    public function isMahasiswa(): bool
    {
        return $this->role === 'mahasiswa';
    }

    /**
     * Check if user is jurusan.
     */
    public function isJurusan(): bool
    {
        return $this->role === 'jurusan';
    }

    /**
     * Get role label for display.
     */
    public function getRoleLabel(): string
    {
        return match($this->role) {
            'admin' => 'Administrator',
            'dosen_kjfd' => 'Dosen KJFD',
            'mahasiswa' => 'Mahasiswa',
            'jurusan' => 'Jurusan',
            default => 'Unknown',
        };
    }

    /**
     * Get bidang label for display.
     */
    public function getBidangLabel(): ?string
    {
        return $this->bidang ? ucfirst($this->bidang) : null;
    }
}
