@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a href="/posts/create" class="btn btn-primary">Create Post</a>
                    <h3>Your Blog Posts</h3>
                    @if(count($posts)>0)
                            <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th></th>
                                            <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($posts as $post)
                                            <tr>
                                                <td>{{$post->title}}</td>
                                                <td><a href="/posts/{{$post->id}}/edit" class="btn btn-primary">Edit</a></td>
                                                <td>
                                                    {!!Form::open(['action'=>['PostsController@destroy', $post->id ], 'method'=>'POST', 'style'=>'float:right;'])!!}
                                                        {{Form::hidden('_method','DELETE')}}
                                                        {{Form::submit('Delete',['class'=>'btn btn-danger pull-right'])}}
                                                    {!!Form::close()!!}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                            </table>
                    
                        @else
                        <p>You Have no posts yet</>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
