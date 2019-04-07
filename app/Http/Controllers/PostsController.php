<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Post;

class PostsController extends Controller
{
       /**
     * Create a new controller instance.
     *
     * @return void
     */
     public function __construct()
    {
        $this->middleware('auth',['except'=>['index','show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $posts = Post::orderBy('created_at', 'desc')->paginate(10);
        return view('posts.index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = new Post;
        $this->validate($request,
        ['title'=>'required', 
        'body'=>'required',
        'cover_image'=>'image|nullable|max:1999'
        ]);
        /**
        * Handles file upload
        *
        * @param cover_image
        * Name of the Form field submitting the request
        *
        */
        if($request->hasFile('cover_image')){
            //Gets the image uploaded
            $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
            //Gets just the image name uploaded
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //Get just the File Extension
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            //the file to store on data base and file system
            $fileToStore = $fileName.time().'.'.$extension;
            
        }else{
            $fileToStore = 'no-image.jpg';
        }
        
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id;
        $post->cover_image = $fileToStore;
        //move the uploaded file
        $path=$request->file('cover_image')->storeAs('public/cover_images', $fileToStore);
        $post->save();
        return redirect('/posts')->with('success', 'Post Created Successfully');    
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        // Check correct user
        if(auth()->user()->id !== $post->user_id){
           return redirect('/posts')->with('error', 'Sorry you cannot Edit that post');
        }
        return view('posts.edit')->with('post', $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    { 
        $post = Post::find($id);
        $this->validate($request,
        ['title'=>'required', 
        'body'=>'required',
        'cover_image'=>'image|nullable|max:1999'
        ]);
        /**
        * Handles file upload
        *
        * @param cover_image
        * Name of the Form field submitting the request
        *
        */
        if($request->hasFile('cover_image')){
            Storage::delete('public/cover_images/'.$post->cover_image);
            //Gets the image uploaded
            $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
            //Gets just the image name uploaded
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //Get just the File Extension
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            //the file to store on data base and file system
            $fileToStore = $fileName.time().'.'.$extension;
            
        }
        
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        if($request->hasFile('cover_image')){
            $post->cover_image = $fileToStore;
        }
        //move the uploaded file
        $path=$request->file('cover_image')->storeAs('public/cover_images', $fileToStore);
        $post->save();
        return redirect('/posts')->with('success', 'Post Updated Successfully');    
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post =Post::find($id);
        if(auth()->user()->id !== $post->user_id){
            redirect('/posts')->with('error', "Sorry you cannot Delete that post");
        }
         
            if($post->cover_image != 'no-image.jpg'){
                Storage::delete('public/cover_images/'.$post->cover_image);
            }
        
        $post->delete();
        return redirect('/posts')->with('success', 'Post Deleted Successfully');    
    }
}
