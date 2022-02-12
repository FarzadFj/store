<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Order_Product extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'order_products';

    protected $fillable = [
        'order_id',
        'product_id',
        'number'
    ];
}
