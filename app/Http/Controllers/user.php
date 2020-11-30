<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class user extends Controller
{
  function getData(Request $req)
  {   $name="";
      $name=$name. '<table><tr><th>UserDetails</th><th>Values</th></tr>';
      $name=$name . '<tr><td>FirstName</td><td>'.$req['firstname'].',</td></tr>';
      $name=$name . '<tr><td>LastName</td><td>'.$req['lastname'].',</td></tr>';
      $name=$name . '<tr><td>Phonenumber</td><td>'.$req['phone_number'].',</td></tr>';
      $name=$name . '<tr><td>MAIL</td><td>'.$req['mail'].',</td></tr>';
      $name=$name . '<tr><td>Gender</td><td>'.$req['gender'].',</td></tr>';
      $name=$name . '<tr><td>Department</td><td>'.$req['department'].',</td></tr>';
      $name=$name . '<tr><td>program</td><td>'.$req['programing_language'].',</td></tr>';
      $name=$name . '<tr><td>spoken</td><td>'.$req['speaking_language'].',</td></tr>';
      $name=$name . '<tr><td>Address</td><td>'.$req['address'].',</td></tr>';
      $name=$name . '<tr><td>Birthday</td><td>'.$req['birthday'].',</td></tr>';
      $name=$name . '<tr><td>AGE</td><td>'.$req['age'].',</td></tr>';
      $name=$name . '<tr><td>MediaUsage</td><td>'.$req['media'].',</td></tr>';
      $name=$name . '</table>';
      $req->file('fileToUpload')->store('docs');
      $name=$name . '<img src=' . $req['fileToUpload'] . '>';
      return view('form',['name'=>$name]);
  }
}
