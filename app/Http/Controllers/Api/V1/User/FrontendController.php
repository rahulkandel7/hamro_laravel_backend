<?php

namespace App\Http\Controllers\API\v1\User;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Product;
use App\Models\Rating;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{

    public function fetchBanner()
    {
        $banner = Banner::all();

        return response()->json([
            'data' => $banner,
        ], 200);
    }
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
        $ratings = Rating::all();

        foreach ($products as $product) {
            $product->category_name = $product->category->category_name;
            $product->rating_number = $ratings->where('product_id', $product->id)->count();
            $product->rating = $ratings->where('product_id', $product->id)->average('rating');
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
        $ratings = Rating::all();

        foreach ($products as $product) {
            $product->sub_category_name = $product->subCategory->subcategory_name;

            $product->rating_number = $ratings->where('product_id', $product->id)->count();
            $product->rating = $ratings->where('product_id', $product->id)->average('rating');
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
        $product->rating = Rating::where('product_id', $product->id)->average('rating');


        $comments = Comment::where('product_id', $id)->get();
        foreach ($comments as $comment) {
            $comment->user_name = $comment->user->name;
        }

        $product->category_name = $product->category->category_name;
        $product->brand_name = $product->brand->brand_name;

        return response()->json([
            'data' => $product,
            'ratings' => $ratings,
            'comments' => $comments,
        ], 200);
    }

    public function loadAllProduct()
    {
        $products = Product::all();
        $ratings = Rating::all();
        foreach ($products as $product) {
            $product->category_name = $product->category->category_name;
            $product->rating_number = $ratings->where('product_id', $product->id)->count();
            $product->rating = $ratings->where('product_id', $product->id)->average('rating');
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
