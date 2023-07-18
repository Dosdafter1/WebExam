<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\ResponseToAdmin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware('admin');
    }

    public function addCard(Request $request){
        $card = Card::create([
            'Client_id'=>$request->input('clientId'),
            'Doctor_id'=>$request->input('doctorId'),
            'Symptoms'=>$request->input('symptoms'),
            'Visit_date'=>$request->input('date'),
            'Visit_time'=>$request->input('time'),
        ]);
        return response()->json(['msg'=>'card added']);
    }

    public function updateCard(Request $request){
        $card = Card::find($request->input('cardId'));
        $card->fill([
            'Client_id'=>$request->input('clientId'),
            'Doctor_id'=>$request->input('doctorId'),
            'Symptoms'=>$request->input('symptoms'),
            'Visit_date'=>$request->input('date'),
            'Visit_time'=>$request->input('time'),
        ]);
    }
    
    public function destroyCard(Request $request){
        $card = Card::find($request->input('cardId'));
        $card->delete();
        return response()->json(['msg'=>'Card deleted']);
    }

    public function getCards(){
        $cards = Card::get();
        return response()->json(['cards'=>$cards]);
    }

    public function getCard($id){
        $card = Card::find($id);
        return response()->json(['card'=>$card]);
    }


    public function confirmResponse(Request $request){
        $res = ResponseToAdmin::find($request->input('responseId'));
        $res->completed=true;
        $res->save();
        return response()->json(['msg'=>'Response completed']);
    }

    public function getResponses()
    {
        $res=ResponseToAdmin::get();
        return response()->json(['responses'=>$res]);
    }

    public function getNotCompletedResponse()
    {
        $res=ResponseToAdmin::where('completed',false)->get();
        return response()->json(['responses'=>$res]);
    }

}
