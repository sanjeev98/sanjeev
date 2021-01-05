<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $comment = new Comment();
        $comment->post_id = $request->id;
        $comment->comment = $request->comments;
        $comment->save();
        $comments = $comment->created_at->diffForHumans();
        return response()->Json([$comment, $comments]);
    }

    public function edit($id)
    {
        $comment = Comment::find($id);
        return response()->Json($comment);
    }

    public function update(Request $request)
    {
        Comment::find($request->id1)->update(['comment' => $request->comment1]);
        return response()->json($request);
    }

    public function delete($id)
    {
        Comment::find($id)->delete();
        return response()->json(['success' => 'comment deleted!']);
    }
}
