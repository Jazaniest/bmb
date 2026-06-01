<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegistrationPayment;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;

class PaymentController extends Controller
{
    /**
     * SISI AGEN: Mengunggah Bukti Pembayaran Rp 3.500.000 
     */
    public function uploadProof(Request $request): JsonResponse
    {
        $request->validate([
            'bank_name' => 'required|string|max:100',
            'account_name' => 'required|string|max:100',
            'proof_of_payment' => 'required|image|mimes:jpg,jpeg,png|max:2048', // Maksimal 2MB
        ]);

        $user = auth()->user();

        // Pastikan user memang masih pending
        if ($user->status === 'active') {
            return response()->json(['message' => 'Akun Anda sudah aktif.'], 400);
        }

        // Simpan file gambar ke folder storage/app/public/proofs
        $filePath = $request->file('proof_of_payment')->store('proofs', 'public');

        // Catat data pembayaran ke database
        $payment = RegistrationPayment::create([
            'user_id' => $user->id,
            'amount' => 3500000, // Sesuai biaya pendaftaran 
            'bank_name' => $request->bank_name,
            'account_name' => $request->account_name,
            'proof_of_payment' => $filePath,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Bukti pembayaran berhasil diunggah. Menunggu verifikasi dari Admin Pusat.',
            'data' => $payment
        ], 201);
    }

    /**
     * SISI ADMIN: Memverifikasi & Mengaktifkan Akun Agen
     */
    public function verifyPayment(Request $request, $id): JsonResponse
    {
        $request->validate([
            'action' => 'required|in:approve,reject',
            'notes' => 'nullable|string'
        ]);

        $payment = RegistrationPayment::with('user')->findOrFail($id);

        if ($payment->status !== 'pending') {
            return response()->json(['message' => 'Pembayaran ini sudah pernah diproses sebelumnya.'], 400);
        }

        if ($request->action === 'approve') {
            // 1. Ubah status invoice pembayaran menjadi approved
            $payment->update(['status' => 'approved', 'notes' => $request->notes]);

            // 2. AKTIFKAN AKUN USER JADI ACTIVE
            $payment->user->update(['status' => 'active']);

            return response()->json([
                'success' => true,
                'message' => 'Pembayaran disetujui. Akun agen "' . $payment->user->name . '" sekarang telah AKTIF.'
                // NOTE: Di Fase 2 nanti, di titik inilah kita akan menembakkan pemicu (trigger) Bonus Jaringan!
            ]);
            
        } else {
            // Jika ditolak admin
            $payment->update(['status' => 'rejected', 'notes' => $request->notes]);
            return response()->json([
                'success' => true,
                'message' => 'Pembayaran ditolak. Calon jamaah harus mengunggah ulang bukti yang valid.'
            ]);
        }
    }
}