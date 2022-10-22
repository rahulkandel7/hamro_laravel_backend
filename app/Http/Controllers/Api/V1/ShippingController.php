<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShippingRequest;
use App\Models\Shipping;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shipping = Shipping::all();
        return response()->json([
            'data' => $shipping,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShippingRequest $request)
    {
        $datas = $request->all();
        $data = Shipping::create($datas);

        return response()->json([
            'message' => 'Shipping Added Successfully',
            'status' => true,
            'data' => $data,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shipping  $shipping
     * @return \Illuminate\Http\Response
     */
    public function show(Shipping $shipping)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shipping  $shipping
     * @return \Illuminate\Http\Response
     */
    public function update(ShippingRequest $request, $id)
    {
        $shipping = Shipping::find($id);
        $data = $shipping->update($request->all());
        return response()->json([
            'message' => 'Shipping Updated Successfully',
            'data' => $data,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shipping  $shipping
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shipping $shipping)
    {
        $shipping->delete();
        return response()->json([
            'message' => 'Shipping Address Deleted Successfully',
            'status' => true,
        ], 200);
    }
}
