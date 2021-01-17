<?php

namespace App\Http\Controllers;

use App\RoomType;
use Illuminate\Http\Request;
use App\Traits\StoreImageTrait;

class RoomTypeController extends Controller
{
    use StoreImageTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $roomTypes = RoomType::paginate();
        return view('roomTypes.index', [ 'roomTypes' => $roomTypes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
 
        // $formInput = $request->all();
 
        // $formInput['image'] = $this->verifyAndStoreImage($request, 'image', 'post');
 
        // $post = Post::create($formInput);
 
        // flash('Post saved successfully.')->success();
 
        // return redirect(route('admin.posts.index'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
 
        // $formInput = $request->all();
 
        // $formInput['image'] = $this->verifyAndStoreImage($request, 'image', 'post');
 
        // $post = Post::create($formInput);
 
        // flash('Post saved successfully.')->success();
 
        // return redirect(route('admin.posts.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RoomType  $roomType
     * @return \Illuminate\Http\Response
     */
    public function show(RoomType $roomType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RoomType  $roomType
     * @return \Illuminate\Http\Response
     */
    public function edit(RoomType $roomType)
    {
        return view('roomTypes.edit', [ 'roomType' => $roomType]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RoomType  $roomType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RoomType $roomType)
    {
        $roomType->picture = $request->file( 'picture' )->Store( 'public' );
        $roomType->save();
        return redirect()->action( 'RoomTypeController@index' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RoomType  $roomType
     * @return \Illuminate\Http\Response
     */
    public function destroy(RoomType $roomType)
    {
        //
    }
}
