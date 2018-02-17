<?php

use Illuminate\Http\Request;

function handleLang(){
    $current = explode('/' , url()->current());
    if (in_array('en' , $current)){
        $current[3] = 'ar';
        $current = implode('/' , $current);
        echo $current;
    }else{
        $current[3] = 'en';
        $current = implode('/' ,$current);
        echo $current;
    }
}

function handle_checkout($taxid = null , $price){
    $taxid = $taxid;
    $taxvalue = \App\Tax::where('tax_id' , $taxid)->pluck('tax_value')->first();
    $price = $price;
    $pricewithtax = $price + $taxvalue;
    return $pricewithtax;
}

function count_basket(){
    if (\Illuminate\Support\Facades\Auth::user()){
        $count = \App\Basket::where('customer_id' , Auth::user()->id)->count();
    }else{
        $count = \App\Basket::where('session' , request()->session()->getId())->count();
    }
    return $count;
}

function qty($productid){
    if (\Illuminate\Support\Facades\Auth::user()){
        $qty = \App\Basket::where('product_id' , $productid)->where('customer_id' , Auth::user()->id)->pluck('qty')->first();
    }else{
        $qty = \App\Basket::where('product_id' , $productid)->where('session' , request()->session()->getId())->pluck('qty')->first();
    }
    return $qty;
}

function suppliername($id){
   $name = \App\Supplier::where('supplier_id' , $id)->pluck('name')->first();
   return $name;
}

function sub_id_by_pro_id ($proid){
   $supid = \App\Product::where('product_id' , $proid)->pluck('supplier_id')->first();
   return $supid;
}

/*function sub_name_by_order_id($order_id){
   $supid = \App\Order_Details::where('order_id' , $order_id)->pluck('supplier_id')->first();
   $name = \App\Supplier::where('supplier_id' , $supid)->pluck('name')->first();
   return $name;
}*/

function ord_st_by_ord_id($ordid){
   $stid = \App\Order::where('order_id' , $ordid)->pluck('order_status_id')->first();
   $status = \App\Order_Status::where('order_id' , $stid)->pluck('status')->first();
   return $status;
}

function getlat(){
    $id = \Illuminate\Support\Facades\Auth::user()->id;
    $lat = \App\User::where('id' , $id)->pluck('lat')->first();
    return $lat;
}

function getlng(){
    $id = \Illuminate\Support\Facades\Auth::user()->id;
    $lng = \App\User::where('id' , $id)->pluck('lng')->first();
    return $lng;
}

function getTrue(){
    return true;
}

function getFalse(){
    return false;
}

function apiReturn($data , $status = '' , $error = ''){
    $s = $status == ''  ? getTrue() : getFalse();
    return json_encode(['status' => $s ,'data' => $data , 'error' => $error] , JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
}
























































