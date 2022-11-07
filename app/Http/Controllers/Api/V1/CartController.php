<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartRequest;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function index()
    {
        $carts = Cart::where('ordered', 0)->where('user_id', auth()->user()->id)->get();
        foreach ($carts as $cart) {
            $cart->product;
        }

        return response()->json([
            'data' => $carts,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CartRequest $request)
    {
        $datas = $request->all();
        $cartdata = Cart::where('user_id',auth()->user()->id)->where('product_id',$datas['product_id'])->count();
        if($cartdata>0){
            return response()->json([
                'message' => 'Already Added to Cart',
                'status' => true,
            ], 200);
        }
        $datas['user_id'] = auth()->user()->id;
        $data = Cart::create($datas);

        return response()->json([
            'message' => 'Added to Cart',
            'status' => true,
            'data' => $data,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(CartRequest $request, $id)
    {
        $cart = Cart::find($id);
        $data = $cart->update($request->all());
        return response()->json([
            'message' => 'Cart Updated Successfully',
            'data' => $data,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        $cart->delete();
        return response()->json([
            'message' => 'Item Removed From Cart Successfully',
            'status' => true,
        ], 200);
    }

    public function updateQuantity(Request $request, $id)
    {
        $cart = Cart::find($id);
        $cart->quantity = $request->quantity;
        $cart->save();
        return response()->json([
            'message' => 'Cart Updated Successfully',
            'data' => $cart,
            'status' => true,
        ], 200);
    }

    public function updateOrdered(Request $request, $id)
    {
        $cart = Cart::find($id);

        $cart->ordered = $request->ordered;
        $cart->save();
        return response()->json([
            'message' => 'Cart Updated Successfully',
            'data' => $cart,
            'status' => true,
        ], 200);
    }
}
