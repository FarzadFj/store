<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\Product_Category;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    // public function show_products()
    // {
    //     $products = (new Product())->get();

    //     return response()->json([
    //         'products' => $products
    //     ]);
    // }

    public function add_product(Request $request)
    {
        $data = [];
        $data2 = [];
        // $data = $request->all();
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:100',
            'description' => 'required|max:1000',
            'price' => 'required|max:10',
            'img_url' => 'required|image|mimes:jpg,png,jpeg|max:2048',
            'stock' =>'required|max:10',
            'category_id' => 'required|max:2',
            'sub_category_id' => 'required|max:2'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->first(), 422);
        }

        $data['title'] = $request->title;
        $data['description'] = $request->description;
        $data['price'] = $request->price;
        $image = $request->file('img_url');
        $image_extension = $image->guessClientExtension();
        $img_new_name = date("Y/m/d- H-i-s") . "-" . $request->title . "." . $image_extension;
        $image->move(public_path('uploads/products_images'), $img_new_name);
        $data['img_url'] = $img_new_name;
        $data['stock'] = $request->stock;

        // $product_id = Product::insertGetId($data);
        $product = Product::create($data);
        $data2['category_id'] = $request->category_id;
        $data2['sub_category_id'] = $request->sub_category_id;
        $data2['product_id'] = $product['id'];

        Product_Category::create($data2);

        return response()->json([
            'product' => $product,
            'massage' => 'Product Added Successfully'
        ]);
    }

    public function update_product($id, Request $request)
    {
        $data = [];
        // $data = $request->all();
        $validator = Validator::make($request->all(), [
            'title' => 'max:100',
            'description' => 'max:1000',
            'price' => 'max:10',
            'img_url' => 'image|mimes:jpg,png,jpeg|max:2048',
            'stock' =>'max:10',
            'category_id' => 'max:2',
            'sub_category_id' => 'max:2'
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

        empty($request->stock) ? : $data['stock'] = $request->stock;
        empty($request->category_id) ? : $data['category_id'] = $request->category_id;
        empty($request->sub_category_id) ? : $data['sub_category_id'] = $request->sub_category_id;

        return $data;

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

    public function show_products( Request $request)
    {   
        $request->validate([
            'from' => 'date',
            'to' => 'date'
        ]);

        $Products = Product::get();

        if($request->has('category'))
        {
            if($request->has('sub_category'))
            {
                $category_id = $request->category;
                $sub_category_id = $request->sub_category;

                $Products = Product::join('Product_Categories','Products.id','=','Product_Categories.product_id')
                ->select('Products.*')->where('Product_Categories.category_id','=',$category_id)
                ->where('Product_Categories.sub_category_id','=',$sub_category_id)->get();
            }

            $category_id = $request->category;

            $Products = Product::join('Product_Categories','Products.id','=','Product_Categories.product_id')
            ->select('Products.*')->where('Product_Categories.category_id','=',$category_id)->get();
        }

        if($request->has('from') && $request->has('to'))
        {
            $Products->where('created_at', '>=' , $request->input('from'))->where('created_at', '<=' , $request->input('to'))->get();
        }

        if($request->has('stock'))
        {
                $Products = $Products->where('stock', '>' , '0');
        }

        if(empty($Products))
        {
            return response()->json([
               'message' => 'No Products Found'
            ], 404);
        }

        return response()->json([
            'products' => $Products
        ]);
        
    }
}
