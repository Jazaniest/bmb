<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bonus_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('level')->unique(); // Level 1 sampai 10
            $table->decimal('amount', 15, 2)->default(0); // Nominal bonus komisi
            $table->timestamps();
        });

        // Seed otomatis nilai default (Fase Awal) agar sistem tidak kosong saat bermigrasi
        for ($i = 1; $i <= 10; $i++) {
            DB::table('bonus_settings')->insert([
                'level' => $i,
                'amount' => ($i === 1) ? 1000000 : 100000, // Level 1 = 1jt, Level 2-10 = 100rb
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('bonus_settings');
    }
};