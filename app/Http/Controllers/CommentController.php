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
        $ = $comment->created_at->diffForHumans();
        return response()->Json([$comment, $time]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     */
    public function edit($comment)
    {
        $comment = Comment::findOrFail($comment);
        return response()->Json($comment);
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(CommentRequest $request, $comment)
    {
        $comment = Comment::findOrFail($comment);
        $comment->update(['comment' => $request->comment]);
        return response()->json($comment);
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function delete($comment)
    {
        $comment = Comment::findOrFail($comment);
        $comment->delete();
        return response()->json(['success' => 'comment deleted!']);
    }
}
