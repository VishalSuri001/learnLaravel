<?php

namespace App\Http\Controllers;

use App\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $bookings = DB::table('bookings')->get();
        // Booking::withTrashed()->get()->dd();
        $bookings = Booking::with(['room.roomType', 'users:name'])->paginate(1);
        // ($bookings);
        return view('booking.index', [ 'bookings' => $bookings ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $users = DB::table('users')->get()->pluck('name', 'id')->prepend('Select User');
        $rooms = DB::table('rooms')->get()->pluck('number', 'id');        
        return view('booking.create')
                ->with('users', $users)
                ->with('rooms', $rooms)
                ->with('booking', (new Booking()))
                ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // dd($request->all());
        // $id = DB::table('bookings')->insertGetId([
        //     'room_id' => $request->input('room_id'),
        //     'start' => $request->input('start'),
        //     'end' => $request->input('end'),
        //     'is_reservation' => $request->input('is_reservation', false),
        //     'is_paid' => $request->input('is_paid', false),
        //     'notes' => $request->input('notes'),
        // ]);
        // DB::table('bookings_users')->insert([
        //     'booking_id' => $id,
        //     'user_id' => $request->input('user_id'),
        // ]);
        // return redirect()->action( 'BookingController@index' );
        // dd($request->input());
        $booking = Booking::create( $request->input() );
        
        // DB::table('bookings_users')->insert([
        //     'booking_id' => $booking->id,
        //     'user_id' => $request->input('user_id'),
        // ]);
        // Relation        
        $booking->users()->attach( $request->input('user_id') );

        // $user = $booking->users()->create( [ 'name' => 'test' ] );
        return redirect()->action( 'BookingController@index' );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {
        //
        return view('booking.show', [ 'booking' => $booking ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        //
        $users = DB::table('users')->get()->pluck('name', 'id')->prepend('Select User');
        $rooms = DB::table('rooms')->get()->pluck('number', 'id');
        $bookingUser = DB::table('bookings_users')->where( 'booking_id', $booking->id )->first();
        // dd( $bookingUser, $booking->all() );
        return view('booking.edit')
                ->with('users', $users)
                ->with('rooms', $rooms)
                ->with('booking', $booking)
                ->with('bookingUser', $bookingUser);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Booking $booking)
    {
        // (new \App\Jobs\ProcessBookingJob($booking))->handle(); 
        (\App\Jobs\ProcessBookingJob::dispatch($booking));
        $validatedData = $request->validate([
            'start' => 'required|date',
            'end' => 'required|date',
            'room_id' => 'required|exists:rooms,id',
            'user_id' => 'required|exists:users,id',
            'is_paid' => 'nullable',
            'notes' => 'present',
            'is_reservation' => 'required',
        ]);
        //
        // dd($request->all());
        // $id = DB::table('bookings')->where('id', $booking->id)->update([
        //     'room_id' => $request->input('room_id'),
        //     'start' => $request->input('start'),
        //     'end' => $request->input('end'),
        //     'is_reservation' => $request->input('is_reservation', false),
        //     'is_paid' => $request->input('is_paid', false),
        //     'notes' => $request->input('notes'),
        // ]);

        // $booking->fill( $request->all() )->save();
        $booking->fill( $validatedData )->save();
        // DB::table('bookings_users')
        // ->where('booking_id', $booking->id)
        // ->update([
        //     'user_id' => $request->input('user_id'),
        // ]);
        // Relation
        $booking->users()->sync( [ $validatedData['user_id'] ] );
        return redirect()->action( 'BookingController@index' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        // DB::table('bookings_users')->where( 'booking_id',$booking->id )->delete();
        // DB::table('bookings')->where( 'id',$booking->id )->delete();
        $booking->users()->detach();
        $booking->delete();
        return redirect()->action( 'BookingController@index' );
    }
}
