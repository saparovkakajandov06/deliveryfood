<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        if (empty(session('cart'))) {
            return redirect()->back();
        }

        return view('orders.index');
    }

    public function store(StoreOrderRequest $request)
    {
        $data = $request->validated();

        \DB::transaction(function () use ($data) {
            $order = Order::create([
                'name' => $data['name'],
                'surname' => $data['surname'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'address' => $data['address'] . ' ' . $data['label'] . ' ' . $data['entrance'] . ' ' . $data['floor'],
                'total_price' => $data['total_price'],
                'status' => $data['status'],

                'cart_number' => $data['cart_number'],
                'cart_deadline' => $data['cart_deadline'],
                'cvc_code' => $data['cvc_code'],
            ]);

            foreach (session('cart') as $key => $item) {
                $order->products()->attach($key, ['quantity' => $item['quantity']]);
            }
        });

        session()->forget('cart');

        session()->flash('success', 'Продукт успешно добавлен');

        return redirect()->route('main-page');
    }
}
