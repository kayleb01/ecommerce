<?php

namespace App\Http\Controllers;

use App\Models\Tracking;
use Illuminate\Http\Request;

class TrackingController extends Controller
{

    public function index($order)
    {
        $tracking = Tracking::with('product', 'order', 'user')->where('order_number', $order)->first();
        if (!($tracking)) {
           return response()->json(['message' => 'Sorry, we could not find tracking record with that order number'], 404);
        }else {
            return response()->json($tracking);
        }
    }
    public function update(Request $request)
    {
        $this->validate($request, [
            'points'      => 'required',
            'destination' => 'sometimes',
            'status'      => 'sometimes',
            'order_id'    => 'required'
        ]);
        $tracking = Tracking::where('order_number', $request->order_number)->first();
        if (!($tracking)) {
           return response()->json(['message' => 'Sorry, we could not find tracking record with that order number'], 404);
        }

        $point = [];
        if (isset($request->points) && !empty($tracking['points']) ) {
            $point = json_decode($tracking['points'], true);
        }
        $ex = explode(',', $request->points);
        $point[] = $ex;
        //Update the tracking record
       $update = $tracking->fill(['points' => $point], $request->only('destination', 'status'))->save();
       if ($update) {
           return response()->json(['message' => 'updated successfully'], 200);
       }else{
            return response()->json(['message' => 'an error was encountered'], 500);

       }
    }
}
