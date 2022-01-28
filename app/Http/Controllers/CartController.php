<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Models\User;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function show_cart(Request $request)
    {
        // $user_phonenumber = $_SESSION['phoneNumber'];

        // $user = User::where('phoneNumber', $user_phonenumber)->first();
        // $user_id = $user['id'];

        $user_id = $request->user()->id;

        $user_cart =  (new Cart())->get()->where('user_id', $user_id);

        return response()->json([
            'user_cart' => $user_cart
        ]);
    }

    public function add_to_cart($id, Request $request)
    {
        $data = [];
        $new_stoke = [];
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'number' => 'numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->first(), 422);
        }

        $product = Product::where('id',$id)->first();
        $product_stoke = $product['stoke'];

        if($data['number'] < $product_stoke)
        {
            $user_id = $request->user()->id;
            $data['user_id'] = $user_id;

            $data['product_id'] = $id;
            $cart = Cart::create($data);

            $new_stoke['stoke'] = $product_stoke - $data['number'];

            Product::where('id',$id)->update($new_stoke);

            return response()->json([
                'data' => $cart,
                'massage' => 'Product added Successfully In The Cart'
            ]);

        }else{

            return response()->json([
                'massage' => 'Inventory Is Not Enough'
            ]);
        }
    }

    public function delete_from_cart($id, Request $request)
    {
        $new_stoke = [];
        $user_id = $request->user()->id;
        $cart = Cart::where('id',$id)->where('user_id',$user_id);

        if($cart->exists())
        {
            $cart = Cart::where('id',$id)->where('user_id',$user_id)->first();
            $number = $cart['number'];
            $product_id = $cart['product_id'];

            $product = Product::where('id',$product_id)->first();
            $stoke = $product['stoke'];

            $new_stoke['stoke'] = $number + $stoke;

            Product::where('id',$product_id)->update($new_stoke);

            $cart->delete();

            return response()->json([
                'message' => 'Cart Deleted Successfully'

            ]);
        }

        return response()->json([
            'message' =>'There Is No Such Case'
        ],404);
    }
}
