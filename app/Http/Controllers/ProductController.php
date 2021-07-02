<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Product;
use App\Jobs\CreateProduct;
use Illuminate\Http\Request;
use App\Models\Product_review;
use App\Http\Resources\ProductResource;
use App\Http\Requests\StoreProductRequest;

class ProductController extends Controller
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
    public function store(StoreProductRequest $request)
    {
        $data = $request->only(['title', 'description', 'status', 'price', 'total_stock', 'sold_stock', 'category_id', 'vendor_id', 'user_id', 'product_image']);
        $product = Product::create($data);

        //store media files if attached
        if ($request->hasFile('product_image')) {
            Media::find($request->product_image)->each->update([
                'model_id' => $product->id,
                'model_type' => Product::class
            ]);
        }
        if ($product) {
            return response()->json(['message' => 'product created successfully', 'product' => new ProductResource($product)], 201);

        }else {
           return response()->json(['message' => 'An error was encountered', 500]);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function review(Request $request)
    {

        $request->validate([
            'rating' => 'required|numeric|min:1|max:5'
        ]);

        $product = Product::find($request->product_id);
        // dd(!($product->isReviewed($product->id)));
        if(!($product->isReviewed($product->id))){

            $review = new Product_review();
            $review->user_id = $request->user_id;
            $review->rating = $request->rating;
            $review->review = $request->review;
            $product->product_review()->save($review);
        }else {
            return response()->json(['error' => 'seems like you have reviewed this product already'], 400);

        }

        // $product = Product::where('id', $request->product_id)->firstOrFail();
        // $review = Product_review::create([
        //     'product_id' => $request->product_id,
        //     'user_id' => $request->user()->id,
        //     'rating' => $request->rating,
        //     'review' => $request->review
        // ]);

        if ($review) {
           return response()->json(['message' => 'Thank you for your feedback'], 201);
        }else{
            return response()->json(['message' => 'An error was encountered, please try again'], 500);
        }
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
