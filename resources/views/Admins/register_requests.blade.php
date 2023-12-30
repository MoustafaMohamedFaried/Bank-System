@extends('layouts.app')

@section('page-title')
    Admin - Register Requests
@endsection

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Register Requests
                </div>

                <div class="card-body">
                    @if (!empty($users))
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">E-mail</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>

                            @php $x = 0 @endphp
                            @foreach ($users as $user)
                                    <tbody>

                                        {{--?  Seeing just waiting users to accept let them join the site or not --}}
                                        @if ($user->status == 2)
                                            <tr>
                                                    @php $x++ @endphp
                                                    <th scope="row">{{ $x }}</th>
                                                    <td>{{ $user-> name }}</td>
                                                    <td>{{ $user-> email }}</td>

                                                    <td>
                                                        <span class="badge text-bg-primary">Waiting</span>
                                                    </td>

                                                    <td>
                                                        <div class="btn-group">
                                                            {{--Todo: Accept user register request button --}}
                                                            <form action="{{ route('admins.accept_register_request',$user-> id) }}" method="post">
                                                                @csrf
                                                                @method('put')

                                                                <button type="submit" class="btn btn-success" title="Accept Request">
                                                                    <strong> <span>&#10003;</span> </strong>
                                                                </button>
                                                            </form>

                                                            {{--Todo: Refuse user register request button --}}
                                                            <form action="{{ route('admins.refuse_register_request',$user-> id) }}" method="post">
                                                                @csrf
                                                                @method('put')
                                                                <button class="btn btn-danger" href="#" type="submit" title="Refuse Request">
                                                                    <strong> <span>&#x58;</span> </strong>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>

                                            </tr>
                                        @endif

                                    </tbody>
                            @endforeach
                        </table>
                        {{--? pagination bar --}}
                        {!! $users->links('pagination::bootstrap-5') !!}
                    @else
                        <h1 style="text-align: center; color: red">
                            No Register Requests
                        </h1>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
