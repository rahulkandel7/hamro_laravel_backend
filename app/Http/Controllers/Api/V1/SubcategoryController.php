<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubCategogoryRequest;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = SubCategory::all();
        foreach ($data as $d) {
            $d->category_name = $d->category->category_name;
        }
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
    public function store(SubCategogoryRequest $request)
    {
        $data = SubCategory::create($request->all());

        return response()->json([
            'message' => 'Sub Category Added Successfully',
            'data' => $data,
            'status' => true,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subCategory = SubCategory::find($id);
        return response()->json([
            'data' => $subCategory,
            'status' => true,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function update(SubCategogoryRequest $request, $id)
    {
        $data = SubCategory::find($id);
        $data->update($request->all());

        return response()->json([
            'message' => 'Sub Category Updated Successfully',
            'data' => $data,
            'status' => true,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subCategory = SubCategory::find($id);
        $subCategory->delete();
        return response()->json([
            'message' => 'Sub Category Deleted Successfully',
            'status' => true,
        ], 200);
    }
}
