<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\DoctorRating;
use App\Models\DoctorSpeciality;
use App\Models\User;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('test');
        //$this->middleware('doctor')->except('getDoctors','test');
    }

    public function confirmCard(Request $request, $id){
        $card = Card::find($id);
        $card->completed=true;
        $card->save();
        return response()->json('Card completed');
    }

    public function getRating(){
        $docId=auth()->user()->id;
        $rating = DoctorRating::where('Doctor_id',"{$docId}")->selectRaw('AVG(Rate) as rating')->get()->first()->rating;
        return response()->json($rating);
    }

    public function getCardsByDoctorId(Request $request){
        $docId = auth()->user()->id;
        $cards = Card::where('Doctor_id',$docId)->get();
        return response()->json($cards);
    }

    public function getDoctors(){
        $doctors = User::where('role',3)->get();
        $spec = DoctorSpeciality::get();
        $res=[$doctors,$spec];
        return response()->json($res);
    }
    public function test(){
        return response()->json('ok');
    }
   
}
