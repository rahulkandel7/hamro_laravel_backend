<?php

namespace App\Http\Controllers\API\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\WishlistRequest;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Wishlist::where('user_id', auth()->user()->id)->get();
        return response()->json([
            'data' => $data,
            'status' => true,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WishlistRequest $request)
    {
        $data = $request->all();
        $data['user_id'] = auth()->user()->id;
        $already = Wishlist::where('user_id', auth()->user()->id)->where('product_id', $request->product_id)->first();
        if ($already) {
            return response()->json([
                'message' => 'Already added to wishlist',
                'status' => true,
            ], 422);
        } else {
            Wishlist::create($data);
            return response()->json([
                'message' => 'Product Added to Wishlist Successfully',
                'status' => true,
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function show(Wishlist $wishlist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function update(WishlistRequest $request, Wishlist $wishlist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wishlist $wishlist)
    {
        $wishlist->delete();
        return response()->json([
            'message' => 'Product Removed from Wishlist Successfully',
            'status' => true,
        ], 200);
    }
}
