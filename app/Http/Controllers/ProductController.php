<?php

namespace App\Http\Controllers;

use App\Basket;
use App\Http\Requests\ProductRequest;
use App\Order;
use App\Order_Details;
use App\Product;
use App\Tax;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class ProductController extends Controller
{

    public function __construct()
    {
        //$this->middleware('auth:api')->except('index' , 'show');
    }

    public function welcome(Request $request)
    {
        $allproducts = Product::where('available' , 1)->get();
        return view('welcome' , compact('allproducts'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allproducts = Product::where('available' , 1)->get();
        return view('customer.products' , compact('allproducts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        /*
         * $product = new Product;
         * $product->name = $request->name;
         * $product->save();
         * return response([
           'data' => new ProductResource($product)
        ],201);*/
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id , Request $request)
    {
        if (Auth::user()){
          $basket = Basket::where('product_id' , $id)->where('customer_id' , Auth::user()->id)->delete();
        }else{
          $basket = Basket::where('product_id' , $id)->where('session' , $request->session()->getId())->delete();
        }
        return back();
    }

    public function search(Request $request){
        $search = $request['search_query'];
        $products = DB::table('products')->where('name', $search)->get();
        return view('customer.search' , compact('products'));
    }

    public function basket(Request $request){
        if (Auth::user()){
         $basket = DB::table('baskets')->where('customer_id' , Auth::user()->id)->pluck('product_id');
        }else{
         $basket = DB::table('baskets')->where('session' , $request->session()->getId())->pluck('product_id');
        }
        $products = Product::whereIn('product_id', $basket)->get();
        return view('customer.basket' , compact('products'));
    }

    public function addtocart(Request $request){
        if (Auth::user()){
            $checkbasket = Basket::where('product_id' , $request->id)->where('customer_id' , Auth::user()->id)->count();
        }else{
            if (empty($request->session()->get('session'))){
                $request->session()->put('session' , $request->session()->getId());
            }
            $checkbasket = Basket::where('product_id' , $request->id)->where('session' , $request->session()->getId())->count();
        }
        if ($checkbasket == 0){
            $basket = new Basket;
            if (Auth::user()) {
                $customerid = Auth::user()->id;
                $basket->customer_id = $customerid;
            }
            $basket->product_id = $request->id;
            $basket->session = $request->session()->getId();
            $basket->save();
            //return count_basket();
            return \redirect()->route('basket');
        }
        if (Auth::user()){
            $currentqty = Basket::where('customer_id' , Auth::user()->id)->where('product_id' , $request->id)->pluck('qty')->first();
        }else{
            $currentqty = Basket::where('session' , $request->session()->getId())->where('product_id' , $request->id)->pluck('qty')->first();
        }
        $productqty = Product::where('product_id' , $request->id)->pluck('quantity')->first();
        if ($currentqty < $productqty){
          $plus = $currentqty+1;
          if (Auth::user()){
              Basket::where('product_id' , $request->id)->where('customer_id' , Auth::user()->id) ->update(['qty' => $plus]);
          }else{
              Basket::where('product_id' , $request->id)->where('session' , $request->session()->getId()) ->update(['qty' => $plus]);
          }
        }
        //return count_basket();
        return \redirect()->route('basket');
    }

    public function checkout(Request $request){
        if (!empty($request->session()->get('session'))){
            Basket::where('session', $request->session()->get('session'))->update(['customer_id' => Auth::user()->id]);
        }
        $basket = DB::table('baskets')->where('customer_id' , Auth::user()->id)->pluck('product_id');
        $products = Product::whereIn('product_id', $basket)->get();
        return view('customer.checkout' , compact('products'));
    }

    public function order(Request $request){
          $customerid = Auth::user()->id;
            $basket = Basket::where('customer_id' , Auth::user()->id)->get(['product_id']);
            $order = new Order;
            $order->customer_id = $customerid;
            $order->order_status_id = 1;
            $order->save();
        foreach ($basket as $bas){
            $suppid = sub_id_by_pro_id($bas->product_id);
            $price = Product::where('product_id' , $bas->product_id)->pluck('price')->first();
            $tax_id = Product::where('product_id' , $bas->product_id)->pluck('tax_id')->first();
            $pricewithtax = handle_checkout($tax_id , $price);
            $total = qty($bas->product_id)*$pricewithtax;
            $name = Product::where('product_id' , $bas->product_id)->pluck('name')->first();
            $quantity = qty($bas->product_id);
            Order_Details::create([
               'adress' => $request->adress,
                'price' => $total,
                'name' => $name,
                'quantity' => $quantity,
                'product_id' => $bas->product_id,
                'order_id' => $order->id,
                'supplier_id' => $suppid
            ]);
        }
        return \redirect()->route('listorders');
    }

     public function listorders(){
        if (Auth::user()){
           $orders = Order::where('customer_id' , Auth::user()->id)->get();
           Basket::where('customer_id' , Auth::user()->id)->delete();
           return view('customer.listorders' , compact('orders'));
        }
     }

     public function order_detail($id){
         $orderdetails = Order_Details::where('order_id' , $id)->get();
         return view('customer.order-detail' , compact('orderdetails'));
     }

     public function page_detail($id){
         $product = Product::where('product_id' , $id)->first();
         return view('customer.page-detail' , compact('product'));
     }

     public function incqty(Request $request){
         if (Auth::user()){
             $currentqty = Basket::where('customer_id' , Auth::user()->id)->where('product_id' , $request->id)->pluck('qty')->first();
         }else{
             $currentqty = Basket::where('session' , $request->session()->getId())->where('product_id' , $request->id)->pluck('qty')->first();
         }
         $productqty = Product::where('product_id' , $request->id)->pluck('quantity')->first();
         if ($currentqty < $productqty) {
             $plus = $currentqty + 1;
             if (Auth::user()){
                 Basket::where('product_id', $request->id)->where('customer_id' , Auth::user()->id)->update(['qty' => $plus]);
             }else{
                 Basket::where('product_id', $request->id)->where('session', $request->session()->getId())->update(['qty' => $plus]);
             }
         }
     }

    public function decqty(Request $request){
         if (Auth::user()){
             $currentqty = Basket::where('customer_id' , Auth::user()->id)->where('product_id' , $request->id)->pluck('qty')->first();
         }else{
             $currentqty = Basket::where('session' , $request->session()->getId())->where('product_id' , $request->id)->pluck('qty')->first();
         }
        $plus = $currentqty-1;
         if (Auth::user()){
             Basket::where('product_id' , $request->id)->where('customer_id' , Auth::user()->id) ->update(['qty' => $plus]);
         }else{
             Basket::where('product_id' , $request->id)->where('session' , $request->session()->getId()) ->update(['qty' => $plus]);
         }
    }

}


























