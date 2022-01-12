<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use App\Models\Product;

class ProductController extends Controller
{
    public function show_products()
    {
        $products = (new Product())->get();

        return response()->json([
            'products' => new ProductResource($products)
        ]);
    }

    public function add_product()
    {
        $data = [];
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:100',
            'description' => 'required|max:1000',
            'price' => 'required|max:10',
            'img_url' => 'required|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->first(), 422);
        }
    }
}
