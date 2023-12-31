@if ($user->status == 1)
    <h1>
        Welcome {{ $user->name }}
    </h1>
    <h3 style="text-align: center; color: red">
        Your Registeration request has been refused
    </h3>

@elseif ($user->status == 3)
    <h1>
        Welcome {{ $user->name }}
    </h1>
    <h3 style="text-align: center; color: green">
        Your Registeration request has been accepted
    </h3>
@endif
