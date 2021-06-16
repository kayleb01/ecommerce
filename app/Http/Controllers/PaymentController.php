<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class PaymentController extends Controller
{


    public function payment()
    {
        $cart = Cart::where('user_id', 1)->where('order_id', null)->get()->toArray();
        $data = [];

        $data['items'] = array_map(function($item) use($cart){
            $name =  Product::where('id', $item['product_id'])->pluck('title');
            return [
                'name' => $name,
                'price' => $item['price'],
                'quantity' => $item['quantity']
            ];

        }, $cart);

        $data['invoice_id'] = 'ORD-'.strtoupper(uniqid());
        $data['invoice_description'] = "Order #{$data['invoice_id']} Invoice";

        $total = 0;

        foreach($data['items'] as $item){
            $total += $item['price'] * $item['quantity'];
        }
        $data['total'] = $total;

        $data['txn_ref'] = paystack()->genTranxRef();

        return response()->json(['message' => 'Payment initiated...', 'data' => $data], 200);

    }
}
