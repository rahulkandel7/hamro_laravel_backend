<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\Shipping;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function store(OrderRequest $request)
    {
        $datas = $request->all();
        $datas['user_id'] = auth()->user()->id;
        $data = Order::create($datas);

        return response()->json([
            'message' => 'Order Created',
            'status' => true,
            'data' => $data,
        ], 200);
    }

    public function index($status){
    	$datas = Order::where('status',$status)->orderBy('created_at','desc')->get();
        $datas->total_amount = 0;
        foreach($datas as $data){
            $shipping = Shipping::find($data->shipping_id);
            $data->shipping_area = $shipping->area_name;
            $cartid = explode(',',$data->cart_id);
            $dat = array();
            $data->total_amount = 0;
            foreach($cartid as $cart){
                $cartdata = Cart::where('id',$cart)->firstOrFail();
                if($cartdata->status != 'Cancelled')
                $data->total_amount = $data->total_amount + $cartdata->price;
            }
            $datas->total_amount += $data->total_amount;
            
        }
    	return response()->json([
            'message' => $status,
            'status' => true,
            'data' => $datas,
        ], 200);
    }

    public function order_cart($orderid)
    {
        $order = Order::where('id',$orderid)->first();
        
            $cartid = explode(',',$order->cart_id);
            $carts = array();
            foreach($cartid as $cart){
                $data = (object)[];
                $cartdata = Cart::where('id',$cart)->firstOrFail();
                $prd = Product::where('id',$cartdata->productid)->firstOrFail();
                $data->id = $cartdata->id;
                $data->productid = $prd->id;
                $data->productname = $prd->name;

                $data->rate = $cartdata->price;
                
                $data->quantity = $cartdata->quantity;

                $data->totalprice = $data->rate*$data->quantity;

                $data->photopath = $prd->photopath1;
                $data->status = $cartdata->status;
                $carts[] = $data;
            }
            return response()->json([
                'status' => true,
                'data' => $carts,
            ], 200);
    }


    public function update_order($orderid,$status)
    {
        $order = Order::findOrFail($orderid);
        $cartid = explode(',',$order->cart_id);
        foreach($cartid as $carts)
        {
            $cart = Cart::find($carts);
            if($cart->status != 'Cancelled')
            {
                $cart->status = $status;
                $cart->save();
                if($cart->status == 'Pending')
                {
                    $product = Product::find($cart->productid);
                    $product->stock++;
                    $product->save();
                }
                else if($cart->status == 'Processing')
                {
                    $product = Product::find($cart->productid);
                    $product->stock--;
                    $product->save();
                }
            }
        }
        $order->status = $status;
        $order->save();

    //     $description = "Your Order is changed to ".$status;
    //     $title = "Order Notification";
    //     $deviceToken = Users::where('id',$order->user_id)->first();

    //     if($deviceToken)
    //     {
    //         //change notification for mobile
    //     $key = "AAAAQptqg0g:APA91bFsk5ZNjIm9AsP5jGCQ4nICab6OqTQPiQAu2l43Vyyhr-GEEaq-NuZwyEsnT58mCKxvjzG8O_WWe6Wc3NKDgQ0v1wp8NzCuoqHCSiHUeNgW-Pdqyf51A6yBfAHBGdpodCrCpJDE";

    //     $mydata = [
    //        'to' => $deviceToken->deviceToken,
    //        'notification' => [
    //            'body' => $description,
    //            'title' => $title,
    //        ],

    //     ];

    //     $jsondata = json_encode($mydata);

    //     $header = [
    //        'Authorization: key='.$key,
    //        'Content-Type: application/json',
    //     ];

    //     $ch = curl_init();
     
    //    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    //    curl_setopt($ch, CURLOPT_POST, true);
    //    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    //    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsondata);

    //    curl_exec($ch);
    //     }


        // return back()->with('swalsuccess','Order is now '.$status);
        return response()->json([
            'message' => 'Order is now '.$status,
            'status' => true,
        ], 200);
    }


    public function update_cancelled_order(Request $request)
    {
        $order = Order::findOrFail($request->orderid);
        $cartid = explode(',',$order->cart_id);
        foreach($cartid as $carts)
        {
            $cart = Cart::find($carts);
                $cart->status = $request->status;
                $cart->save();
                // $product = Product::find($cart->productid);
                // $product->stock--;
        }
        $order->status = $request->status;
        $order->cancel_reason = $request->reason;
        $order->save();
    //     $description = "Your Order is changed to ".$request->status;
    //     $title = "Order Notification";
    //     $deviceToken = Users::where('id',$order->user_id)->first();

    //     if($deviceToken)
    //     {
    //         //change notification for mobile
    //     $key = "AAAAQptqg0g:APA91bFsk5ZNjIm9AsP5jGCQ4nICab6OqTQPiQAu2l43Vyyhr-GEEaq-NuZwyEsnT58mCKxvjzG8O_WWe6Wc3NKDgQ0v1wp8NzCuoqHCSiHUeNgW-Pdqyf51A6yBfAHBGdpodCrCpJDE";

    //     $mydata = [
    //        'to' => $deviceToken->deviceToken,
    //        'notification' => [
    //            'body' => $description,
    //            'title' => $title,
    //        ],

    //     ];

    //     $jsondata = json_encode($mydata);

    //     $header = [
    //        'Authorization: key='.$key,
    //        'Content-Type: application/json',
    //     ];

    //     $ch = curl_init();
     
    //    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    //    curl_setopt($ch, CURLOPT_POST, true);
    //    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    //    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsondata);

    //    curl_exec($ch);
    //     }
        // return back()->with('swalsuccess','Order is now Cancelled');
        return response()->json([
            'message' => 'Order is now Cancelled',
            'status' => true,
        ], 200);
    }


    public function update_cart($cartid,$status){
        $cart = Cart::find($cartid);
        $cart->status = $status;
        $cart->save();
        return response()->json([
            'message' => 'Cart Status Updated',
            'status' => true,
        ], 200);
    }


    public function delete($orderid)
    {
        $order = Order::findOrFail($orderid);
        $cartid = explode(',',$order->cart_id);
        foreach($cartid as $carts)
        {
            $cart = Cart::find($carts);
            $cart->delete();
        }
        $order->delete();
        return response()->json([
            'message' => 'Order Deleted',
            'status' => true,
        ], 200);
    }

    
}