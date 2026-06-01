<?php

namespace App\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Kolom yang dapat diisi secara massal (Mass Assignment).
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'sponsor_id',    // Diperlukan saat registrasi
        'path',          // Diperlukan untuk pelacakan level
        'referral_code', // Kode unik agen
        'status',        // Status keaktifan
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

    /**
     * RELASI: Mengambil Sponsor / Upline Langsung (1 tingkat di atas)
     */
    public function sponsor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sponsor_id');
    }

    /**
     * RELASI: Mengambil Downline Langsung (Orang-orang di Level 1 milik agen ini)
     */
    public function referrals(): HasMany
    {
        return $this->hasMany(User::class, 'sponsor_id');
    }

    /**
     * FUNGSI BANTUAN: Mendapatkan daftar ID Upline ke atas (Maksimal 10 tingkat)
     * Berguna untuk Fase 2 saat pembagian bonus berantai.
     */
    public function getUplineIds(): array
    {
        if (empty($this->path)) {
            return [];
        }

        // Mengubah string "1/3/7" menjadi array [1, 3, 7] lalu dibalik menjadi [7, 3, 1]
        // Sehingga indeks 0 adalah upline terdekat, tingkat berikutnya mengikuti di belakangnya.
        $uplineArray = explode('/', trim($this->path, '/'));
        return array_reverse($uplineArray);
    }

    /**
     * FUNGSI BANTUAN: Cek apakah user adalah Admin Pusat
     * (Misalkan user dengan ID 1 atau email tertentu adalah admin)
     */
    public function isAdmin(): bool
    {
        // Anda bisa menyesuaikan logika ini, misalnya mengecek kolom 'role' 
        // jika Anda menambahkannya di migration. Untuk skema awal, kita asumsikan ID 1 adalah Admin Pusat.
        return $this->id === 1; 
    }

    public function isAgent(): bool
    {
        return $this->id !== 1;
    }

    /**
     * RELASI: Satu user memiliki satu dompet (Wallet)
     */
    public function wallet(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Wallet::class, 'user_id');
    }

    /**
     * RELASI: Satu user memiliki banyak riwayat transaksi
     */
    public function transactions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Transaction::class, 'user_id');
    }

    /**
     * RELASI: Satu user memiliki banyak penarikan dana
     */
    public function withdrawals(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Withdrawal::class, 'user_id');
    }
}