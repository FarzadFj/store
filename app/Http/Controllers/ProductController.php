<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function show_products()
    {
        $products = (new Product())->get();

        return response()->json([
            'products' => $products
        ]);
    }

    public function add_product(Request $request)
    {
        $data = [];
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:100',
            'description' => 'required|max:1000',
            'price' => 'required|max:10',
            'img_url' => 'required|image|mimes:jpg,png,jpeg|max:2048',
            'stoke' =>'required|max:10'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->first(), 422);
        }

        $image = $request->file('img_url');
        $image_extension = $image->guessClientExtension();
        $img_new_name = date("Y/m/d- H-i-s") . "-" . $request->title . "." . $image_extension;
        $image->move(public_path('uploads/products_images'), $img_new_name);
        $data['img_url'] = $img_new_name;

        $product = Product::create($data);

        return response()->json([
            'product' => new ProductResource($product),
            'massage' => 'Product Added Successfully'
        ]);
    }

    public function update_product($id, Request $request)
    {
        $data = [];
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'title' => 'max:100',
            'description' => 'max:1000',
            'price' => 'max:10',
            'img_url' => 'image|mimes:jpg,png,jpeg|max:2048',
            'stoke' =>'max:10'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->first(), 422);
        }
        empty($request->title) ? : $data['title'] = $request->title;
        empty($request->description) ? : $data['description'] = $request->description;
        empty($request->price) ? : $data['price'] = $request->price;
        if(!empty($request->img_url))
        {
            $image = $request->file('img_url');
            $image_extension = $image->guessClientExtension();
            $img_new_name = date("Y/m/d- H-i-s").".".rand(1111111111,9999999999). ".".$image_extension;
            $image->move(public_path('uploads/products_images'), $img_new_name);
            $data['img_url'] = $img_new_name;
        }
        empty($request->stoke) ? : $data['stoke'] = $request->stoke;

        Product::where('id',$id)->update($data);

        return response()->json([
            'message' => 'Product Information Updated Successfully'
        ]);

    }

    public function delete_product($id)
    {
        $product = Product::where('id',$id);

        If($product->exists())
        {
            $product->delete();

            return response()->json([
                'message' => 'Product Deleted Successfully'
            ]);
        }

        return response()->json([
            'code' => 2,
            'message' =>'Product Not Found'
        ],404);
    }

    public function filter_product($data, Request $request)
    {
        $date = 'date';
        $stoke = 'stoke';
        // $category = 'category';

        if($data == $date)
        {
            $products = Product::orderBy('created_at','asc')->get();

            return response()->json([
                'products' => $products
            ]);
        }

        if($data == $stoke)
        {
            $products = Product::orderBy('stoke','desc')->get();

            return response()->json([
                'products' => $products
            ]);
        }

        // if($data == $category)
        // {

        // }

        return response()->json([
            'message' => 'There Is No Such Filter'
        ]);        
    }
}
