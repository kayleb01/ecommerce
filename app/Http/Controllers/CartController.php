<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\CartRequest;
use App\Http\Resources\CartResource;
use Symfony\Component\HttpFoundation\Response;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CartRequest $request)
    {

        $conditions = ['user_id' => $request->user_id, 'product_id' => $request->product_id];
        //Check if we have the product in cart if true, increment add the quantity
        $cart_items = Cart::where($conditions)->first();

        if (!empty($cart_items)) {
            $cart_items->quantity += $request->quantity;
            $cart_items->total += $request->total;
            $available_stock = $this->check_stock($request->product_id, $request->quantity);

            if (!$available_stock) {
              return response()->json(['message' => "Quantity of product not available or out of stock"], 500);

            }else {

                $cart_items->save();
                return response()->json(['message' => "Product added to cart", 'cart' => new CartResource($cart_items)], 201);
            }

        }else {

            $available_stock = $this->check_stock($request->product_id, $request->quantity);
            if (!$available_stock) {
                return response()->json(['message' => "Quantity of product not available or out of stock"], 500);
              }
            $cart = Cart::create([
                'product_id' => $request->product_id,
                'order_id' => null,
                'quantity' => $request->quantity,
                'user_id' => $request->user_id,
                'price' => $request->price,
                'total' => $request->total
            ]);
            if ($cart) {
                # return created
                return response()->json(['message' => "Product added to cart", 'cart' => new CartResource($cart)], 201);

            }else {
                # return an error
                return response()->json(['message' => "An error was encountered, please try again"], 500);
            }
        }
    }


    public function check_stock($product, $quantity):bool
    {
        $product = Product::findOrFail($product);
        $available_stock = $product->total_stock - $product->sold_stock;
        if($available_stock < $quantity || $available_stock == 0) {
            return false;
        }else{
            return true;
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
        $cart = Cart::findOrFail($id);
        $cart->delete();
        return response(null, Response::HTTP_NO_CONTENT);

    }
}
