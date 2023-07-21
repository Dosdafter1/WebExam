<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\DoctorRating;
use App\Models\User;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware('client');
    }
    public function addRate(Request $request){
        $cltId=auth('api')->user()->id;
        $rating=DoctorRating::create(['Client_id'=>$cltId,
                                        'Doctor_id'=>$request->json('docId'),
                                        'Rate'=>$request->json('rate')]);
        return response()->json('Rate added');
    }
    public function updateRate(Request $request){
        $rate=DoctorRating::find($request->json('rateId'));
        $rate->Rate=$request->json('newRate');
        $rate->save();
        return response()->json('Rate edited');
    }

    public function destroyRate(Request $request){
        $rate=DoctorRating::find($request->json('rateId'));
        $rate->delete();
        return response()->json('Rate deleted');
    }

    public function getCardsByClientId(Request $request){
        $cltId = auth('api')->user()->id;
        $cards = Card::where('Client_id',$cltId)->get();
        $res = [
            'cards'=>$cards,
        ];
        return response()->json($res);
    }
   
}
