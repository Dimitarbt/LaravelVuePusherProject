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

              @if($errors->any())
                {!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
              @endif

              <div class="card-header d-flex">
                <div class="info-user">
                  @if(auth()->user()->id == $user->id)
                   @if(auth()->user()->profile_photo)
                    <img src="{{asset('/storage/'.auth()->user()->profile_photo)}}" alt="Me" class="img-thumbnail">
                   @else
                    <img src="{{asset('/img/avatar.png')}}" alt="Me" class="img-thumbnail">
                   @endif
                  @else

                    @if($user->profile_photo)
                    <img src="{{asset('/storage/'.$user->profile_photo)}}" alt="{{$user->name}}" class="img-thumbnail">
                    @else
                    <img src="{{asset('/img/avatar.png')}}" alt="Me" class="img-thumbnail">
                    @endif


                  @endif

                   <p>{{ $user->name }}</p>


                </div>
              
                <div class="btn-action">
                @if(auth()->user()->id == $user->id)
                      <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editUser">
                      Edit 
                    </button>
                @else
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
                @endif
                </div>
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


<!-- Modal -->
<div class="modal fade" id="editUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit {{ auth()->user()->name }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{ route('user.update', auth()->user()->id )}}" enctype= multipart/form-data>
        @csrf
        @method('PUT')
      <div class="modal-body">
              <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" value="{{old('name') ?? auth()->user()->name }}">
              </div>

              <div class="form-group d-flex flex-column">
                <label for="profile_photo">Profile Photo</label>
                <input type="file" name="profile_photo">
              </div>



            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" >Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>

@endsection