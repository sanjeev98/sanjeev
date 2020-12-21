<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use DataTables;

class PostController extends Controller
{
    /**
     * Execute all request in base method.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        $input = $request->only(['title', 'description']);
        $input['user_id'] = Auth::id();
        $input['posted_by'] = auth()->user()->email;
        Post::create($input);
        return redirect()->route('posts.index')
            ->with('success', 'Posts created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Post $post
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
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(StoreBlogPost $request,$id)
    {
        $post=Post::find($id);
        $post->update($request->all());
        return response()->json(['success'=>'Post updated successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json(['success'=>'Customer deleted!']);
    }

    /**
     * Get post from post and send to datatable.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPostTable()
    {
        return DataTables::of(Post::query()) ->addIndexColumn()
            ->addColumn('action', function($row) {
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editPost">Edit</a>';
                '{{ csrf_token() }}';
                $btn = $btn.'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deletePost">Delete</a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
