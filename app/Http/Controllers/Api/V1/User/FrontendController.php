<?php

namespace App\Http\Controllers\API\v1\User;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Rating;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    public function fetchCategory()
    {
        $categories = Category::all();
        foreach ($categories as $category) {
            $category->sub = $category->subCategory->count();
        }
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
        $category = Category::find($id);
        $products = Product::where('category_id', $id)->get();
        foreach ($products as $product) {
            $product->category_name = $product->category->category_name;
        }
        return response()->json([
            'data' => $products,
            'category' => $category,
        ], 200);
    }

    public function fetchBySubCategory($id)
    {
        $sub = SubCategory::find($id);
        $products = Product::where('sub_category_id', $id)->get();
        foreach ($products as $product) {
            $product->sub_category_name = $product->subCategory->subcategory_name;
        }
        return response()->json([
            'data' => $products,
            'sub' => $sub,
        ], 200);
    }

    public function fetchProduct($id)
    {
        $product = Product::find($id);
        $ratings = Rating::where('product_id', $id)->get();

        $product->category_name = $product->category->category_name;
        $product->brand_name = $product->brand->brand_name;

        return response()->json([
            'data' => $product,
            'ratings' => $ratings,
        ], 200);
    }

    public function loadAllProduct()
    {
        $products = Product::all();
        foreach ($products as $product) {
            $product->category_name = $product->category->category_name;
        }
        return response()->json([
            'data' => $products
        ], 200);
    }

    public function fetchBrand()
    {
        $brands = Brand::all();
        return response()->json([
            'data' => $brands
        ], 200);
    }
}
