<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PostController extends Controller
{
    public function index()
    {
       return view('home');
    }

    public function getData()
    {
        return DataTables::of(Post::query())->make(true);
    }
}
