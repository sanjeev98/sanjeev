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
use DataTables;
use Illuminate\Support\Facades\Event;
use App\Events\PostCreateEvent;
use App\Http\Requests\PostRequest;

class PostController extends Controller
{
    /**
     * Execute all request in base method.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:post-list|post-create|post-edit|post-delete', ['only' => ['index', 'show', 'getPostTable']]);
        $this->middleware('permission:post-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:post-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:post-delete', ['only' => ['destroy']]);
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        $tags = Tag::all();
        return view('posts.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $input = $request->only(['title', 'description']);
        $input['user_id'] = Auth::id();
        $input['posted_by'] = auth()->user()->email;
        $post = Post::create($input);
        $tags = array();
        if ($request->has('tags')) {
            foreach ($request->tags as $tag) {
                $tag = Tag::firstOrCreate([
                    'name' => $tag
                ]);
                $tags[] = $tag->id;
            }
        }
        $post->tags()->sync($tags, false);
        if ($request->has('files')) {
            $images = $request->file('files');
            foreach ($images as $image) {
                $new_name = rand() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('files'), $new_name);
                $file = new Image();
                $file->name = $new_name;
                $post->images()->save($file);
            }
        }
        PostCreateEvent::dispatch($post);
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
        $images = $post->images;
        return view('posts.show', ['post' => $post, 'images' => $images]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $tags = Tag::all();
        $allTags = array();
        foreach ($tags as $tag) {
            $allTags[$tag->id] = $tag->name;
        }
        $tags = $post->tags;
        $postTags = array();
        foreach ($tags as $tag) {
            $postTags[] = $tag->name;
        }
        return Response()->json([$post, $allTags, $postTags]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post)
    {
        $input = $request->only(['title', 'description']);
        $post->update($input);
        if ($request->has('tags')) {
            foreach ($request->tags as $tag) {
                $tag = Tag::firstOrCreate([
                    'name' => $tag
                ]);
                $tags[] = $tag->id;
            }
        }
        $post->tags()->sync($tags);
        PostUpdateEvent::dispatch($post);
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
        PostDeleteEvent::dispatch($post);
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
                $btn = ' <a href="posts/' . $row->id . '" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Show" class="edit btn btn-primary btn-sm show-post">Show</a>';
                $btn = $btn . '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm edit-post">Edit</a>';
                '{{ csrf_token() }}';
                $btn = $btn . '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm delete-post">Delete</a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
