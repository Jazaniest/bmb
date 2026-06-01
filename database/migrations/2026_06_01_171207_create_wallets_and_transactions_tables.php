<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. TABEL WALLETS (Dompet Agen)
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('balance', 15, 2)->default(0); // Saldo aktif saat ini yang bisa ditarik
            $table->decimal('total_earned', 15, 2)->default(0); // Akumulasi total bonus yang pernah didapat
            $table->timestamps();
        });

        // 2. TABEL TRANSACTIONS (Riwayat Mutasi Uang)
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Penerima/Pemilik dana
            $table->decimal('amount', 15, 2); // Nominal uang
            $table->enum('type', ['credit', 'debit']); // credit = uang masuk (bonus), debit = uang keluar (withdraw)
            
            // Kategori transaksi untuk mempermudah laporan di dashboard
            $table->enum('category', ['bonus_rekrut', 'bonus_level', 'withdrawal']); 
            
            $table->text('description')->nullable(); // Contoh: "Bonus Level 2 dari pendaftaran Ahmad"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('wallets');
    }
};