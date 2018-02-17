<?php

namespace App\Http\Controllers\api;


use App\Http\Controllers\Controller;
use App\Basket;
use App\Order;
use App\Order_Details;
use App\Product;
use App\Tax;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class CustomerApi extends Controller {

    protected $request;
    protected $model;

    public function __construct(User $model , Request $request)
    {
        $this->model = $model;
        $this->request = $request;
        $this->middleware('auth:api')->except('destroy','basket','search','login','decqty','logout' , 'add' ,'addtocart' , 'index');
    }

    public function login(Request $request){
        $v = Validator::make($this->request->all(), $this->model->loginValidation());
        if ($v->fails()) {
            return response(apiReturn('' , 'error' , $v->errors())  , 401 );
        }
        if (! auth()->attempt($this->request->only(['email' , 'password']))) {
            return response(apiReturn('' , 'error' , 'invalid_credentials')  , 401 );
        }
        $user = $this->model->where('email' , $this->request->email)->first();
        $user->api_token = $this->generateToken();
        $user->save();
        Auth::login($user);
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
        $request->session()->regenerate();
        return response(apiReturn($user)  , 200 );
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->flush();
        $request->session()->regenerate();
    }

    public function index($limit = 10 , $offset = 0){
        $data = Product::where('available' , 1)->limit($limit)->offset($offset)->get();
        return response(apiReturn($data)  , 200 );
    }

    public function add(){
        $v = Validator::make($this->request->all(), $this->model->validation());
        if ($v->fails()) {
            return response(apiReturn('' , 'error' , $v->errors())  , 401 );
        }
        $request = $this->request->all();
        $request['name'] = $this->request->name;
        $request['email'] = $this->request->email;
        $request['contact_name'] = $this->request->contact_name;
        $request['mobile1'] = $this->request->mobile1;
        $request['mobile2'] = $this->request->mobile2;
        $request['phone'] = $this->request->phone;
        $request['password'] = bcrypt($this->request->password);
        $request['api_token'] = $this->generateToken();
        $data = $this->model->create($request);
        return response(apiReturn('')  , 200 );
    }

    public function update(Request $request , User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);
        $id = Auth::user()->id;
        $userUpdated = $user->find($id);
        $password = bcrypt($request->password);
        $userUpdated->fill($request->all())->save();
        $userUpdated->fill(['password' => $password])->save();
        return response(apiReturn($userUpdated)  , 200 );
    }

    public function generateToken(){
        return str_random(60);
    }

    public function addtocart(Request $request){
        if (Auth::user()){
            //$request->session()->regenerate();
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
            }else{
                $basket->session = $request->session()->getId();
            }
            $basket->product_id = $request->id;
            $basket->qty = 1;
            $basket->save();
            //return count_basket();
            return response(apiReturn($basket)  , 200 );
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
               $basket = Basket::where('product_id' , $request->id)->where('customer_id' , Auth::user()->id) ->update(['qty' => $plus]);
               $basket = Basket::where('product_id' , $request->id)->where('customer_id' , Auth::user()->id)->get();
            }else{
               $basket = Basket::where('product_id' , $request->id)->where('session' , $request->session()->getId())->update(['qty' => $plus]);
               $basket = Basket::where('product_id' , $request->id)->where('session' , $request->session()->getId())->get();
            }
        }
        //return count_basket();
        return response(apiReturn($basket)  , 200 );
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
            $basket = Basket::where('product_id' , $request->id)->where('customer_id' , Auth::user()->id)->get();
        }else{
            Basket::where('product_id' , $request->id)->where('session' , $request->session()->getId()) ->update(['qty' => $plus]);
            $basket = Basket::where('product_id' , $request->id)->where('session' , $request->session()->getId())->get();
        }
        return response(apiReturn($basket)  , 200 );
    }

    public function search(Request $request){
        $search = $request['search_query'];
        $products = DB::table('products')->where('name', $search)->get();
        return response(apiReturn($products)  , 200 );
    }

    public function basket(Request $request){
        if (Auth::user()){
            $basket = DB::table('baskets')->where('customer_id' , Auth::user()->id)->pluck('product_id');
        }else{
            $basket = DB::table('baskets')->where('session' , $request->session()->getId())->pluck('product_id');
        }
        $products = Product::whereIn('product_id', $basket)->get();
        return response(apiReturn($products)  , 200 );
    }

    public function destroy($id , Request $request)
    {
        if (Auth::user()){
            $basket = Basket::where('product_id' , $id)->where('customer_id' , Auth::user()->id)->delete();
        }else{
            $basket = Basket::where('product_id' , $id)->where('session' , $request->session()->getId())->delete();
        }
        return response(apiReturn('')  , 200 );
    }

    public function checkout(Request $request){
        if (!empty($request->session()->get('session'))){
            Basket::where('session', $request->session()->get('session'))->update(['customer_id' => Auth::user()->id]);
        }
        $basket = DB::table('baskets')->where('customer_id' , Auth::user()->id)->pluck('product_id');
        $products = Product::whereIn('product_id', $basket)->get();
        return response(apiReturn($products)  , 200 );
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
        return response(apiReturn('')  , 200 );
    }

    public function listorders(){
        if (Auth::user()){
            $orders = Order::where('customer_id' , Auth::user()->id)->get();
            Basket::where('customer_id' , Auth::user()->id)->delete();
            return response(apiReturn($orders)  , 200 );
        }
    }

}









