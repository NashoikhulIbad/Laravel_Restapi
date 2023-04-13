<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Customer;

class OrderController extends Controller
{
    public function index(Order $order)
    {   
        $orders = Order::all();

        $response = [];
    
        foreach ($orders as $order) {
            $customerJoin = Customer::where('id', $order->customer_id)->first();
    
            $responseData = [
                "order_id" => $order->id,
                "name" => $customerJoin->name,
                "product_name" => $order->product_name,
                "total_amount" => $order->total_amount,
            ];
    
            array_push($response, $responseData);
        }
    
        return $response;
    }

    public function store(Request $request)
    {
        $order = Order::create([
            'customer_id' => $request->customer_id,
            'product_name' => $request->product_name,
            'total_amount' => $request->total_amount,
        ]);
        return response()->json([
            'data' => $order
        ]);
    }

    public function show(Order $order)
    {
        $customerJoin = Customer::where('id', $order->customer_id)->first();

        $response = [
            "order_id"=>$order->id,
            "name" => $customerJoin->name,
            "product_name"=>$order->product_name,
            "total_amount"=>$order->total_amount,

        ];


        return $response;
    }

    public function update(Request $request, Order $order)
    {
        $order->customer_id = $request->customer_id;
        $order->product_name = $request->product_name;
        $order->total_amount = $request->total_amount;
        $order->save();

        return response()->json([
            'data' => $order
        ]);
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json([
            'message' => 'order deleted'
        ], 204);
    }
}
