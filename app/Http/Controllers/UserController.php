<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //create a user
//        var_dump($request->all());
//        die();
        $data = $request->all();
        $data["password"] = Hash::make($data["password"]);
        $data["auth_key"] = md5($data["tin"].$data["fio"]);
        return User::create($data);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        try {
            $user = User::find($id);
            $a = $user->companies;
            return $user;

        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    function login(Request $request){
        try {
            $tin = request()->only(['tin']);
            if (User::find(["tin"=>$tin])){
                $credentials = request()->only(['tin', 'password']);
                $token = auth()->attempt($credentials);

                return [
                    "token"=>$token,
                    "user"=>auth()->user()
                ];
            }
            else{
                return User::create($request->all());
            }
        }
        catch (\Exception $exception){
            return $exception->getMessage();
        }

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
}
