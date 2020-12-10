<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
   function index()
   {
       return view("form");
   }

  function getData(Request $request)
  {
      $data = $request->all();
      return view('form', compact('data'));
  }
}
