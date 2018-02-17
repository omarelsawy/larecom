<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/register' , 'api\CustomerApi@add');
Route::post('/login' , 'api\CustomerApi@login');
Route::post('/addtocart' ,'api\CustomerApi@addtocart');
Route::get('/decreaseqty/{id}' ,'api\CustomerApi@decqty');
Route::get('products/{limit?}/{offset?}', 'api\CustomerApi@index');
Route::post('user/update', 'api\CustomerApi@update');
Route::get('/search/{search_query}', 'api\CustomerApi@search');
Route::get('/basket', 'api\CustomerApi@basket');
Route::get('/checkout' , 'api\CustomerApi@checkout');
Route::get('/pricewithtax/{taxid}/{price}' , 'api\Helper@priceWithTax');
Route::get('/countbasket' , 'api\Helper@countbasket');
Route::get('/quantity/{productid}' , 'api\Helper@quantity');
Route::get('/order/{adress}' , 'api\CustomerApi@order');
Route::get('/listorders' , 'api\CustomerApi@listorders');
Route::get('/products/basket/delete/{id}' , 'api\CustomerApi@destroy');
Route::post('/logout' , 'api\CustomerApi@logout');
//Route::apiResource('/users' , 'CustomerController');
//Route::apiResource('/products' , 'ProductController');




