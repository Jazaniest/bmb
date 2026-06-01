<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            
            // Kode referral wajib diisi dan harus ada di kolom referral_code pada tabel users
            'referral_code' => ['required', 'string', 'exists:users,referral_code'],
        ];
    }

    public function messages(): array
    {
        return [
            'referral_code.exists' => 'Kode referral tidak valid atau agen tidak ditemukan.',
            'referral_code.required' => 'Anda harus mendaftar menggunakan link atau kode referral agen.',
        ];
    }
}