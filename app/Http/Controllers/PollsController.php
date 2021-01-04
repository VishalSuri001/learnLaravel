<?php

namespace App\Http\Controllers;

use App\Poll;
use App\Http\Resources\Poll as PollResource;
use App\Http\Resources\PollCollection as PollCollectionResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class PollsController extends Controller
{
    function index(){
        $polls = DB::table('polls')->paginate(2);
        // return response()->json( ( new PollCollectionResource( $polls ) ), 200);
        return response()->json( $polls , 200);
    }

    function getByModal(){
        $polls = Poll::get();
        return response()->json($polls, 200);
    }

    function show($id){
        // $poll = Poll::findOrFail($id);
        $poll = Poll::with('questions')->find($id);
        if( is_null( $poll ) ){
            return response()->json(null, 404);
        }
        // return response()->json($poll, 200);
        // dd( new PollResource( $poll ) );
        return response()->json(new PollResource( $poll ), 200);
    }

    function store(Request $request){
        $rules = [
            'title' => 'required|min:10'
        ];
        $validator = Validator::make($request->all(), $rules);
        if( $validator->fails() ){
            return response()->json($validator->errors(), 400);
        }
        $poll = Poll::create($request->all());
        return response()->json($poll, 201);
    }

    function update(Request $request, Poll $poll){
        $poll->update($request->all());
        return response()->json($poll, 200);
    }

    function delete(Request $request, Poll $poll){
        $poll->delete();
        return response()->json($poll, 204);
    }

    public function errors()
    {
        return response()->json(['msg' => 'Payment is required'], 501);
    }

    public function questions(Request $request, Poll $poll)
    {
        $questions = $poll->questions;
        return response()->json($questions, 200);
    }
}