<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOperationRequest;
use App\Models\User;
use App\Models\Operations;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('is_user');
    }

    public function index()
    {
        if(Auth::user()->status == 3) //* when user is active
        {
            $users = User::where('id',Auth::user()->id)->paginate(5);
            return view('Clients.client',compact('users'));
        }
        elseif(Auth::user()->status == 2){ //* when user is in waiting or not-active
            return view("home");
        }
        //? if user isn't admin and not-active log him out & send session (disactivate)
        elseif (Auth::user()->status == 1 && Auth::user()->role_id == 2) {
            auth()->logout();
            return redirect()->route('login')->with('disactivate', 'Cant not login, your account has been disactive.');
        }
    }

    public function operations(StoreOperationRequest $request)
    {
        if(Auth::user()->status == 3) //* when user is active
        {
            $userAmount = $request->user()->amount;

            if($request->operation_name == "take_money" && $request->amount > $userAmount){

                return redirect()->route('users.index')->withErrors(['amount' => "Can't taking money over than your balance"]);
            }

            else{
                Operations::create([
                    "operation_name" => $request -> operation_name,
                    "amount" => $request -> amount,
                    "user_id" => Auth::id(),
                    "status" => 2 //! 1=> not-active , 2=> waiting , 3=> active
                ]);

                return redirect()->route('users.index')->with("Add","Request sended succefully");
            }
        }
        elseif(Auth::user()->status == 2){ //* when user is in waiting list
            return view("home");
        }
        else{ //? if user isn't admin and not-active log him out & send session (disactivate)
            return redirect()->route('login')->with('disactivate', 'Cant not login, your account has been disactive.');
        }

    }
}
