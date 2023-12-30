@extends('layouts.app')

@section('page-title')
    Admin - Operations
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Operations Requests
                </div>

                @if (!empty($operations))
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Userame</th>
                                    <th scope="col">E-mail</th>
                                    <th scope="col">Balance</th>
                                    <th scope="col">Request Type</th>
                                    <th scope="col">Amount Request</th>
                                    <th scope="col">Request Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            @php $x = 0 @endphp
                            <tbody>
                                @foreach ($operations as $operation)
                                    @php $x++ @endphp
                                    <tr>
                                        <th scope="row">{{ $x }}</th>
                                        <td>{{ $operation->user-> name }}</td>
                                        <td>{{ $operation->user-> email }}</td>
                                        <td>{{ $operation->user-> amount }}$</td>
                                        <td>{{ $operation-> operation_name }}</td>
                                        <td>{{ $operation-> amount }}$</td>

                                        <td>
                                            @if($operation-> status == 1)
                                                <span class="badge text-bg-danger">Refused</span>
                                            @elseif($operation-> status == 2)
                                                <span class="badge text-bg-primary">Waiting</span>
                                            @elseif($operation-> status == 3)
                                                <span class="badge text-bg-success">Accepted</span>
                                            @endif
                                        </td>

                                        <td>
                                            <div class="btn-group">
                                                {{--Todo: Accept request button --}}
                                                <form action="{{ route('admins.accept_operations',$operation-> id) }}" method="post">
                                                    @csrf
                                                    @method('put')
                                                    <button class="btn btn-success" type="submit" title="Accept Request"
                                                        @if ($operation->status == 3 || $operation->status == 1) disabled @endif>
                                                        <strong> <span>&#10003;</span> </strong>
                                                    </button>
                                                </form>

                                                {{--Todo: Refuse request button --}}
                                                <form action="{{ route('admins.refuse_operations',$operation-> id) }}" method="post">
                                                    @csrf
                                                    @method('put')
                                                    <button class="btn btn-danger" href="#" type="submit" title="Refuse Request"
                                                        @if ($operation->status == 3 || $operation->status == 1) disabled @endif>
                                                        <strong> <span>&#x58;</span> </strong>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                        {{--? pagination bar --}}
                        {!! $operations->links('pagination::bootstrap-5') !!}

                    </div>


                @else
                    <h3 style="text-align: center">
                        <span class="text-danger">No Operation Requests</span>
                    </h3>
                @endif
            </div>

        </div>
    </div>
@endsection
