<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Carbon;
use function PHPUnit\Framework\isEmpty;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(CommentRequest $request)
    {
        $user = User::where('email', '=', $request['email'])->first();
        $input = $request->only(['email', 'user_name']);
        $input['password'] = bcrypt('12345678');
        if (!$user) {
            $user = User::Create([$input]);
        }
        $input = $request->only(['post_id', 'comment']);
        $input['user_id'] = $user->id;
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
