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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            
            // --- KOLOM STRUKTUR JARINGAN (MATAHARI) ---
            // sponsor_id mencatat siapa yang mengajak. Boleh null untuk akun pusat/admin pertama.
            $table->foreignId('sponsor_id')->nullable()->constrained('users')->onDelete('set null');
            
            // path mencatat silsilah kedalaman, contoh: "1/3/7/12"
            $table->text('path')->nullable(); 
            
            // Menggunakan tipe data string agar kode referral berupa kombinasi huruf & angka
            $table->string('referral_code')->unique()->nullable();
            
            // Status akun: pending (belum bayar) atau active (sudah lunas Rp 3.500.000)
            $table->enum('status', ['pending', 'active'])->default('pending');
            // ------------------------------------------

            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};