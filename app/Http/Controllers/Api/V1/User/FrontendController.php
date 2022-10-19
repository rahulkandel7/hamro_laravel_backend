<?php

namespace App\Http\Controllers\API\v1\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function fetchCategory()
    {
        $categories = Category::all();
        return response()->json([
            'categories' => $categories
        ], 200);
    }

    public function fetchSubCategory()
    {
        $subCategories = SubCategory::all();
        return response()->json([
            'data' => $subCategories
        ], 200);
    }

    public function fetchByCategory($id)
    {
        $products = Product::where('category_id', $id)->get();
        foreach ($products as $product) {
            $product->category_name = $product->category->category_name;
        }
        return response()->json([
            'data' => $products
        ], 200);
    }

    public function fetchProduct($id)
    {
        $product = Product::find($id);
        $product->category_name = $product->category->category_name;
        $product->brand_name = $product->brand->brand_name;
        return response()->json([
            'data' => $product
        ], 200);
    }
}
