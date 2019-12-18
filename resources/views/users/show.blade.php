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
                <div class="card-header">Profile of {{ $user->name }}
                  
                 @if(!auth()->user()->is_following($user->id))
                 <form action="{{ route('user.follow', $user->id) }}" method="POST">
                  @csrf
                  <button class="btn btn-primary btn-sm" style="float: right;">Follow</button>
                 </form>
                  @else
                <form action="{{ route('user.unfollow', $user->id) }}" method="POST">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-danger btn-sm" style="float: right;">Unfollow</button>
                </form>
                  @endif

                </div>

                <div class="card-body">

                    <h2>Latest Posts</h2>

                    <ul class="list-group list-group-flush">
                       @foreach($user->posts as $post)
                       <li class="list-group-item">
                        <h6>{{$post->user->name}}</h6>
                        <p>{{ $post->body }}</p>
                        <span>{{$post->created_at->diffForHumans()}}</span>
                       </li>
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