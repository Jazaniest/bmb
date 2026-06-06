<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'sponsor_id',
        'role',
        'path',
        'referral_code',
        'status',
        'bank_name',      // ← tambah
        'account_number', // ← tambah
        'account_name',   // ← tambah
        'balance',        // ← tambah
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
            'balance'           => 'decimal:2', // ← tambah cast
        ];
    }

    // ✅ Tetap ada
    public function sponsor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sponsor_id');
    }

    public function referrals(): HasMany
    {
        return $this->hasMany(User::class, 'sponsor_id');
    }

    public function getUplineIds(): array
    {
        if (empty($this->path)) return [];
        return array_reverse(explode('/', trim($this->path, '/')));
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isAgent(): bool
    {
        return $this->role === 'agent';
    }

    // ❌ HAPUS relasi wallet() yang lama

    // ✅ Tetap ada
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'user_id');
    }

    public function withdrawals(): HasMany
    {
        return $this->hasMany(Withdrawal::class, 'user_id');
    }
}