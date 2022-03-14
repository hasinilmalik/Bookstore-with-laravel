<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TripayCallbackController extends Controller
{
    // Isi dengan private key anda
    protected $privateKey ='Iw7ib-Aoi6B-Ghqh2-Dvhwf-vPwdR';

    public function handle(Request $request)
    {
        $callbackSignature = $request->server('HTTP_X_CALLBACK_SIGNATURE');
        $json = $request->getContent();
        $signature = hash_hmac('sha256', $json, $this->privateKey);

        if ($signature !== (string) $callbackSignature) {
            return 'Invalid signature';
        }

        if ('payment_status' !== (string) $request->server('HTTP_X_CALLBACK_EVENT')) {
            return 'Invalid callback event, no action was taken';
        }

        $data = json_decode($json);
        $uniqueRef = $data->reference;
        $status = strtoupper((string) $data->status);

        /*
        |--------------------------------------------------------------------------
        | Proses callback untuk closed payment
        |--------------------------------------------------------------------------
        */
        // if (1 === (int) $data->is_closed_payment) {
        //     $transaction = Transaction::where('unique_ref', $uniqueRef)->first();

        //     if (! $transaction) {
        //         return 'No Transaction found for this unique ref: ' . $uniqueRef;
        //     }

        //     $transaction->update(['status' => $status]);
        //     return response()->json(['success' => true]);
        // }


        /*
        |--------------------------------------------------------------------------
        | Proses callback untuk open payment
        |--------------------------------------------------------------------------
        */

        $transaction = Transaction::where('reference', $uniqueRef)
            ->where('status', 'UNPAID')
            ->first();


        if (! $transaction) {
            return 'Transaction not found or current status is not UNPAID';
        }

        if ((int) $data->total_amount !== (int) $transaction->total_amount) {
            return 'Invalid amount, Expected: ' . $transaction->total_amount . ' - Received: ' . $data->total_amount;
        }

        switch ($data->status) {
            case 'PAID':
                $transaction->update(['status' => 'PAID']);
                return response()->json(['success' => true]);

            case 'EXPIRED':
                $transaction->update(['status' => 'EXPIRED']);
                return response()->json(['success' => true]);

            case 'FAILED':
                $transaction->update(['status' => 'FAILED']);
                return response()->json(['success' => true]);

            default:
                return response()->json(['error' => 'Unrecognized payment status']);
        }
    }
}