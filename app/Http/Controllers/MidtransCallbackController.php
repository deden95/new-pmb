<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Payment;
use App\Models\Form;
use Inertia\Response;
use Inertia\Inertia;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Notifications\Candidate;
use Exception;

class MidtransCallbackController extends Controller
{
    public function callback(Request $request): JsonResponse
    {
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production', false);
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
    
        try {
            $notification = new \Midtrans\Notification();
    
            $orderId = $notification->order_id;
            $transactionStatus = $notification->transaction_status;
            $fraudStatus = $notification->fraud_status;
    
            $payment = Payment::where('reference', $orderId)->first();
            if (!$payment) {
                throw new \Exception('Payment not found for order ID: ' . $orderId);
            }
    
            $user = User::find($payment->user_id);
            if (!$user) {
                throw new \Exception('User not found for payment');
            }
    
            $form = $user->getForm;
    
            // Update status and note based on transaction status
            switch ($transactionStatus) {
                case 'capture':
                    if ($fraudStatus == 'challenge') {
                        $payment->status = 'challenge';
                        $payment->note = 'Payment challenged due to fraud';
                    } else {
                        $payment->status = 'approved';
                        $payment->note = 'Payment approved';
                        if ($payment->type_payment == 'form') {
                            $form->is_paid_registration = $payment->created_at;
                            $user->notify(
                                new Candidate(
                                    'Pembayaran',
                                    'Selamat, pembayaran pendaftaran Anda telah diterima. Silahkan lengkapi data diri Anda untuk melanjutkan proses pendaftaran.'
                                )
                            );
                        }
                    }
                    break;
    
                case 'settlement':
                    $payment->status = 'approved';
                    $payment->note = 'Payment settled';
                    if ($payment->type_payment == 'form') {
                        $form->is_paid_registration = $payment->created_at;
                        $user->notify(
                            new Candidate(
                                'Pembayaran',
                                'Selamat, pembayaran pendaftaran Anda telah diterima. Silahkan lengkapi data diri Anda untuk melanjutkan proses pendaftaran.'
                            )
                        );
                    }
                    break;
    
                case 'pending':
                    $payment->status = 'pending';
                    $payment->note = 'Payment pending';
                    break;
    
                case 'deny':
                case 'expire':
                case 'cancel':
                    $payment->status = 'rejected';
                    $payment->note = 'Payment rejected';
                    if ($payment->type_payment == 'form') {
                        $user->notify(
                            new Candidate(
                                'Pembayaran',
                                'Maaf, pembayaran pendaftaran Anda ditolak. Silahkan upload ulang bukti pembayaran.'
                            )
                        );
                        $form->is_paid_registration = null;
                    }
                    break;
    
                default:
                    throw new \Exception('Unknown transaction status: ' . $transactionStatus);
            }
    
            $payment->save();
            if ($form) {
                $form->save();
            }
    
            return response()->json(['message' => 'Callback processed successfully'], 200);
        } catch (\Exception $e) {
            Log::error('Midtrans Callback Error: ' . $e->getMessage(), ['exception' => $e]);
    
            return response()->json(['error' => 'Callback processing failed: ' . $e->getMessage()], 400);
        }
    }
}
