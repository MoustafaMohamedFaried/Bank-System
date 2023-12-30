@extends('layouts.app')

@section('page-title')
    Client Account
@endsection

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Your Bank account
                </div>

                <div class="card-body">
                    <table class="table table-hover">
                        @php $x = 0 @endphp
                        @foreach ($users as $user)
                            {{--? this condition for let this content available for just users --}}
                            @if ($user->role_id == 2)
                                <tr>
                                    <th>Name</th>
                                    <td>{{ $user-> name }}</td>
                                </tr>
                                <tr>
                                    <th>E-mail</th>
                                    <td>{{ $user-> email }}</td>
                                </tr>
                                <tr>
                                    <th>Balance</th>
                                    <td>{{ $user-> amount }}$</td>
                                </tr>

                                <tr>
                                    <th>Actions</th>
                                    <td>
                                        {{--? take_money Button and we put condition to disable it when user status is not-active [1] --}}

                                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#operationModal">
                                            Operations
                                        </button>
                                        @if($user->status == 1)
                                            <span class="text-danger">your account is disabled</span>
                                        @endif

                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </table>
                </div>
            </div>
        </div>


        {{--Todos: Operations Modal doesn't work with not-active users [status = 1] --}}
        @if ($user->status != 1)
            <div class="modal fade" id="operationModal" tabindex="-1" aria-labelledby="operationModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="operationModalLabel">Put Money Request</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <form action="{{ route('users.operations') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label for="amount" class="col-form-label">Amount</label>
                                    <input type="text" class="form-control" id="amount" name="amount">
                                    <input type="text" class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount">
                                    @error('amount')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="operation_name" class="col-form-label">Operation</label>
                                    <select class="form-control" name="operation_name" id="operation_name">
                                    <select class="form-control @error('operation_name') is-invalid @enderror" name="operation_name" id="operation_name">
                                        <option disabled selected value>Choose Operation</option>
                                        <option value="put_money">Put Money</option>
                                        <option value="take_money">Take Money</option>
                                    </select>
                                    @error('operation_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Send request</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        @endif


    </div>
</div>
@endsection
