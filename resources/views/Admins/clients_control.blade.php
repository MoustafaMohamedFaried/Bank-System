@extends('layouts.app')

@section('page-title')
    Admin - Clients Control
@endsection

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Clients
                    <div class="btn-group" role="group">

                        {{--Todos: Sort button --}}
                        <a class="btn btn-warning" role="button" href="{{ route('admins.sort') }}">Sort</a>

                        {{--Todos: Search section --}}
                        <form action="{{ route('admins.search') }}" method="post">
                            @csrf
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search with name or e-mail" name="search">
                                <button class="btn btn-info" type="submit">Search</button>
                            </div>
                        </form>


                    </div>

                </div>

                <div class="card-body">
                    @if (!empty($users))
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">E-mail</th>
                                    <th scope="col">Balance$</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>

                            @php $x = 0 @endphp
                            @foreach ($users as $user)
                                <tbody>

                                    {{--?  Don't seeing waiting users cause we'll show them in register_request page --}}
                                    @if ($user->status != 2)
                                        <tr>
                                            @php $x++ @endphp
                                            <th scope="row">{{ $x }}</th>
                                            <td>{{ $user-> name }}</td>
                                            <td>{{ $user-> email }}</td>
                                            <td>{{ $user-> amount }}$</td>

                                            <td>
                                                @if($user->status == 1)
                                                    <span class="badge text-bg-danger">Not-Active</span>
                                                @elseif($user->status ==3)
                                                    <span class="badge text-bg-success">Active</span>
                                                @endif
                                            </td>

                                            <td>
                                                {{--? we let button visable dependece on user's status and but the opposite --}}
                                                <form action="{{ route('admins.activation_users',$user-> id) }}" method="post">
                                                    @csrf
                                                    @method('put')

                                                    @if ($user->status == 1)
                                                        {{--Todo: Active user button --}}
                                                        <button type="submit" class="btn btn-success" title="Active User">
                                                            <strong> <span>&#10003;</span> </strong>
                                                        </button>
                                                    @elseif($user->status == 3)
                                                        {{--Todo: Disactive user button --}}
                                                        <button class="btn btn-danger" href="#" type="submit" title="Disactive User">
                                                            <strong> <span>&#x58;</span> </strong>
                                                        </button>
                                                    @endif

                                                </form>
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
                            No Clients
                        </h1>
                    @endif

                </div>

            </div>

        </div>
    </div>
</div>
@endsection
