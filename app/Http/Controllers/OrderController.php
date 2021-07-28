<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_orders = Order::with('product')->where('user_id', auth()->id())->get();
        if (!empty($user_orders) || count($user_orders) <= 0) {
            return response()->json($user_orders);
        }else {
            return response()->json(['message' => 'Error fetching user orders'], 500);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cart = Cart::where('user_id', 1)->get();
        if (count($cart) <= 0) {
            return response()->json(['message' => 'Cart is empty'], 404);
        }
        $products = Product::with('shop')->select('id', 'total_stock', 'shop_id')
            ->whereIn('id', $cart->pluck('product_id'))
            ->get()->toArray();
        $order_number = str_pad($products[0]['id'] + 1, 12, "0", STR_PAD_LEFT) * time();

        for($i = 0; $i < count($cart); $i++) {
            if(!isset($products[$i]['id']) || $products[$i]['total_stock'] < $cart[$i]->quantity){
                 return response()->json(['message' => 'product '. $cart[$i]->product->title .' is not available'], 500);
            }
            try {
              DB::transaction(function () use($cart, $i, $order_number){
                $orders = Order::create([
                    'user_id' => 1,
                    'quantity' => $cart[$i]->quantity,
                    'total' => $cart[$i]->quantity * $cart[$i]->price,
                    'price' => $cart[$i]->price,
                    'txn_ref' => request('txn_ref'),
                    'order_number' => $order_number,
                    'payment_status' => 'paid'
                ]);

                $orders->product()->attach([
                    $cart[$i]->product_id,
                    $orders->id
                ]);

                //decrement the product total stock and increment the sold stock by the cart quantity
                    $product = Product::find($cart[$i]->product_id);
                    $product->decrement('total_stock', $cart[$i]->quantity);
                    $product->increment('sold_stock', $cart[$i]->quantity);
            });
            } catch (\Exception $ex) {
                return response()->json(['message' => 'An error occured, please try again or contact the admin'], 500);
            }

        }
        //delete the entire user cart
        $del = $cart->each->delete();
        if ($del) {
            $order = Order::where('user_id', 1)->get();
            return response()->json(['message' => 'order created', 'order' => $order], 200);
        }else {
            return response()->json(['message' => 'An error occured, please try again or contact the admin'], 500);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
