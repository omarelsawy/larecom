<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Helper extends Controller
{
    public function priceWithTax(Request $request){
        echo handle_checkout($request->taxid , $request->price);
    }

    public function countbasket(){
        echo count_basket();
    }

    public function quantity(Request $request){
        echo qty($request->productid);
    }

}
