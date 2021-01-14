<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use Illuminate\Support\Carbon;

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
        $commentedAt = $comment->created_at->diffForHumans();
        return response()->Json([$comment, $commentedAt]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     */
    public function edit($commentId)
    {
        $comment = Comment::findOrFail($commentId);
        return response()->Json($comment);
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(CommentRequest $request, $commentId)
    {
        $comment = Comment::findOrFail($commentId);
        $comment->update(['comment' => $request->comment]);
        return response()->json($comment);
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function delete($commentId)
    {
        $comment = Comment::findOrFail($commentId);
        $comment->delete();
        return response()->json(['success' => 'comment deleted!']);
    }
}
