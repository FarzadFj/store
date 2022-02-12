<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Sub_Category;
use Illuminate\Support\Facades\Validator;


class CategoryController extends Controller
{
    public function create_category(Request $request)
    {
        $data = [];
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'item' => 'required|max:15',
            'item_name' => 'required|max:100',
            'parents_id' => 'nullable|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->first(), 422);
        }

        if($data['item'] == 'category')
        {
            $data2 = [];
            $data2['category_name'] = $data['item_name'];

            $category = Category::create($data2);

            return response()->json([
                'Category' => $category,
                'massage' => 'Category Added Successfully'
            ]);
        }

        if($data['item'] == 'sub_category')
        {
            $data2 = [];
            $data2['sub_category_name'] = $data['item_name'];
            $data2['parents_id'] = $data['parents_id'];

            $sub_category = Sub_Category::create($data2);

            return response()->json([
                'Category' => $sub_category,
                'massage' => 'Sub Category Added Successfully'
            ]);
        }
    }
}
