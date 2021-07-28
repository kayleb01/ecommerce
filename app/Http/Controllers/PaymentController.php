<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use KingFlamez\Rave\Facades\Rave as Flutterwave;
use App\Mail\OrderConfirmed;
use Illuminate\Support\Facades\Auth;
use Mail;


class PaymentController extends Controller
{


    public function payment($order_id = '')
    {
        $cart = Cart::where('user_id', auth()->id())->where('order_id', null)->get()->toArray();
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
        $data['txn_ref']  = Flutterwave::generateReference();

        Mail::to(Auth::user())->send(new OrderConfirmed($data['invoice_id']));

        return response()->json(['message' => 'Payment initiated...', 'data' => $data], 200);
    }

    public function finalize(Request $request)
    {
        //
    }
}
