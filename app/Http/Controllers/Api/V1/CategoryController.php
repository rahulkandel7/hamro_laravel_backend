<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return response()->json([
            'data' => $categories,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $data = $request->all();
        if ($request->has('photopath')) {
            $fname = time();
            $fexe = $request->file('photopath')->extension();
            $fpath = "$fname.$fexe";

            $request->file('photopath')->storeAs('public/category', $fpath);

            $data['photopath'] = 'category/' . $fpath;
        }


        $category = Category::create($data);

        return response()->json([
            'message' => 'Category Added Successfully',
            'data' => $category,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        $category = Category::find($id);

        if ($request->has('photopath')) {
            $fname = time();
            $fexe = $request->file('photopath')->extension();
            $fpath = "$fname.$fexe";

            $request->file('photopath')->storeAs('public/category', $fpath);

            if($category->photopath)
            {
                Storage::delete('public/'.$category->photopath);
            }

            $data['photopath'] = 'category/' . $fpath;
        }


        $category->update($request->all());

        return response()->json([
            'message' => 'Category Updated Successfully',
            'data' => $category,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json([
            'message' => 'Category Deleted Successfully'
        ], 200);
    }
}
