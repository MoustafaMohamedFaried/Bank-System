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
        if(Auth::user()->status == 3)
        {
            $users = User::where('id',Auth::user()->id)->paginate(5);
            return view('Clients.client',compact('users'));
        }
        else
            return view("home");
    }

    public function operations(StoreOperationRequest $request)
    {
        if(Auth::user()->status == 3)
        {
<<<<<<< HEAD
            Operations::create([
                "operation_name" => $request -> operation_name,
                "amount" => $request -> amount,
                "user_id" => Auth::id(),
                "status" => 2 //! 1=> not-active , 2=> waiting , 3=> active
            ]);

            return redirect()->route('users.index');
=======
            if($request->operation_name == "take_money"){

                $userAmount = $request->user()->amount;

                if ($request->amount > $userAmount) {
                    return redirect()->route('users.index')->withErrors(['amount' => "Can't taking money over than your balance"]);
                }
            }

            else{
                Operations::create([
                    "operation_name" => $request -> operation_name,
                    "amount" => $request -> amount,
                    "user_id" => Auth::id(),
                    "status" => 2 //! 1=> not-active , 2=> waiting , 3=> active
                ]);

                return redirect()->route('users.index');
            }
>>>>>>> ed0092336b6b3f5c387a33db2611af09bdbc9bc3
        }
        else
            return view("home");
    }
}
