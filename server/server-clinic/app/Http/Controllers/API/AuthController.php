<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DoctorSpeciality;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
//Role Admin-1 Client-2 Doctor-3
class AuthController extends Controller
{ 
    public function __construct()
    {
        $this->middleware('cors');
        $this->middleware('auth:api')->except('register','login');
    }

    public function register(Request $request){
        if(User::where('email',"{$request->json('email')}")->get()->first()!==null)
        {
            return response()->json('Email exist', 401);
        }
        $validatedData =[
            'name' => $request->json('name'),
            'email' => $request->json('email'),
            'password' => $request->json('password'),
            'phone' => $request->json('phone'),
            'role' => $request->json('role')
        ];
        $user=User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'phone' =>  $validatedData['phone'],
            'role'=>$validatedData['role']
        ]);
        $credentials = [
            'email' => $request->json('email'),
            'password' => $request->json('password')
        ];
        $token=auth('api')->attempt($credentials);
        $res =  $this->responseWithToken($token);
        return response()->json($res);
    }

    public function docRegister(Request $request){
        if(User::where('email',"{$request->json('email')}")->get()->first()!==null)
        {
            return response()->json('Email exist', 401);
        }
        $validatedData =[
            'name' => $request->json('name'),
            'email' => $request->json('email'),
            'password' => $request->json('password'),
            'phone' => $request->json('phone'),
            'speciality' => $request->json('speciality')
        ];
        $user=User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'phone' =>  $validatedData['phone'],
            'role'=>3
        ]);
        $sepciality = DoctorSpeciality::create([
            'doctor_id'=>$user->id,
            'speciality'=> $validatedData['speciality'],
        ]);
        return response()->json('Doctor added');
    }

    public function updateDoctor(Request $request){
        $doc = User::find(auth()->user()->id);
        $validatedData = [
            'name' => $request->json('name'),
            'phone' => $request->json('phone'),
            'speciality'=>$request->json('speciality')
        ];
        
        $doc->fill([
            'name' => $validatedData['name'],
            'phone' =>  $validatedData['phone'],
            'role'=>3
        ]);
        $doc->save();
        $sepciality= DoctorSpeciality::where('doctor_id',$doc->id)->get()->first();
        if($sepciality==null){
            $sepciality = DoctorSpeciality::create([
                'doctor_id'=>$doc->id,
                'speciality'=> $validatedData['speciality'],
            ]);
        }
        else{
            $sepciality->fill([
                'doctor_id'=>$doc->id,
                'speciality'=> $validatedData['speciality'],
            ]);
        }
        return response()->json('Update completed');
    }

    public function login(Request $request){
        $credentials = [
            'email' => $request->json('email'),
            'password' => $request->json('password')
        ];
        if(!$token=auth('api')->attempt($credentials)){
            return response()->json('Unauthorized',401);
        }
        $res =  $this->responseWithToken($token);
        return response()->json($res);
    }

    public function changePassword(Request $request)
    {
        $credentials = [
            'email'=>$request->json('email'),
            'newPassword'=>$request->json('password')
        ];
        $user = User::find(auth('api')->user()->id);
        if($user->email==$credentials['email'])
        {
            $user->password=Hash::make($credentials['newPassword']);
            $user->save();
            return response()->json('Password changed');
        }
        return response()->json('Incorrect email',401);
    }

    public function updateUser(Request $request){
        $user = User::find(auth('api')->user()->id);
        
        $validatedData = [
            'name' => $request->json('name'),
            'phone' => $request->json('phone'),
        ];
        $user->fill([
            'name' => $validatedData['name'],
            'phone' => $validatedData['phone'],
        ]);
        $user->save();
        return response()->json('Updated!');
    }

    public function user(){
        $res = (object)[
            'user'=>auth('api')->user()
        ];
        return response()->json($res);
    }

    public function logout(){
        auth('api')->logout();
        return response()->json('LogOut success');
    }

    public function refresh(){
        return $this->responseWithToken(auth('api')->refresh());
    }

    protected function responseWithToken($token){
        $res = (object)[
            'access_token' => $token,
            'type'=>'Bearer',
            'expires_in'=> config('jwt.ttl')*60
        ];
        
        return $res;
    }
}
