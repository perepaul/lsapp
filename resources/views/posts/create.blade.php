@extends('layouts.app')

@section('content')
    <h1>Create Post</h1>
   {!!Form::open(['action'=>'PostsController@store', 'method'=>'post', 'enctype'=>'multipart/form-data'])!!}
   <div class="form-group">
       {{Form::label('title','Post Title')}}
       {{Form::text('title','',['class'=>'form-control','placehoder'=>'Title of the Post'])}}
   </div>
    <div class="form-group">
        {{Form::label('body','Post content')}}
        {{Form::textarea('body','',['id'=>'article-ckeditor','class'=>'form-control','placehoder'=>'Content of the Post'])}}
    </div>
    <div class="form-group">
        {{Form::file('cover_image')}}
    </div>
    {{Form::submit('Submit', ['class'=>'btn btn-primary btn-lg'])}}
   {!!Form::close()!!}
@endsection