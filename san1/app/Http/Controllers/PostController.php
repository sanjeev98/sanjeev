<?php

namespace App\Http\Controllers;

use App\Models\posted;
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
        return DataTables::of(posted::query())->make(true);
    }
}
