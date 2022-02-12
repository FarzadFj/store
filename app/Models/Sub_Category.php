<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sub_Category extends Model
{
    use HasFactory;

    protected $table = 'sub_categories';

    protected $fillable = [
        'sub_category_name',
        'parents_id'
    ];
}
