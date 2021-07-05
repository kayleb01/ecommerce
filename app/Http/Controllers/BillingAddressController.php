<?php

namespace App\Http\Controllers;

use App\Models\BillingAddress;
use App\Models\User;
use App\Http\Requests\BillingAddressRequest;
use App\Http\Resources\BillingAddressResource;
use Illuminate\Support\Facades\Auth;

class BillingAddressController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BillingAddressRequest $request)
    {
        $user = Auth()->user();

        $billingAddress = $user->address()->create(array_merge(['user_id' => Auth()->user()->id],$request->all()));

        if($billingAddress){
            return response([
                'data' => new BillingAddressResource($billingAddress)
            ],201);
        }

        else{
            return response([
                'message' => 'Error Occured!!'
            ]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BillingAddress  $billingAddress
     * @return \Illuminate\Http\Response
     */
    public function show(BillingAddress $billingAddress)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BillingAddress  $billingAddress
     * @return \Illuminate\Http\Response
     */
    public function edit(BillingAddress $billingAddress)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BillingAddress  $billingAddress
     * @return \Illuminate\Http\Response
     */
    public function update(BillingAddressRequest $request, BillingAddress $billingAddress)
    {
        $billing_address = $billingAddress->update($request->all());;

        if($billing_address){
            return response([
                'data' => new BillingAddressResource($billing_address)
            ],201);
        }

        else{
            return response([
                'message' => 'Error Occured!!'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BillingAddress  $billingAddress
     * @return \Illuminate\Http\Response
     */
    public function destroy(BillingAddress $billingAddress)
    {
        //
    }
}
