<?php

namespace App\Http\Controllers;

use App\Basket;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!empty($request->session()->get('session'))){
            $authbasket = Basket::where('customer_id' , Auth::user()->id)->pluck('product_id');
            $baskets = Basket::where('session', $request->session()->get('session'))->get();
            foreach ($baskets as $basket){
                $proid = $basket->product_id;
                if ($authbasket->contains($proid)){
                    $currqty = Basket::where('customer_id' , Auth::user()->id)->where('product_id' , $proid)->pluck('qty')->first();
                    $totalqty = $basket->qty+$currqty;
                    $productqty = Product::where('product_id' , $proid)->pluck('quantity')->first();
                    if ($totalqty < $productqty){
                        Basket::where('customer_id' , Auth::user()->id)->where('product_id' , $proid)->update(['qty' => $totalqty]);
                    }else{
                        Basket::where('customer_id' , Auth::user()->id)->where('product_id' , $proid)->update(['qty' => $productqty]);
                    }
                    Basket::where('session' , $request->session()->get('session'))->where('product_id' , $proid)->delete();
                }
            }
            Basket::where('session', $request->session()->get('session'))->update(['customer_id' => Auth::user()->id]);
        }
        $allproducts = Product::where('available' , 1)->get();
        return view('welcome' , compact('allproducts'));
    }
}
