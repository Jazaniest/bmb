<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RegistrationPayment extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model.
     * (Secara default Laravel akan mendeteksi jamak, namun kita pertegas di sini)
     */
    protected $table = 'registration_payments';

    /**
     * Properti yang dapat diisi secara massal (Mass Assignment).
     */
    protected $fillable = [
        'user_id',
        'amount',
        'bank_name',
        'account_name',
        'proof_of_payment',
        'status',
        'notes',
    ];

    /**
     * RELASI: Mengembalikan data Pengguna/Agen yang melakukan pembayaran ini.
     * Menghubungkan kolom user_id di tabel ini ke id di tabel users.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}