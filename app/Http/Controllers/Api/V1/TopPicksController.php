<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class TopPicksController extends Controller
{
    public function toppicks(){
        $data = Product::where('deleted','0')->where('available','1')->get();
        foreach($data as $d){
            $d->brandname = $d->brand->name;
        }
        return response()->json([
            'data' => $data,
        ], 200);
        
    }
}
