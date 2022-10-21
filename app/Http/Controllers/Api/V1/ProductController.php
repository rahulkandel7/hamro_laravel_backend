<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Product::all();
        return response()->json([
        'data' => $data,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
       $data = $request->all();

       if ($request->has('photopath1')) {
        $fname = time();
        $fexe = $request->file('photopath1')->extension();
        $fpath = "$fname.'1'.$fexe";

        $request->file('photopath1')->storeAs('public/products/', $fpath);

        $data['photopath1'] = 'products/' . $fpath;
        }

        if ($request->has('photopath2')) 
        {
            $fname = time();
            $fexe = $request->file('photopath2')->extension();
            $fpath = "$fname.'2'.$fexe";
    
            $request->file('photopath2')->storeAs('public/products/', $fpath);
    
            $data['photopath2'] = 'products/' . $fpath;
        }

        if ($request->has('photopath3')) 
        {
            $fname = time();
            $fexe = $request->file('photopath3')->extension();
            $fpath = "$fname.'3'.$fexe";
    
            $request->file('photopath3')->storeAs('public/products/', $fpath);
    
            $data['photopath3'] = 'products/' . $fpath;
        }

        $product = Product::create($data);

        return response()->json([
            'message' => 'Product Added Successfully',
            'data' => $product,
            ], 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        $product = Product::find($id);
        $data = $request->all();

       if ($request->has('photopath1')) {
        $fname = time();
        $fexe = $request->file('photopath1')->extension();
        $fpath = "$fname.'1'.$fexe";

        $request->file('photopath1')->storeAs('public/products/', $fpath);

        if($product->photopath1)
            {
                Storage::delete('public/'.$product->photopath1);
            }

        $data['photopath1'] = 'products/' . $fpath;
        }

        if ($request->has('photopath2')) 
        {
            $fname = time();
            $fexe = $request->file('photopath2')->extension();
            $fpath = "$fname.'2'.$fexe";
    
            $request->file('photopath2')->storeAs('public/products/', $fpath);
            if($product->photopath2)
            {
                Storage::delete('public/'.$product->photopath2);
            }
    
            $data['photopath2'] = 'products/' . $fpath;
        }

        if ($request->has('photopath3')) 
        {
            $fname = time();
            $fexe = $request->file('photopath3')->extension();
            $fpath = "$fname.'3'.$fexe";
    
            $request->file('photopath3')->storeAs('public/products/', $fpath);
            if($product->photopath3)
            {
                Storage::delete('public/'.$product->photopath3);
            }
    
            $data['photopath3'] = 'products/' . $fpath;
        }

        $product->update($data);

        return response()->json([
            'message' => 'Product Updated Successfully',
            'data' => $product,
            ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        if($product->photopath1)
        {
            Storage::delete('public/'.$product->photopath1);
        }
        if($product->photopath2)
        {
            Storage::delete('public/'.$product->photopath2);
        }
        if($product->photopath3)
        {
            Storage::delete('public/'.$product->photopath3);
        }
        
        return response()->json([
            'message' => 'Product Deleted Successfully',
            ], 200);

    }
}