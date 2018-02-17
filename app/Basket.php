<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{
    protected $fillable = [
        'customer_id', 'product_id' , 'qty'
    ];
}
