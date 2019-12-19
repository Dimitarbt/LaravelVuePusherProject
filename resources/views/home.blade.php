@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                   <p>Dashboard</p>
               </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form action="{{ route('posts.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="post">Create Post</label>
                            <textarea name="body" class="form-control"></textarea>
                            <p style="color:red;">{{ $errors->first('body') }}</p>
                        </div>
                        <input type="hidden" name="user_id" value="{{auth()->user()->id}}">

                        <button type="submit" class="btn btn-success">Create Post</button>
                    </form>

                    <hr />

                    <h2>Latest Posts</h2>

                    <ul class="list-group list-group-flush">
                       @foreach($posts as $post)
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
