<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customers_Category extends Model
{
    public function user()
    {
        return $this->hasMany('App\User');
    }
}
