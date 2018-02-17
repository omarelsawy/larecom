<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order_Details extends Model
{
    protected $table = "order_details";
    protected $fillable = [
        'price', 'name','barcode' , 'order_status_id' , 'adress' , 'quantity' , 'order_id' , 'product_id' , 'supplier_id'
    ];
}
