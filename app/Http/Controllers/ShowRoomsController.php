<?php

namespace App\Http\Controllers;

use App\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShowRoomsController extends Controller
{
    /**
     * 
     */
    public function __invoke(Request $request, $roomType = null)
    {
        // return response('A list of rooms', 200);
        // $rooms = DB::table('rooms')->get();
        if( $roomType ){            
            $rooms = Room::ByType( $roomType )->get();
        } else {
            $rooms = Room::get();
            if( $request->query('id') ){
                $rooms = $rooms->where( 'room_type_id', $request->query('id'));
            }
        }
        // return response()->json($rooms);
        return view('rooms.index', [ 'rooms' => $rooms]);
    }
}
