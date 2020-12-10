<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;


class PostController extends Controller
{
    public function addPost()
    {
        return view('add-post');
    }

    public function createPost(Request $request)
    {
        $post = new Post();
        $post->title = $request->title;
        $post->user_id = Auth::id();
        $post->description = $request->description;
        $post->posted_by = $request->posted_by;
        $post->save();
        return back()->with('post_created', 'post has been created successfully');
    }

    public function getPost()
    {
        $posts = Post::orderBy('id', 'Desc')->where('user_id', Auth::id())->get();
        return view('posts', compact('posts'));
    }

    public function getPostById($id)
    {
        $post = Post::where('id', $id)->first();
        return view('single-post', compact('post'));
    }

    public function deletePost($id)
    {
        $post = Post::where('id', $id)->delete();
        return back()->with('post_deleted', 'post has been deleted successfully');
    }

    public function editPost($id)
    {
        $post = Post::find($id);
        return view('edit-post', compact('post'));
    }

    public function updatePost(request $request)
    {
        $post = Post::find($request->id);
        $post->title = $request->title;
        $post->description = $request->description;
        $post->posted_by = $request->posted_by;
        $post->save();
        return back()->with('post_updated', 'post has been updated successfully');
    }
}
