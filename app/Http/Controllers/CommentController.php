<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(Request $request)
    {
        $comment = new Comment();
        $comment->post_id = $request->id;
        $comment->comment = $request->comments;
        $comment->save();
        $comments = $comment->created_at->diffForHumans();
        return response()->Json([$comment, $comments]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     */
    public function edit($id)
    {
        $comment = Comment::find($id);
        return response()->Json($comment);
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(Request $request)
    {
        Comment::find($request->id1)->update(['comment' => $request->comment1]);
        return response()->json($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function delete($id)
    {
        Comment::find($id)->delete();
        return response()->json(['success' => 'comment deleted!']);
    }
}
