<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /**
     * Menampilkan Form Pendaftaran Agen Baru
     */
    public function showRegistrationForm(Request $request)
    {
        $referralCode = $request->query('ref');
        return view('auth.register', compact('referralCode'));
    }

    /**
     * Memproses Data Form Pendaftaran (Fase POST)
     */
    public function storeRegister(Request $request)
    {
        // 1. Validasi Input Form
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'bank_name' => 'required|string',
            'account_number' => 'required|string',
            'account_name' => 'required|string',
        ]);

        // 2. Simpan data user baru ke database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'sponsor_id' => $this->getSponsorId($request->sponsor_code),
            'bank_name' => $request->bank_name,
            'account_number' => $request->account_number,
            'account_name' => $request->account_name,
            'balance' => 0,
            
            // --- DI SINI DIKUNCI OTOMATIS SEBAGAI AGENT ---
            'role' => 'agent', 
            'status' => 'pending', 
        ]);

        // 3. Otomatis loginkan user dan arahkan ke dashboard
        Auth::login($user);

        return redirect('/agent/dashboard')->with('success', 'Registrasi berhasil!');
    }

    /**
     * Helper Internal untuk memecah string kode referral menjadi User ID Sponsor
     */
    private function getSponsorId($sponsorCode)
    {
        if (empty($sponsorCode)) {
            return null;
        }

        // Contoh format kode referral: KKB-102
        // Kita pecah menggunakan tanda strip dan ambil angka paling belakang (ID)
        $parts = explode('-', $sponsorCode);
        $id = end($parts);

        // Pastikan user sponsor tersebut ada di database dan berstatus active
        $sponsorExists = User::where('id', $id)->where('status', 'active')->exists();

        return $sponsorExists ? $id : null;
    }
}