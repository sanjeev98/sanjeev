<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\User;
use App\Models\Image;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
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
        $tag = Tag::all();
        return view('posts.create', compact('tag'));
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
        $post = Post::create($input);
        if ($request->has('files')) {
            $tags3 = array();
            foreach ($request->tags as $tag1) {
                $tags1 = Tag::firstOrCreate([
                    'name' => $tag1
                ]);
                $tags3[] = $tags1->id;
            }
            $post->tags()->sync($tags3, false);
            $images = $request->file('files');
            foreach ($images as $image) {
                $new_name = rand() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('files'), $new_name);
                $file = new Image();
                $file->name = $new_name;
                $post->images()->save($file);
            }
        }
        return redirect()->route('posts.index')
            ->with('success', 'Posts created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        $image = $post->images;
        return view('posts.show', ['post' => $post, 'images' => $image]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $tag = Tag::all();
        $tags = array();
        foreach ($tag as $tag1) {
            $tags[$tag1->id] = $tag1->name;
        }
        $tag2 = $post->tags;
        $tags3 = array();
        foreach ($tag2 as $tag1) {
            $tags3[] = $tag1->name;
        }
        return Response()->json([$post, $tags, $tags3]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, $id)
    {
        $posts = Post::find($id);
        $posts->title = $request['title'];
        $posts->description = $request['description'];
        $posts->posted_by = $request['posted_by'];
        $posts->save();
        $posts->tags()->sync($request->tags);
        return response()->json(['success' => 'Post updated successfully!']);
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
        return response()->json(['success' => 'Post deleted!']);
    }

    /**
     * Get post from post and send to datatable.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPostTable()
    {
        return DataTables::of(Post::query())->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editPost">Edit</a>';
                '{{ csrf_token() }}';
                $btn = $btn . '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm deletePost">Delete</a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
