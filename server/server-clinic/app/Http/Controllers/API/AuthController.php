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
        $this->middleware('auth:api')->except('register','signup');
    }

    public function register(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string',
            'phone' => 'required|string',
            'role' => 'required|min:1|max:3'
        ]);
        $user=User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'phone' =>  $validatedData['phone'],
            'role'=>$validatedData['role']
        ]);
        $token=auth('api')->attempt($request->only(['email','password']));
        return $this->responseWithToken($token);
    }

    public function docRegister(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string',
            'phone' => 'required|string',
            'speciality'=>'required|string'
        ]);
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
        return response()->json(['msg'=>'Doctor added']);
    }

    public function updateDoctor(Request $request){
        $doc = User::find(auth()->user()->id);
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string',
            'speciality'=>'required|string'
        ]);
        
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
        return response()->json(['msg'=>'Update completed']);
    }

    public function signup(Request $request){
        $credentials = $request->only(['email','password']);
        if(!$token=auth('api')->attempt($credentials)){
            return response()->json(['msg'=>'Unauthorized'],401);
        }
        return $this->responseWithToken($token);
    }

    public function changePassword(Request $request)
    {
        $credentials = $request->only(['email','newPassword']);
        $user = User::find(auth()->user()->id);
        if($user->email==$credentials['email'])
        {
            $user->password=Hash::make($credentials['newPassword']);
            $user->save();
            return response()->json(['msg'=>'Password changed']);
        }
        return response()->json(['msg'=>'Incorrect email']);
    }
    public function updateUser(Request $request){
        $user = User::find(auth()->user()->id);
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string',
            'role' => 'required|min:1|max:3'
        ]);
        
        $user->fill([
            'name' => $validatedData['name'],
            'phone' => $validatedData['phone'],
            'role'=> $validatedData['role'],
        ]);
        $user->save();
        return response()->json(['msg'=>'Changed success']);
    }

    public function user(){
        return response()->json(auth()->user());
    }

    public function logout(){
        auth('api')->logout();
        return response()->json(['msg'=>'LogOut success']);
    }

    public function refresh(){
        return $this->responseWithToken(auth('api')->refresh());
    }

    protected function responseWithToken($token){
            return response()->json([
                'access_token' => $token,
                'type'=>'Bearer',
                'expires_in'=> config('jwt.ttl')*60
            ]);
    }
}