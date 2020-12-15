<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\User;
use App\Models\Image;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBlogPost;
use DataTables;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
       log::info('Authenticated user');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
           return DataTables::of(Post::query()) ->addIndexColumn()
               ->addColumn('action', function($row) {
                   $btn =  ' <a href="posts/'.$row->id.'" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm showPost">Show</a>';
                   $btn = $btn .'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editPost">Edit</a>';
                  '{{ csrf_token() }}';
                   $btn = $btn.'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deletePost">Delete</a>';
                   return $btn;
               })
               ->rawColumns(['action'])
               ->make(true);;
               log::info('Datatable created');
        }
        return view('posts.index');
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
        $posts= new Post();
        $posts->title=$request['title'];
        $posts->description=$request['description'];
        $posts->posted_by=$request['posted_by'];
        $post=User::find(Auth::id())->posts()->save($posts);
        $images = $request->file('files');
        foreach($images as $image)
        {   log::error("sss");
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('files'), $new_name);
            $file= new Image();
            $file->name=$new_name;
            $post->images()->save($file);
        }
        return redirect()->route('posts.index')
            ->with('success','Posts created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        $image = $post->images;
        return view('posts.show',['post'=>$post,'images'=>$image]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        return Response()->json($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Post $post)
    {
        $post->update($request->all());
        return response()->json(['success'=>'Post updated successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json(['success'=>'Post deleted!']);
    }
}
