<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;


class UserController extends Controller
{
    //

    public function signup(Request $request){
        $this->validate($request,[
           'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required'
        ]);
        $user=new User([
           'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password)
        ]);

        $user->save();
        return response()->json([
            'message'=>'Successfully created user'
        ],201);
    }
    public function signin(Request $request){
        $this->validate($request,[
            'email'=>'required|email',
            'password'=>'required'
        ]);
        $credentials=$request->only('email','password');
        try{
            if (!$token=JWTAuth::attempt($credentials)){
               return response()->json([
                   'error'=>'Invalid Credentials!'
               ],401);
            }
        }catch (JWTException $exception){
            return response()->json([
                'error'=>'could not create a token!'
            ],500);
        }
        return response()->json([
            'token'=>$token
        ],200);
    }
}
