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
            'user_id'=>auth('api')->user()->id,
            'card_id'=>$request->json('cardId'),
            'type'=>$request->json('type'),
            'values'=>$request->json('values'),
        ]);
        return response()->json('Response send');
    }
    public function destroyResponse(Request $request, $id)
    {
        $response = ResponseToAdmin::find($id);
        $response->delete();
        return response()->json('Response destroy');
    }
   
}
