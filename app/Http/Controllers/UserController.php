<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //

    function index(){

        return User::all()->except(Auth::id());

    }

    function user_info(){
        return Auth::user();
    }
}
