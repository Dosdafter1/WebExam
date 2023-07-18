<?php

namespace App\Http\Controllers;

use App\Models\ResponseToAdmin;
use Illuminate\Http\Request;

class ResponseToAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function addResponse(Request $request)
    {
        $response = ResponseToAdmin::create([
            'user_id'=>auth()->user()->id,
            'card_id'=>$request->input('cardId'),
            'type'=>$request->input('type'),
            'values'=>$request->input('values'),
        ]);
        return response()->json(['msg'=>'Response send']);
    }
    public function destroyResponse(Request $request)
    {
        $response = ResponseToAdmin::find($request->input('respId'));
        $response->delete();
        return response()->json(['msg'=>'Response destroy']);
    }
   
}
