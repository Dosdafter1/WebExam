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
        $date = Card::where('Visit_date', $request->json('date'))->get()->first();
        $time = Card::where('Visit_time', $request->json('time'))->get()->first();
        if($date!==null && $time!==null)
        {
            return response()->json('Time is busy',401);
        }
        $card = Card::create([
            'Client_id'=>$request->json('clientId'),
            'Doctor_id'=>$request->json('doctorId'),
            'Symptoms'=>$request->json('symptoms'),
            'Visit_date'=>$request->json('date'),
            'Visit_time'=>$request->json('time'),
        ]);
        return response()->json('Card added');
    }

    public function updateCard(Request $request){
        $date = Card::where('Visit_date', $request->json('date'))->get()->first();
        $time = Card::where('Visit_time', $request->json('time'))->get()->first();
        var_dump($time);
        if($date!=null && $time!=null)
        {
            return response()->json('Time is busy',401);
        }
        $card = Card::find($request->json('cardId'));
        $card->fill([
            'Client_id'=>$request->json('clientId'),
            'Doctor_id'=>$request->json('doctorId'),
            'Symptoms'=>$request->json('symptoms'),
            'Visit_date'=>$request->json('date'),
            'Visit_time'=>$request->json('time'),
        ]);
        $card->save();
        return response()->json('Card edited');
    }
    
    public function destroyCard(Request $request,$id){
        $card = Card::find($id);
        $card->delete();
        return response()->json('Card deleted');
    }

    public function getCards(){
        $cards = Card::get();
        return response()->json($cards);
    }

    public function getCard($id){
        $card = Card::find($id);
        return response()->json($card);
    }


    public function confirmResponse(Request $request){
        $res = ResponseToAdmin::find($request->json('responseId'));
        $res->completed=true;
        $res->save();
        return response()->json('Response completed');
    }

    public function getResponses()
    {
        $responses=ResponseToAdmin::get();
        $res = (object)['responses'=>$responses];
        return response()->json($res);
    }

    public function getNotCompletedResponse()
    {
        $responses=ResponseToAdmin::where('completed',false)->get();
        $res = (object)['responses'=>$responses];
        return response()->json($res);
    }

}
