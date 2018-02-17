<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable,HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email','name', 'password', 'contact_name' , 'mobile1' , 'mobile2' , 'phone' , 'city' , 'lat' , 'lng' , 'api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function city(){
        return $this->belongsTo('App\City');
    }

    public function customers_category(){
        return $this->belongsTo('App\Customers_Category');
    }

    public function order(){
        return $this->hasMany('App\Order');
    }

    public function validation(){
      return [
          'name' => 'required|string',
          'email' => 'required|string|email|unique:users',
          'password' => 'required|string|min:6|confirmed',
          'contact_name' => 'required|string',
          'mobile1' => 'required',
          'mobile2' =>'required',
          'phone' => 'required',
      ];
    }

    public function loginValidation(){
        return [
            'email' => 'required|email',
            'password' => 'required',
        ];
    }

}








