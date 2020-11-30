<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class user extends Controller
{
  function getData(Request $req)
  {
      echo '<table><tr><th>UserDetails</th><th>Values</th></tr>';
      echo '<tr><td>FirstName</td><td>'.$req['firstname'].',</td></tr>';
      echo '<tr><td>LastName</td><td>'.$req['lastname'].',</td></tr>';
      echo '<tr><td>Phonenumber</td><td>'.$req['phone_number'].',</td></tr>';
      echo '<tr><td>MAIL</td><td>'.$req['mail'].',</td></tr>';
      echo '<tr><td>Gender</td><td>'.$req['gender'].',</td></tr>';
      echo '<tr><td>Department</td><td>'.$req['department'].',</td></tr>';
      echo '<tr><td>program</td><td>'.$req['programing_language'].',</td></tr>';
      echo '<tr><td>spoken</td><td>'.$req['speaking_language'].',</td></tr>';
      echo '<tr><td>Address</td><td>'.$req['address'].',</td></tr>';
      echo '<tr><td>Birthday</td><td>'.$req['birthday'].',</td></tr>';
      echo '<tr><td>AGE</td><td>'.$req['age'].',</td></tr>';
      echo '<tr><td>MediaUsage</td><td>'.$req['media'].',</td></tr>';
      echo '</table>';
      $req->file('fileToUpload')->store('docs');
      echo '<img src=' . $req['fileToUpload'] . '>';
  }
}
