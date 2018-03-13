<?php

namespace App\Http\Controllers;

use App\Quote;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class QuoteController extends Controller
{
    //
    public function postQuote(Request $request){
//        if (!$user=JWTAuth::parseToken()->authenticate()){
//            return response()->json([
//                'message'=>'User not found'
//            ],404);
//        }
        $user=JWTAuth::parseToken()->toUser();
        $quote=new Quote();
        $quote->content=$request->input('content');
        $quote->save();
        return response()->json([
            'quote'=>$quote,
            'user'=>$user
        ],201)->cookie('token',$user,'2');
    }

    public function getQuote(){
        $quotes=Quote::all();
        return response()->json([
            'quotes'=>$quotes
        ],200);
    }

    public function putQuote(Request $request,$id){
        $quote=Quote::find($id);
        if(!$quote){
            return response()->json([
                'message'=>'Document not found'
            ],400);
        }
        $quote->content=$request->input('content');
        $quote->save();
        return response()->json([
            'quote'=>$quote
        ],200);
    }

    public function deleteQuote($id){
        $quote=Quote::find($id);
        $quote->delete();
        return response()->json([
            'message'=>'Quote Deleted'
        ],200);
    }

}
