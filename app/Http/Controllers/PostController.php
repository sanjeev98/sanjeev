<?php

namespace App\Http\Controllers;

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
//        $tag =Tag::all();
        $tag=DB::table('tags')->select('*')->get();
        return view('posts.create',compact('tag'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        $posts= new Post();
//        $posts->title=$request['title'];
//        $posts->description=$request['description'];
//        $posts->posted_by=$request['posted_by'];
//        $post=User::find(Auth::id())->posts()->save($posts);
//        $posts->tags()->sync($request->tags,false);
        $images = $request->file('files');
        $id=Auth::id();
        DB::insert('insert into posts (user_id, title, description, posted_by) values(?, ?, ?, ?)',[$id,$request['title'],$request['description'],$request['posted_by']]);
        $posts = DB::table('posts')
            ->select('id')
            ->where('user_id','=',$id)
            ->orderBy('id','desc')
            ->first();
        foreach ($request->tags as $tag ) {

            DB::table('post_tag')->insert([
                'post_id' =>$posts->id,
                'tag_id' => $tag
            ]);
        }
        foreach($images as $image)
        {   log::error("sss");
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('files'), $new_name);
//            $file= new Image();
//            $file->name=$new_name;
//            $post->images()->save($file);
            DB::table('images')->insert(  ['post_id' => $posts->id,'name' => $new_name ]);
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
//        $post = Post::find($id);
//        $image = $post->images;
        $post= DB::table('posts')->select('*')->where('id','=',$id)->get();
        $image = DB::table('posts')
            ->join('images', 'posts.id', '=', 'images.post_id')
            ->select( 'images.name')
            ->where('posts.id','=',$id)
            ->get();
        $post=$post[0];
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
//        $post = Post::find($id);
//        $tag = Tag::all();
        $post= DB::table('posts')->select('*')->where('id','=',$id)->get();
        $tag =  DB::table('tags')->select('*')->get();
        $post=$post[0];
        $tags=array();
        foreach($tag as $tag1)
        {
          $tags[$tag1->id]=$tag1->name;
        }
//        $tag2=$post->tags;
        $tag2 = DB::table('post_tag')
            ->select('tag_id')
            ->where('post_id','=',$id)
            ->get();
        $tags3=array();
        foreach($tag2 as $tag1)
        {
            $tags3[]=$tag1->tag_id;
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
    public function update(Request $request,$id)
    {
//        $posts=Post::find($id);
//        $posts->title=$request['title'];
//        $posts->description=$request['description'];
//        $posts->posted_by=$request['posted_by'];
//        $posts->save();
//        $posts->tags()->sync($request->tags);
        DB::table('posts')
            ->where('id', $id)
            ->update(['title'=>$request['title'],
        'description'=>$request['description'],
        'posted_by'=>$request['posted_by']]);
        DB::table('post_tag')->where('post_id','=',$id)->delete();
        foreach ($request->tags as $tag ) {

            DB::table('post_tag')->insert([
                'post_id' =>$id,
                'tag_id' => $tag
            ]);
        }
        return response()->json(['success'=>'Post updated successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('posts')->where('post_id','=',$id)->delete();
        return response()->json(['success'=>'Post deleted!']);
    }
}
