<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\DoctorRating;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware('client');
    }
    public function addRate(Request $request){
        $cltId=auth()->user()->id;
        $rating=DoctorRating::create(['Client_id'=>$cltId,
                                        'Doctor_id'=>$request->input('docId'),
                                        'Rate'=>$request->input('rate')]);
        return response()->json(['msg'=>'Rate added']);
    }
    public function updateRate(Request $request){
        $rate=DoctorRating::find($request->input('rateId'));
        $rate->Rate=$request->input('newRate');
        $rate->save();
        return response()->json(['msg'=>'Rate edited']);
    }

    public function destroyRate(Request $request){
        $rate=DoctorRating::find($request->input('rateId'));
        $rate->delete();
        return response()->json(['msg'=>'Rate deleted']);
    }

    public function getCardsByClientId(Request $request){
        $cltId = auth()->user()->id;
        $cards = Card::where('Client_id',$cltId)->get();
        return response()->json(['cards'=>$cards]);
    }
}
