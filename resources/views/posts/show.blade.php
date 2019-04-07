@extends('layouts.app')

@section('content')
<a href="/posts" class="btn btn-success"> &laquo; Go Back</a><hr><br>
        @if(!empty($post))
            <h1>{{$post->title}}</h1><br>
            <img style="width:100%; height:500px;" class="img-responsive" src="/storage/cover_images/{{$post->cover_image}}" >
            <div>
                    <br><br>
                    <div class="container">
                            {!!$post->body!!}
                    </div>
                <br><br>
            </div>
            <hr>
            <p>Created at: {{$post->created_at}} By {{$post->user->name}}</p>
            @if(!Auth::guest())
                @if(Auth::user()->id === $post->user_id)
                    <a href="/posts/{{$post->id}}/edit" class="btn btn-primary pull-left">Edit Post</a>
                    {!!Form::open(['action'=>['PostsController@destroy', $post->id ], 'method'=>'POST', 'style'=>'float:right;'])!!}
                        {{Form::hidden('_method','DELETE')}}
                        {{Form::submit('Delete',['class'=>'btn btn-danger pull-right'])}}
                    {!!Form::close()!!}
                @endif
            @endif
        @else
        <br><br>
        <p>This post has been deleted</p>
    @endif
@endsection
