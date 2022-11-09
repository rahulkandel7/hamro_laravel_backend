<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function show_order(){
        $order = Order::where('user_id',auth()->user()->id)->get();
        $dd = array();
        foreach($order as $d){
            $cartid = explode(',',$d->cart_id);
            $dat = array();
            foreach($cartid as $cart){
                $data = (object)[];
                $cartdata = Cart::find($cart);
                $data->cart = $cartdata;
                $data->cart->productname = $cartdata->product->name;
                $data->cart->photopath = $cartdata->product->photopath1;
                $data->cart->productid = $cartdata->product->id;
                
                $dat[] = $data;
            }
            $dd[] = $dat;
        }
        return response()->json([
            'data' => $dd,
        ], 200);
    }
}
