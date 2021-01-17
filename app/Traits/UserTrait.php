<?php

namespace App\Traits;
use App\User;

trait UserTrait {
    
    public function index() {
        // Fetch all the users from the 'users' table.
        $users = User::all();
        return view('users')->with(compact('users'));
    }
}