@extends('layouts.app')


@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
              @if (session('status'))
                  <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                  </div>
              @endif
                <div class="card-header">Profile of {{ auth()->user()->name }}</div>

                <div class="card-body">



                    <h2>Notifications</h2>
                    <ul>
                      @foreach($notifications as $key => $notification)
                        <li><a href="{{ route('markasRead', $notification['id'] )}}">{{ $notification['data']['follower_name'] }} {{ $notification['data']['msg'] }}</a></li>
                      @endforeach
                    </ul>
                    


                   
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">List of users</div>

                <div class="card-body">
                    <div class="list-group">
                       @foreach($users as $user)
                       <a href="{{route('user.show', $user->id) }}" class="list-group-item list-group-item-action list-group-item-primary">{{ $user->name }}</a>
                       @endforeach
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>

@endsection