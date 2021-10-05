<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product_photo extends Model
{
    protected $fillable = ['photo', 'is_cover','product_id', 'created_at', 'updated_at'
    ];
}
