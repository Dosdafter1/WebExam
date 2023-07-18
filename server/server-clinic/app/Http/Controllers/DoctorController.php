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
        $this->middleware('auth:api');
        $this->middleware('doctor')->except('getDoctors');
    }

    public function confirmCard(Request $request, $id){
        $card = Card::find($id);
        $card->completed=true;
        $card->save();
        return response()->json(['msg'=>'Card completed']);
    }

    public function getRating(){
        $docId=auth()->user()->id;
        $rating = DoctorRating::where('Doctor_id',"{$docId}")->selectRaw('AVG(Rate) as rating')->get()->first()->rating;
        return response()->json(['rating'=>$rating]);
    }

    public function getCardsByDoctorId(Request $request){
        $docId = auth()->user()->id;
        $cards = Card::where('Doctor_id',$docId)->get();
        return response()->json(['cards'=>$cards]);
    }

    public function getDoctors(){
        $doctors = User::where('role',3)->get();
        $spec = DoctorSpeciality::get();
        return response()->json(['doctors'=>$doctors,'spec'=>$spec]);
    }
   
}
