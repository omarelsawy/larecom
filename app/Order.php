<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = "order_list";
    protected $fillable = [
        'customer_id' , 'order_status_id'
    ];
}
