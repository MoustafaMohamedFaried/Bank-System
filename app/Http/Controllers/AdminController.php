<?php

namespace App\Http\Controllers;

use App\Mail\RegisterRequestMail;
use App\Models\Operations;
use App\Models\User;
use Illuminate\Http\Client\Request;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('is_admin');
    }

    //Todos: this function for letting admin seeing operations request
    public function operations()
    {
        $operations = Operations::with('user')->orderBy('created_at','desc')->paginate(5);
        return view('Admins.operations',compact('operations'));
    }

    //Todos: this function for letting admin accept operations requests
    public function accept_operations($id)
    {
        $operation = Operations::with('user')->findOrFail($id);

        //* we used the relation between user & operation for taking current user's amount
        $user_amount = $operation->user->amount;

        //? in this condition we make new variable (Put_Money) and put inside it the equation
        //? then we update the operation status & update current user's amount with new record by using the relation
        if($operation->operation_name == "put_money"){
            $Put_Money = $user_amount + $operation->amount;

            $operation->update([
                "status" => 3, //* accepted
            ]);

            //! Use the update method on the relationship, not on the table directly
            $operation->user->update([
                "amount" => $Put_Money
            ]);
        }

        //? in this condition we make new variable (Take_Money) and put inside it the equation
        //? then we update the operation status & update current user's amount with new record by using the relation
        elseif($operation->operation_name == "take_money"){
            $Take_Money = $user_amount - $operation->amount;

            $operation->update([
                "status" => 3, //* accepted
            ]);

            //! Use the update method on the relationship, not on the table directly
            $operation->user->update([
                "amount"=> $Take_Money
            ]);
        }

        return redirect()->route('admins.operations');
    }

    //Todos: this function for letting admin refuse operations requests
    public function refuse_operations($id)
    {
        $operation = Operations::with('user')->findOrFail($id);

        $operation->update([
            "status" => 1, //* refused
        ]);
        return redirect()->route('admins.operations');
    }

    //Todos: this function for letting admin seeing users for control on them (active,not-active)
    public function show_users()
    {
        $users = User::where('role_id',2)->paginate(5); //? just seeing users (not admins)
        return view('Admins.clients_control',compact('users'));
    }

    //Todos: this function for letting admin refuse operations requests
    public function activation_users($id)
    {
        $user = User::findOrfail($id);
        //? if user is not-active (status = 1) let him active (status = 3)
        if($user->status == 1)
        {
            $user -> update([
                "status" => 3
            ]);
        }
        //? if user is active (status = 3) let him not-active (status = 1)
        elseif($user->status == 3)
        {
            $user -> update([
                "status" => 1
            ]);
        }
        return redirect()->route("admins.show_users");
    }

    public function sort()
    {
        $users = User::orderBy('name')->where('role_id',2)->paginate(5);
        return view("Admins.clients_control",compact("users"));
    }
    public function search(HttpRequest $request)
    {
        $search_value = $request->search;
        $users = DB::table('users')->where('name', 'LIKE', '%'.$search_value.'%')
            ->orWhere('email', 'LIKE', '%'.$search_value.'%')
            ->paginate(5);
        return view("Admins.clients_control",compact("users"));
    }

    //Todos: this function for letting admin seeing users for control on them (active,not-active)
    public function register_requests()
    {
        //? just seeing users (not admins) , status 2 (waiting)
        $users = User::where('role_id',2)->where('status',2)->paginate(5);
        return view('Admins.register_requests',compact('users'));
    }

    //Todos: this function for letting admin can accept users register request by changing status
    public function accept_register_request($id)
    {
        $user = User::findOrfail($id);

        $user -> update([
            "status" => 3
        ]);

        Mail::to($user->email)->send(new RegisterRequestMail($user));

        return redirect()->route("admins.show_users");
    }

    //Todos: this function for letting admin can refuse users register request by changing status
    public function refuse_register_request($id)
    {
        $user = User::findOrfail($id);

        $user -> update([
            "status" => 1
        ]);

        Mail::to($user->email)->send(new RegisterRequestMail($user));

        return redirect()->route("admins.show_users");
    }

}
