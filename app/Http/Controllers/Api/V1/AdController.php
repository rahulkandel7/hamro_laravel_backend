<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdRequest;
use App\Models\Ad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banner = Ad::all();

        return response()->json([
            'data' => $banner
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdRequest $request)
    {
        $data = $request->all();

        if ($request->has('photopath')) {
            $fname = time();
            $fexe = $request->file('photopath')->extension();
            $fpath = "$fname.$fexe";

            $request->file('photopath')->move(public_path() . '/public/ads/', $fpath);

            $data['photopath'] = 'ads/' . $fpath;
        }

        $ad = Ad::create($data);

        return response()->json([
            'message' => 'Ad Created Successfully',
            'status' => true,
            'data' => $ad,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function show(Ad $ad)
    {
        return response()->json([
            'data' => $ad,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function update(AdRequest $request, $id)
    {
        $ad = Ad::find($id);
        $data = $request->all();

        if ($request->has('photopath')) {
            $fname = time();
            $fexe = $request->file('photopath')->extension();
            $fpath = "$fname.$fexe";

            $request->file('photopath')->move(public_path() . '/public/ads/', $fpath);

            if ($ad->photopath) {
                File::delete('public/' . $ad->photopath);
            }

            $data['photopath'] = 'ads/' . $fpath;
        }


        $ad->update($data);

        return response()->json([
            'message' => 'Ad Updated Successfully',
            'data' => $ad,
            'status' => true,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ad $ad)
    {
        File::delete($ad->photopath);
        if ($ad->photopath) {
            File::delete('public/' . $ad->photopath);
        }
        $ad->delete();

        return response()->json([
            'message' => 'Ad Deleted Successfully',
            'status' => true,
        ], 200);
    }
}
