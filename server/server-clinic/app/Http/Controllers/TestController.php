<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('testC','login');
    }
    //Цей метод працює і коректно все повертає
    public function testC(Request $request){
            $info=$request->json('info');
            return response()->json($this->getResponse($info));
    }
    public function getResponse($info){
            $res=['INfo'=>$info,'data'=>1111];
            return $res;
    }
    public function login(){
        return 11;  
    }
   //Раніше цей метод називався login - він виконує всю ту ж логіку, що і метод login в AuthController
   //але він вибивав помилку, тому я трохи його змінив і(і поміняв на GET в api), але він всеодно видає помилку
    public function testL(){
        /*
        $credentials= [];
        $credentials['email']= $request->json('email');
        $credentials['password']= $request->json('password');
        
        if(!$token=auth('api')->attempt($credentials)){
            return response()->json('Unauthorized',401);
        }
        $res =  $this->responseWithToken($token);*/
        return response()->json('ok');
    }
    public function responseWithToken($token){
        $res = (object)[
            'access_token' => $token,
            'type'=>'Bearer',
            'user'=>auth()->user(),
            'expires_in'=> config('jwt.ttl')*60
        ];
        
        return $res;
    }
}
