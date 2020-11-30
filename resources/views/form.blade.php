@extends('layouts.app')
@section('content')


<div class="top">
    <div class="d" style="border-radius: 5px">
        <nav class="navbar navabar-expand-sm justify-content-center c">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link">SURVEY FORM</a>
                </li>
            </ul>
        </nav>
        <div>
            <span><?php  echo "Date:" . date("y.m.d");echo "<br>Time:" . date("h:i:sa"); ?></span>
        </div>
        <form method="post" action="form" enctype="multipart/form-data">
            @csrf
            <div class="m">
                <div class="row p-2">
                    <div class="col-sm-6 form-group">
                        <label>First Name</label>
                        <input type="text" class="form-control" name="firstname" placeholder="First Name" value="First Name"
                               maxlength="25" required>
                    </div>
                    <div class="col-sm-6 form-group">
                        <label>Last Name</label>
                        <input type="text" class="form-control" name="lastname" placeholder="Last Name" value="Last Name"
                               maxlength="25" required>
                    </div>
                </div>
                <div class="row p-2">
                    <div class="col-sm-6 form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" placeholder="Email" name="mail" required>
                    </div>
                    <div class="col-sm-6 form-group">
                        <label>Phone Number</label>
                        <input type="number" class="form-control" placeholder="Number" name="phone_number"
                               max="1000000000" required>
                    </div>
                </div>
                <div class="row p-2">
                    <div class="col-sm-6 form-group">
                        <label>Gender</label><br>
                        <label class="radio inline">
                            <input type="radio" name="gender" value="Male" required>
                            <span>Male</span>
                        </label>
                        <label class="radio inline">
                            <input type="radio" name="gender" value="Female" required>
                            <span>Female</span>
                        </label>
                        <label class="radio inline">
                            <input type="radio" name="gender" value="Others" required>
                            <span>Others</span>
                        </label>
                    </div>
                    <div class="col-sm-6 form-group">
                        <label>Role</label>
                        <br>
                        <select class="js-example-basic-single" name="department" required>
                            <option selected>DEVELOPER</option>
                            <option>MARKETING</option>
                            <option>SALES</option>
                            <option>TEAM LEADER</option>
                        </select>
                    </div>
                </div>
                <div class="row p-2">
                    <div class=" col-sm-6 form-group mt-3">
                        <label>Birthday:</label>
                        <input type="date" class="form-control" name="birthday" required>
                    </div>
                    <div class="col-sm-6 form-group">
                        <label style="padding-bottom: 15px">Language</label>
                        <br>
                        <select class="js-example-basic-multiple" name="programing_language" multiple required>
                            <option>PHP</option>
                            <option>CSS</option>
                            <option>JAVA</option>
                            <option>PYTHON</option>
                        </select>
                    </div>
                </div>
                <div class="row p-2">
                    <div class="col-sm-6 form-group ">
                        <label>Language</label>
                        <br>
                        <div class="form-check-inline ">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="speaking_language" value="ENGLISH">ENGLISH
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="speaking_language" value="HINDI">HINDI
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="speaking_language" value="TAMIL">TAMIL
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row p-2">
                    <div class="col-sm-6 form-group">
                        <label>Age</label>
                        <input type="number" class="form-control" placeholder="TypeMark" name="age" max="100"
                               required>
                    </div>
                    <div class="col-sm-6 form-group">
                        <label>Social media</label>
                        <br>
                        <select class="js-example-basic-single" name="media" required>
                            <option selected>Facebook</option>
                            <option>WhatsAPP</option>
                            <option>Skype</option>
                        </select>
                    </div>
                </div>
                <div class="row p-2">
                    <div class="col-sm">
                        <div class="form-group">
                            <label>Address:</label>
                            <textarea class="form-control" name="address" required></textarea>
                        </div>
                    </div>
                </div>
                <span>Upload profile:</span>
                <br>
                <input type="file" name="fileToUpload" id="fileToUpload">
                <button type="submit" class="btn btn-primary p-2 mb-4 pl-1">submit</button>
            </div>
        </form>
        <div class="ap" style="margin:10%;padding-bottom: 10px">
            <?php
           /* if (!empty($_POST["first"])){
                $img = 'imgaes/' . $_FILES["fileToUpload"]["name"];
                echo '<table><tr><th>UserDetails</th><th>Values</th></tr>';
                echo '<tr><td>FirstName</td><td>'.$firstname.',</td></tr>';
                echo '<tr><td>LastName</td><td>'.$lastname.',</td></tr>';
                echo '<tr><td>Phonenumber</td><td>'.$phone_number.',</td></tr>';
                echo '<tr><td>MAIL</td><td>'.$mail.',</td></tr>';
                echo '<tr><td>Gender</td><td>'.$gender.',</td></tr>';
                echo '<tr><td>Department</td><td>'.$department.',</td></tr>';
                echo '<tr><td>program</td><td>'.$spoken_language.',</td></tr>';
                echo '<tr><td>spoken</td><td>'.$programing_language.',</td></tr>';
                echo '<tr><td>Address</td><td>'.$address.',</td></tr>';
                echo '<tr><td>Birthday</td><td>'.$birthday.',</td></tr>';
                echo '<tr><td>AGE</td><td>'.$age.',</td></tr>';
                echo '<tr><td>MediaUsage</td><td>'.$media.',</td></tr>';
                echo '</table>';
                echo '<img src=' . $img . '>';
            }*/
            ?>
                {!! $name !!}
        </div>
        <script>
            var d = new Date();
            document.write(d.toLocaleString('en-US', {timeZone: 'Indian/Reunion'}))
        </script>
    </div>
</div>

@endsection
