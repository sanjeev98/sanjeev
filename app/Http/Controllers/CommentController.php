<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class CommentController extends Controller
{
    public function show($id)
    {
        $post = Post::find($id);
        $image = $post->images;
        return view('posts.show',['post'=>$post,'images'=>$image]);
    }

    public function store(Request $request)
    {
        $comment= Comment::create(['user'=>$request['user'], 'email'=>$request['email'],'comment'=>$request['comment'],'post_id'=>$request['post_id']]);
        $comment['time']=$comment->created_at->diffForHumans();
        return response()->Json([$comment]);
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
