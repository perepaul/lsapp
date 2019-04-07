@extends('layouts.app')

@section('content')
    <h1>Posts</h1>
    @if(count($posts) > 0)
        @foreach($posts as $post)
            <div class="well">
               <div class="row">
                   <div class="col-md-4 col-sm-4" style='margin-bottom:5px;'>
                       <img style="width:100%; height:300px;" class='img-responsive' src="/storage/cover_images/{{$post->cover_image}}"  >
                   </div>
                   <div class="col-md-8 col-sm-8">
                        <h3><a  href="/posts/{{$post->id}}">{{$post->title}}</a></h3>
                        {!!str_limit($post->body, 40,'',40)!!}</p>
                        <small>Posted on: {{$post->created_at}} By {{$post->user->name}}</small>
                   </div>
               </div>
            </div>
        @endforeach
        {{$posts->links()}}
        @else
        <p> no posts found </p>
    @endif
@endsection