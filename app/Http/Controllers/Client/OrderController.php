<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('hpp')
            ->where('client_id', auth()->id())
            ->latest()
            ->get();

        return view('client.orders', compact('orders'));
    }

    public function setDeal($id)
    {
        $order = Order::where('client_id', auth()->id())
            ->findOrFail($id);

        $order->update([
            'status' => 'deal'
        ]);

        return back()->with('success', 'Order siap diproses HPP');
    }
}
