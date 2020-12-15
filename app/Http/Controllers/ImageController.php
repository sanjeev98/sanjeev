<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;

class ImageController extends Controller
{
    public function show($id)
    {
        $image=Image::where('post_id',$id)->first();
        return Response()->json($image);
    }

    public function edit()
    {

    }
}
