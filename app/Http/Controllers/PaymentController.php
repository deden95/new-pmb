<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Payment;
use App\Models\Form;
use App\Models\Wave;
use Inertia\Response;
use Inertia\Inertia;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\PaymentRequest;
use Illuminate\Support\Facades\Log;
use App\Notifications\Candidate;

class PaymentController extends Controller
{
    public function index(Request $request): Response
    {
        $user = auth()->user();
        $form = $user->getForm;
    
        $payments = $user->payments;
        $latestPayment = $payments->first(); 
    
        $data = [
            'form' => $form ? [
                'id' => $form->id,
                'status' => $form->status,
                'wave' => $form->wave,
                'is_paid_registration' => $form->is_paid_registration,
                'code' => $form->code_registration,
            ] : null,
            'payment_id' => $latestPayment?->id,
            'payment' => $payments->map(function ($payment) {
                return [
                    ...$payment->toArray(),
                    'image' => $payment->getFirstMediaUrl('image'),
                ];
            }),
        ];
    
        return Inertia::render('Payment/Index', $data);
    }
    

    public function store(PaymentRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $user = auth()->user();

        if (!$validated['amount']) {
            return response()->json([
                'success' => false,
                'message' => 'Amount harus diisi!',
            ], 400);
        }

        $existingPayment = $user->payments()->where('code', $request->code)->first();

        if ($existingPayment) {
            return response()->json([
                'success' => false,
                'message' => 'Pembayaran dengan kode ini sudah ada!',
            ], 400);
        }

        // Membuat pembayaran baru
        $payment = $user->payments()->create([
            'bank' => "Gunas Pay",
            'account_name' => $user->name,
            'account_number' => $user->phone,
            'amount' => $validated['amount'],
            'date' => now(),
            'type_payment' => "form",
            'code' => $request->code,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pembayaran berhasil dibuat!',
            'payment' => $payment,
        ], 201);
    }

    public function checkPaymentStatus(): JsonResponse
    {
        $user = auth()->user();

        $payment = Payment::where('user_id', $user->id)
            ->where('status', 'pending')
            ->where('type_payment', 'form')
            ->first();

        if ($payment) {
            return response()->json(['redirect' => true, 'message' => 'Pending payment found.']);
        } else {
            return response()->json(['redirect' => false, 'message' => 'No pending payment.']);
        }
    }

    public function userDestroy(string $id): RedirectResponse
    {
        $userPayment = auth()->user()->payments()->where('id', $id)->first();
        if ($userPayment && $userPayment->status !== 'approved') {
            $userPayment->delete();
            session()->flash('alert', [
                'type' => 'success',
                'message' => 'Pembayaran berhasil dihapus'
            ]);
        }
        return redirect()->back();
    }

    public function invoice($id)
    {
        $payment = Payment::findOrFail($id);

        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $orderId = uniqid('TRX-', true);
        $payment->reference = $orderId;
        $payment->save();

        $params = [
            'transaction_details' => [
                'order_id' => $payment->reference,
                'gross_amount' => $payment->amount,
            ],
            'customer_details' => [
                'first_name' => $payment->account_name,
                'email' => auth()->user()->email,
                'phone' => $payment->account_number,
            ],
        ];

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        return Inertia::render('Payment/Invoice', [
            'token' => $snapToken,
            'payment' => $payment,
        ]);
    }    
    
}
