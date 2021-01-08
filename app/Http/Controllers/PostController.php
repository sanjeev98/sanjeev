<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\User;
use App\Models\Image;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use DataTables;
use Illuminate\Support\Facades\DB;


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
        $tags = DB::table('tags')->select('*')->get();
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
        $userId = Auth::id();
        $postedBy = auth()->user()->email;
        DB::insert('insert into posts (user_id, title, description, posted_by) values(?, ?, ?, ?)', [$userId, $request['title'], $request['description'], $postedBy]);
        $posts = DB::table('posts')->select('id')->where('user_id', '=', $userId)->orderBy('id', 'desc')->first();
        if ($request->has('tags')) {
            foreach ($request->tags as $tag) {
                DB::table('tags')->insertOrIgnore(['name' => $tag]);
                $tagId = DB::table('tags')->select('id')->where('name', '=', $tag)->first();
                DB::table('post_tag')->insert(['post_id' => $posts->id, 'tag_id' => $tagId->id]);
            }
        }
        if ($request->has('files')) {
            $images = $request->file('files');
            foreach ($images as $image) {
                $new_name = rand() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('files'), $new_name);
                DB::table('images')->insert(['post_id' => $posts->id, 'name' => $new_name]);
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
        $post = DB::table('posts')->select('*')->where('id', '=', $id)->get();
        $images = DB::table('posts')
            ->join('images', 'posts.id', '=', 'images.post_id')
            ->select('images.name')
            ->where('posts.id', '=', $id)
            ->get();
        return view('posts.show', ['post' => $post[0], 'images' => $images]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = DB::table('posts')->select('*')->where('id', '=', $id)->get();
        $tags = DB::table('tags')->select('*')->get();
        $allTags = array();
        foreach ($tags as $tag) {
            $allTags[$tag->id] = $tag->name;
        }
        $tags = DB::table('post_tag')->select('tag_id')->where('post_id', '=', $id)->get();
        $postTags = array();
        foreach ($tags as $tag) {
            $postTags[] = $tag->tag_id;
        }
        return Response()->json([$post[0], $allTags, $postTags]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, $id)
    {
        DB::table('posts')->where('id', $id)->update(['title' => $request['title'], 'description' => $request['description']]);
        DB::table('post_tag')->where('post_id', '=', $id)->delete();
        if ($request->has('tags')) {
            foreach ($request->tags as $tag) {
                DB::table('tags')->insertOrIgnore(['name' => $tag]);
                $tagId = DB::table('tags')->select('id')->where('name', '=', $tag)->first();
                DB::table('post_tag')->insert(['post_id' => $id, 'tag_id' => $tagId->id]);
            }
        }
        return response()->json(['success' => 'Post updated successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('posts')->where('id', '=', $id)->delete();
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
