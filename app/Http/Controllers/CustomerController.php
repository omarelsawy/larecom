<?php

namespace App\Http\Controllers;

use App\Http\Resources\User\UsersCollection;
use App\Http\Resources\User\UsersResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CustomerController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {

        //$user = Auth::user();
        $name = $user->name;
        $email = $user->email;

       return view('customer.profile');
        //return UsersCollection::collection(User::all());

    }

    public function create(){

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
         //return new UsersResource($user);
    }

    public function edit($id , User $user){
        $user = $user->find($id);
        return view('customer.profile' , compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id , User $user)
    {
            $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);
        $userUpdated = $user->find($id);
        $password = bcrypt($request->password);
        $userUpdated->fill($request->all())->save();
        $userUpdated->fill(['password' => $password])->save();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function addlocation(Request $request){
        $lat = $request->lat;
        $lng = $request->lng;
        User::where('id' , Auth::user()->id)->update(['lat' => $lat]);
        User::where('id' , Auth::user()->id)->update(['lng' => $lng]);
        $request->session()->put('location' , 'edited');
        return back();
    }

}






