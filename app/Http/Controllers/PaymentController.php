<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::all();

        $response = $payments->map(function ($payment) {
            return [
                "order_id" => $payment->order_id,
                "amount" => $payment->amount,
            ];
        });
    
        return $response;
    }

    public function store(Request $request)
    {
        $payment = Payment::create([
            'order_id' => $request->order_id,
            'amount' => $request->amount,
        ]);
        return response()->json([
            'data' => $payment
        ]);
    }

    public function show(Payment $payment)
    {
        return response()->json([
            "order_id"=>$payment->order_id,
            "amount"=>$payment->amount,
        ]);
    }

    public function update(Request $request, Payment $payment)
    {
        $payment->order_id = $request->order_id;
        $payment->amount = $request->amount;
        $payment->save();

        return response()->json([
            'data' => $payment
        ]);

    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return response()->json([
            'message' => 'order deleted'
        ], 204);    
    }
}
