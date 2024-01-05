<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //? if user isn't admin and not-active log him out & send session (disactivate)
        if(Auth::user()->role_id == 2 && Auth::user()->status == 1)
        {
            auth()->logout();
            return redirect()->route('login')->with('disactivate', 'Cant not login, your account has been disactive.');
        }
        else
            return view('home');
    }
}
