<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    if(Auth::user()){
        return view('home');
    }
    else{
        return view('auth.login');
    }
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::controller(UserController::class)->group(function ()
{
    Route::get('/users', 'index')->name('users.index');
    Route::post('/users/operations', 'operations')->name('users.operations');
});


Route::controller(AdminController::class)->group(function ()
{
    //! control on operation requests (put & take money) routes
    Route::get('/admins', 'operations')->name('admins.operations');
    Route::put('/admins/accept_operations/{id}', 'accept_operations')->name('admins.accept_operations');
    Route::put('/admins/refuse_operations/{id}', 'refuse_operations')->name('admins.refuse_operations');

    //! control on users (active & disactive) routes
    Route::get('/admins/users', 'show_users')->name('admins.show_users');
    Route::put('/admins/activation_users/{id}', 'activation_users')->name('admins.activation_users');

    //! control on register_requests (accept & refuse) routes
    Route::get('/admins/register_requests', 'register_requests')->name('admins.register_requests');
    Route::put('/admins/accept_register_request/{id}', 'accept_register_request')->name('admins.accept_register_request');
    Route::put('/admins/refuse_register_request/{id}', 'refuse_register_request')->name('admins.refuse_register_request');

});
