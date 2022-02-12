<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;
use App\Models\Order_Product;
use App\Models\Product;
use App\Models\Cart;


class OrderController extends Controller
{
    public function add_to_order(Request $request)
    {
        $data = [];
        $data2 = [];
        $data['user_id'] = $request->user()->id;
        // $user_id = $request->user()->id;

        $order = Order::create($data);

        $data2['order_id'] = $order['id'];

        $carts = Cart::where('user_id',$data['user_id'])->get();

        return response()->json([
            'products' => $carts
        ]);

        // while($cart = mysqli_fetch_assoc($carts))
        // {
        //     $carts = [];
        //     $carts[] = $cart;
        // }

        // foreach( $carts as $cart)
        // {
        //     $data2['product_id'] = $cart['product_id'];
        //     $data2['number'] = $cart['number'];

        //     // $product = Product::where('id',$data2['product_id']);
        //     // $inventory = $product['number'];

        //     // if( $inventory >= $data2['number'])
        //     // {
        //     Order_Product::create($data2);

        //     // $new_inventory = $inventory - $data2['number'];
        //     // $data3 = [];
        //     // $data3['number'] = $new_inventory;

        //     // Product::where('id',$data2['product_id'])->update($data3);
        //     // }

        //     Cart::where('id',$cart['id'])->delete();

        // }

    }

    public function show_orders()
    {
        $orders = Order::join('Order_Product', 'id', '=', 'order_id')
        ->join('Product', 'product_id', '=', 'id')
        ->select('Order.id', 'Order.user_id', 'Order.created_at', 'Order_Product.product_id', 'Product.title', 'Product.price', 'Order_product.number')
        ->get();

        
        return response()->json([
            'Orders' => $orders
        ]);
    }
}
