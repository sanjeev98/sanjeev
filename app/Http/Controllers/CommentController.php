<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(CommentRequest $request)
    {
        $input = $request->only(['post_id', 'comment']);
        $comment = Comment::create($input);
        $time = $comment->created_at->diffForHumans();
        return response()->Json([$comment, $time]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param \App\Models\comment $comment
     */
    public function edit(comment $comment)
    {
        return response()->Json($comment);
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(CommentRequest $request)
    {
        $comment = Comment::findOrFail($request->id1);
        $comment->update(['comment' => $request->comment1]);
        return response()->json($comment->comment);
    }

    /**
     * Remove the specified resource from storage.
     * @param \App\Models\comment $comment
     */
    public function delete(comment $comment)
    {
        $comment->delete();
        return response()->json(['success' => 'comment deleted!']);
    }
}
