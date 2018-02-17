<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//lang
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function()
{
    // ADD ALL LOCALIZED ROUTES INSIDE THIS GROUP
    Route::get('/', 'ProductController@welcome');
    Auth::routes();
    Route::get('/home', 'HomeController@index')->name('home');
    Route::Resource('customers' , 'CustomerController');
    //Route::Resource('products' , 'ProductController');
    Route::get('/products' , 'ProductController@index');
    Route::get('/search' , 'ProductController@search');
    //Route::get('/basket' , 'ProductController@basket');
    //Route::get('/addcartajax' , 'ProductController@addtocart');
    Route::get('/products/basket' , 'ProductController@basket')->name('basket');
    Route::get('/products/checkout' , 'ProductController@checkout')->middleware('auth');
    Route::get('/products/basket/delete/{id}' , 'ProductController@destroy');
    Route::get('/products/listorders' , 'ProductController@listorders')->name('listorders')->middleware('auth');
    Route::get('/order-details/{id}' , 'ProductController@order_detail');
    Route::get('/products/page-detail/{id}' , 'ProductController@page_detail');
    Route::get('/map' , function (){
        return view('map');
    })->middleware('auth');
});
Route::post('/location' , 'CustomerController@addlocation')->middleware('auth');
Route::post('/products/order' , 'ProductController@order');
Route::get('/increaseqty' , 'ProductController@incqty');
Route::get('/decreaseqty' , 'ProductController@decqty');
Route::post('/addtocart' ,'ProductController@addtocart');
//Route::post('/logout' , 'LoginController@logout');
//Route::post('/login' , 'LoginController@login');







































