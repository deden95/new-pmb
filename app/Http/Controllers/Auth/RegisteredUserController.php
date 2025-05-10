<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Str;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
            'phone' => ['required', 'unique:' . User::class, 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
    
        // Generate OTP
        $otp = rand(100000, 999999);
        $otpExpiresAt = now()->addMinutes(10);
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'otp' => $otp,
            'otp_expires_at' => $otpExpiresAt,
        ]);
    
        // Kirim OTP via Fonnte
        $this->sendOTPviaFonnte($user->phone, $otp);
    
        event(new Registered($user));
        
        // Login user sementara (bisa dihapus jika ingin verifikasi OTP dulu)
        Auth::login($user);
    
        // Redirect ke halaman verifikasi OTP
        return redirect()->route('verification.otp');
    }
    
    /**
     * Send OTP via Fonnte API
     */
    public function sendOTPviaFonnte($phone, $otp)
    {
        $fonnteToken = env('FONNTE_API_TOKEN');
        $message = "Kode OTP Anda adalah: $otp\n\nJangan berikan kode ini kepada siapapun. Kode berlaku 10 menit.";
        
        $client = new \GuzzleHttp\Client();
        
        try {
            $response = $client->post('https://api.fonnte.com/send', [
                'headers' => [
                    'Authorization' => $fonnteToken,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'target' => $phone,
                    'message' => $message,
                    'countryCode' => '62', // Kode negara Indonesia
                ],
            ]);
            
            // Anda bisa log response jika perlu
            // \Log::info('Fonnte Response: ' . $response->getBody());
            
        } catch (\Exception $e) {
            \Log::error('Gagal mengirim OTP via Fonnte: ' . $e->getMessage());
        }
    }

    
}