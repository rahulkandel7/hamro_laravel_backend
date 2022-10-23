<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\RatingRequest;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ratings = Rating::all();

        return response()->json([
            'data' => $ratings,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $datas = $request->all();
        $datas['user_id'] = auth()->user()->id;

        $rating = Rating::where('user_id', $datas['user_id'])->where('product_id', $datas['product_id'])->first();
        if ($rating) {
            $data = $rating->update($datas);
        } else {
            $data = $rating = Rating::create($datas);
        }


        return response()->json([
            'message' => 'The Product Has Been Rated',
            'status' => true,
            'data' => $data,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function show(Rating $rating)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function update(RatingRequest $request, $id)
    {
        $rating = Rating::find($id);
        $data = $rating->update($request->all());
        return response()->json([
            'message' => 'Rating Updated Successfully',
            'data' => $data,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rating $rating)
    {
        $rating->delete();
        return response()->json([
            'message' => 'Rating Removed Successfully',
            'status' => true,
        ], 200);
    }

    public function findRating($id)
    {
        $rating = Rating::where('product_id', $id)->where('user_id', auth()->user()->id)->get();

        return response()->json([
            'data' => $rating,
        ], 200);
    }
}
