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
                $cartdata = Cart::where('id',$cart)->firstOrFail();
                $prd = Product::where('id',$cartdata->productid)->firstOrFail();
                $data->productid = $prd->id;
                $data->productname = $prd->name;
                $data->photopath = $prd->photopath1;
                $data->color = $prd->color;
                $data->size = $prd->size;
                $data->quantity = $prd->quantity;
                $data->status = $cartdata->status;
                $data->reason = $d->cancel_reason;
                $dat[] = $data;
            }
            $dd[] = $dat;
        }
        return response()->json([
            'data' => $dd,
        ], 200);
    }
}
