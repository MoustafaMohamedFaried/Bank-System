@extends('layouts.app')

@section('page-title')
    Home
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    @if (Auth::user()->role_id == 1)
                        <span class="text-success">Admin</span>
                    @else
                        <span class="text-warning">User</span>
                    @endif
                </div>

                <div class="card-body">
                    @if (Auth::user()->role_id == 1)
                        <a class="btn btn-danger" href="{{ route('admins.register_requests') }}" role="button">Register Requests</a>
                        <a class="btn btn-warning" href="{{ route('admins.show_users') }}" role="button">Clients Control</a>
                        <a class="btn btn-success" href="{{ route('admins.operations') }}" role="button">Operations</a>
                    @else
                        @if (Auth::user()->status == 3) {{--? if user is active --}}
                            <a class="btn btn-primary" href="{{ route('users.index') }}" role="button">Your Account</a>
                        @elseif (Auth::user()->status == 2) {{--? if user is in waiting list --}}
                            <h1 style="text-align: center; color: blue">
                                Your account is in waiting list to activate
                            </h1>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
