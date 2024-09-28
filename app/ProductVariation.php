<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ProductVariation extends Model
{
    protected $fillable = [
        'product_id', 
        'name', 
        'price',
        // any other fields you want to be mass assignable
    ];
}
