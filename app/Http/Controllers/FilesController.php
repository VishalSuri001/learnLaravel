<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FilesController extends Controller
{
    public function show(Request $request)
    {
        $pathToFile = storage_path('app/public/5j8WK19rKVEii6u5SmHsbuf5mQl1owqCBWEhjFaY.jpeg');
        $fileName = 'DoubleKingBed.jpeg';
        return response()->download($pathToFile, $fileName);
    }

    public function create(Request $request)
    {
        $path = $request->file( 'photo' )->store('public');
        return response()->json(['path' => $path], 200);
    }
}
