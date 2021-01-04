<?php

namespace App\Http\Controllers;

use App\Events\PostDeleteEvent;
use App\Events\PostUpdateEvent;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\User;
use App\Models\Image;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBlogPost;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Event;
use App\Events\PostCreateEvent;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:post-list|post-create|post-edit|post-delete', ['only' => ['index','show']]);
        $this->middleware('permission:post-create', ['only' => ['create','store']]);
        $this->middleware('permission:post-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:post-delete', ['only' => ['destroy']]);
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
                  ;
                   $btn = ' <a href="posts/'.$row->id.'" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm showPost">Show</a>';

                   $btn = $btn .'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editPost">Edit</a>';
                  '{{ csrf_token() }}';
                   $btn = $btn.'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deletePost">Delete</a>';

                   return $btn;
               })
               ->rawColumns(['action'])
               ->make(true);
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
        $tag =Tag::all();
        return view('posts.create',compact('tag'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBlogPost $request)
    {
        $posts= new Post();
        $posts->title=$request['title'];
        $posts->description=$request['description'];
        $posts->posted_by=$request['posted_by'];
        $post=User::find(Auth::id())->posts()->save($posts);
        $tags3=array();
        foreach($request->tags as $tag1)
        {
            $tags1 = Tag::firstOrCreate([
                'name' => $tag1
            ]);
            $tags3[]=$tags1->id;
        }
        $posts->tags()->sync($tags3,false);
        $images = $request->file('files');
        foreach($images as $image)
        {   log::error("sss");
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('files'), $new_name);
            $file= new Image();
            $file->name=$new_name;
            $post->images()->save($file);
        }
        PostCreateEvent::dispatch($posts);
//        Mail::to('example@gmail.com')->send(new PostMail($posts));
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
        $tag = Tag::all();
        $tags=array();
        foreach($tag as $tag1)
        {
            $tags[$tag1->id]=$tag1->name;
        }
        $tag2=$post->tags;
        $tags3=array();
        foreach($tag2 as $tag1)
        {
            $tags3[]=$tag1->name;
        }
        return Response()->json([$post,$tags,$tags3]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(StoreBlogPost $request,$id)
    {
        $posts=Post::find($id);
        $posts->title=$request['title'];
        $posts->description=$request['description'];
        $posts->posted_by=$request['posted_by'];
        $posts->save();
        $tags3=array();
        foreach($request->tags as $tag1)
        {
            $tags1 = Tag::firstOrCreate([
                'name' => $tag1
            ]);
            $tags3[]=$tags1->id;
        }
        $posts->tags()->sync($tags3,false);
        $posts->tags()->sync($tags3);
        PostUpdateEvent::dispatch($posts);
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
        PostDeleteEvent::dispatch($post);
        $post->delete();
        return response()->json(['success'=>'Post deleted!']);
    }
}
