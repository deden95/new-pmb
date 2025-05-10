<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class OtpVerificationController extends Controller
{
    /**
     * Show the OTP verification form.
     */
    public function showOtpForm(): Response
    {
        return Inertia::render('Auth/VerifyOtp', [
            'phone' => Auth::user()->phone // Kirim nomor telepon ke view
        ]);
    }

    /**
     * Verify the OTP.
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric|digits:6',
        ]);

        $user = Auth::user();

        // Validasi jika user tidak ditemukan
        if (!$user) {
            return redirect()->route('login')->withErrors([
                'otp' => 'Sesi telah berakhir, silakan login kembali.'
            ]);
        }

        // Validasi OTP
        if ($user->otp === $request->otp && now()->lt($user->otp_expires_at)) {
            // Update status verifikasi
            $user->update([
                'email_verified_at' => now(),
                'otp' => null,
                'otp_expires_at' => null,
                'status' => 1 
            ]);

            return redirect()->route('dashboard')->with([
                'message' => 'Verifikasi OTP berhasil!',
                'status' => 'success'
            ]);
        }

        return back()->withErrors([
            'otp' => 'Kode OTP tidak valid atau sudah kadaluarsa.',
        ]);
    }

    /**
     * Resend OTP.
     */
    public function resendOtp()
    {
        $user = Auth::user();

        // Validasi jika user tidak ditemukan
        if (!$user) {
            return redirect()->route('login')->withErrors([
                'message' => 'Sesi telah berakhir, silakan login kembali.'
            ]);
        }

        // Generate OTP baru
        $otp = rand(100000, 999999);
        $otpExpiresAt = now()->addMinutes(10);
        
        // Update data OTP
        $user->update([
            'otp' => $otp,
            'otp_expires_at' => $otpExpiresAt
        ]);
        
        // Kirim OTP via Fonnte
        (new RegisteredUserController)->sendOTPviaFonnte($user->phone, $otp);
        
        return back()->with([
            'message' => 'Kode OTP baru telah dikirim!',
            'status' => 'success'
        ]);
    }
}