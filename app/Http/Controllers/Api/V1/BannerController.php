<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BannerRequest;
use App\Models\Banner;
use Illuminate\Support\Facades\File;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banner = Banner::all();

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
    public function store(BannerRequest $request)
    {
        $data = $request->all();

        if ($request->has('photopath')) {
            $fname = time();
            $fexe = $request->file('photopath')->extension();
            $fpath = "$fname.'1'.$fexe";

            $request->file('photopath')->move(public_path() . '/public/banners/', $fpath);

            $data['photopath'] = 'banners/' . $fpath;
        }

        $banner = Banner::create($data);

        return response()->json([
            'message' => 'Banner Created Successfully',
            'status' => true,
            'data' => $banner,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function show(Banner $banner)
    {
        return response()->json([
            'data' => $banner,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function update(BannerRequest $request, Banner $banner)
    {
        $data = $request->all();

        if ($request->has('photopath')) {
            $fname = time();
            $fexe = $request->file('photopath')->extension();
            $fpath = "$fname.'1'.$fexe";

            $request->file('photopath')->move(public_path() . '/public/banners/', $fpath);

            if ($banner->photopath) {
                File::delete('public/' . $banner->photopath);
            }

            $data['photopath'] = 'banners/' . $fpath;
        }

        $banner->update($data);

        return response()->json([
            'message' => 'Banner Updated Successfully',
            'status' => true,
            'data' => $banner,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banner $banner)
    {
        if ($banner->photopath) {
            File::delete('public/' . $banner->photopath);
        }
        $banner->delete();

        return response()->json([
            'message' => 'Banner Deleted Successfully',
            'status' => true,
        ], 200);
    }
}
