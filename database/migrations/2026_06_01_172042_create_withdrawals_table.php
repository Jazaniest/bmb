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
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->id();
            // Menghubungkan penarikan dana ke user/agen yang mengajukan
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Nominal yang ingin ditarik
            $table->decimal('amount', 15, 2);
            
            // Informasi Bank Tujuan Transfer (Dicatat per transaksi demi validitas histori)
            $table->string('bank_name');       // Contoh: BCA, Mandiri, BRI
            $table->string('account_number');  // Nomor Rekening
            $table->string('account_name');    // Nama Pemilik Rekening
            
            // Status Siklus Penarikan Dana
            // pending  = Baru diajukan agen, saldo aktif dipotong sementara (dikunci)
            // approved = Admin sudah transfer cash, penarikan selesai
            // rejected = Admin menolak, saldo dikembalikan ke dompet agen
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            
            // Catatan transaksional (Bisa diisi alasan penolakan oleh admin atau nomor referensi transfer bank)
            $table->text('notes')->nullable(); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawals');
    }
};