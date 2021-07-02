<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Product_review;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
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
    public function store(Request $request)
    {
        //
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
        $review  = Product_review::where('id', $id)->first();
        if ($review->user_id != $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $update = $review->fill($request->all())->update();
        if ($update) {
           return response()->json(['message' => 'review updated successfully'], 200);
        }
        else {
            return response()->json(['message' => 'An error was encountered'], 400);
        }


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
