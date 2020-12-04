<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class userController extends Controller
{
   function index()
   {
       return view("form");
   }

  function getData(Request $req)
  {     $data=$req;
      return view('form',compact('data'));
  }
}
