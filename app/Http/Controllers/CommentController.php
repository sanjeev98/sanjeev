<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(CommentRequest $request)
    {
        $commentId = DB::table('comments')->insertGetId(['post_id' => $request->post_id, 'comment' => $request->comment]);
        $comment = DB::table('comments')->select('*')->where('id', '=', $commentId)->get();
        $createdAt = Carbon::parse($comment[0]->created_at)->diffForHumans();
        return response()->Json([$comment[0], $createdAt]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     */
    public function edit($commentId)
    {
        $comment = DB::table('comments')->select('*')->where('id', '=', $commentId)->get();
        return response()->Json($comment[0]);
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(CommentRequest $request, $commentId)
    {
        DB::table('comments')
            ->where('id', '=', $commentId)
            ->update(['comment' => $request->comment]);
        $comment = DB::table('comments')->select('*')->where('id', '=', $commentId)->get();
        return response()->json($comment[0]);
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function delete($commentId)
    {
        DB::table('comments')
            ->where('id', '=', $commentId)->delete();
        return response()->json(['success' => 'comment deleted!']);
    }
}
