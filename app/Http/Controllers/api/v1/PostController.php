<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Requests\StoreBlogPost;
use App\Models\Image;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Resources\V1\PostResource;
use App\Models\Post;


class PostController extends Controller
{
    public function __construct()
    {
        auth()->setDefaultDriver('api');
        $this->middleware('auth:api')->only(['store', 'update', 'destroy']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PostResource::collection(Post::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBlogPost $request)
    {
      try {
          $input = $request->only(['title', 'description']);
          $input['user_id'] = auth()->user()->id;
          $input['posted_by'] = auth()->user()->email;
          $post = Post::create($input);
          $post['message'] = 'Post Created Successfully';
          if($request->has('files')) {
              $images = $request->file('files');
              foreach ($images as $image) {
                  $new_name = rand() . '.' . $image->getClientOriginalExtension();
                  $image->move(public_path('files'), $new_name);
                  Image::create([
                      'name' =>$new_name,
                      'post_id'=> $post->id
                  ]);
              }
          }
      }catch (\Exception $exception)
      {
          $response = [
              "status" => "Internal server Error",
              "error" => [
                  "message" => $exception->getMessage()
              ]
          ];
          return response()->json($response,500);
      }
        return new PostResource($post);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
        $post = Post::with('images')->findOrFail($id);
}   catch (ModelNotFoundException $exception) {
        $error = [
            "status" => "Unknown Post" ,
            "controller_error" =>[
                "code" => "Model Not Found",
                "message" => $exception->getMessage()
            ]
        ];
        throw new ModelNotFoundException( response()->json($error,404));
    }
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->only(['title', 'description']);
        try{
        $post = Post::findOrFail($id);
    } catch (ModelNotFoundException $exception) {
            $error = [
                "status" => "Unknown Post" ,
                "controller_error" =>[
                    "code" => "Model Not Found",
                    "message" => $exception->getMessage()
            ]
            ];
   throw new ModelNotFoundException( response()->json($error,404));
    }
        $post->update($input);
        $post['message'] = 'Post Updated Successfully';
        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $post = Post::findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            $error = [
                "status" => "Unknown Post" ,
                "controller_error" =>[
                    "code" => "Model Not Found",
                    "message" => $exception->getMessage()
                ]
            ];
            throw new ModelNotFoundException( response()->json($error,404));
        }
        $post->delete();
        return new PostResource(['message' => 'Post Successfully Deleted' ]);
    }
}
