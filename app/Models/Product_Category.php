<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_Category extends Model
{
    use HasFactory;

    protected $table = 'product_categories';

    protected $fillable = [
        'category_id',
        'sub_category_id',
        'product_id'
    ];
}
