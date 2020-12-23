<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:comment-create', ['only' => ['store']]);
        $this->middleware('permission:comment-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:comment-delete', ['only' => ['destroy']]);
    }

    public function store(Request $request)
    {
        $id=DB::table('coments')->insertGetId([
            'post_id' =>$request->id,
            'comment' => $request->comments
        ]);
        $comment=DB::table('coments')->select('*')->where('id','=',$id)->get();
        $comment=$comment[0];
        $comments=Carbon::parse($comment->created_at)->diffForHumans();
        return response()->Json([$comment,$comments]);
    }
    public function edit($id)
    {
//        $comment=Comment::find($id);
        $comment=DB::table('coments')->select('*')->where('id','=',$id)->get();
        $comment=$comment[0];
        return response()->Json($comment);
    }
    public function update(Request $request)
    {
//        Comment::find($request->id1)->update(['comment'=>$request->comment1]);
        DB::table('coments')
            ->where('id', '=',$request->id1)
            ->update(['comment'=>$request->comment1]);
        return response()->json($request);
    }

    public function delete($id)
    {
 //       Comment::find($id)->delete();
        DB::table('coments')
            ->where('id','=',$id)->delete();
        return response()->json(['success'=>'comment deleted!']);
    }

}
