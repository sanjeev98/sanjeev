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
            <strong>"Date:"</strong><b>{{date("y.m.d")}}</b><br>
            <strong>Time:"</strong><b>{{date("h:i:sa")}}</b>
        </div>
        <form method="post" action="form" enctype="multipart/form-data">
            @csrf
            <div class="m">
                <div class="row p-2">
                    <div class="col-sm-6 form-group">
                        <label>First Name</label>
                        <input type="text" class="form-control" name="array[]" placeholder="First Name" value="First Name"
                               maxlength="25" required>
                    </div>
                    <div class="col-sm-6 form-group">
                        <label>Last Name</label>
                        <input type="text" class="form-control" name="array[]" placeholder="Last Name" value="Last Name"
                               maxlength="25" required>
                    </div>
                </div>
                <div class="row p-2">
                    <div class="col-sm-6 form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" placeholder="Email" name="array[]" required>
                    </div>
                    <div class="col-sm-6 form-group">
                        <label>Phone Number</label>
                        <input type="number" class="form-control" placeholder="Number" name="array[]"
                               max="1000000000" required>
                    </div>
                </div>
                <div class="row p-2">
                    <div class="col-sm-6 form-group">
                        <label>Gender</label><br>
                        <label class="radio inline">
                            <input type="radio" name="data" value="Male" required>
                            <span>Male</span>
                        </label>
                        <label class="radio inline">
                            <input type="radio" name="data" value="Female" required>
                            <span>Female</span>
                        </label>
                        <label class="radio inline">
                            <input type="radio" name="data" value="Others" required>
                            <span>Others</span>
                        </label>
                    </div>
                    <div class="col-sm-6 form-group">
                        <label>Role</label>
                        <br>
                        <select class="js-example-basic-single" name="data" required>
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
                        <input type="date" class="form-control" name="data" required>
                    </div>
                    <div class="col-sm-6 form-group">
                        <label style="padding-bottom: 15px">Language</label>
                        <br>
                        <select class="js-example-basic-multiple" name="data" multiple required>
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
                                <input type="checkbox" class="form-check-input" name="data" value="ENGLISH">ENGLISH
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="data" value="HINDI">HINDI
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="data" value="TAMIL">TAMIL
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row p-2">
                    <div class="col-sm-6 form-group">
                        <label>Age</label>
                        <input type="number" class="form-control" placeholder="TypeMark" name="data" max="100"
                               required>
                    </div>
                    <div class="col-sm-6 form-group">
                        <label>Social media</label>
                        <br>
                        <select class="js-example-basic-single" name="data" required>
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
                            <textarea class="form-control" name="data" required></textarea>
                        </div>
                    </div>
                </div>
                <span>Upload profile:</span>
                <br>
                <input type="file" name="data" id="fileToUpload">
                <button type="submit" class="btn btn-primary p-2 mb-4 pl-1">submit</button>
            </div>
        </form>
        <div class="ap" style="margin:10%;padding-bottom: 10px">
            <table>
                <tr>
                    <th>UserDetails</th>
                    <th>  {!! $data[0] !!}</th>
                </tr>
                <tr>
                    <td>FirstName</td>
                    <td>  {!! $data[1] !!}</td>
                </tr>
                <tr>
                    <td>LastName</td>
                    <td>  {!! $data[2] !!}</td>
                </tr>
                <tr>
                    <td>Phonenumber</td>
                    <td>  {!! $data[3] !!}</td>
                </tr>
                <tr>
                    <td>MAIL</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Gender</td>
                    <td>  {!! $data[4] !!}</td>
                </tr>
                <tr>
                    <td>Department</td>
                    <td>  {!! $data[5] !!}</td>
                </tr>
                <tr>
                    <td>program</td>
                    <td>  {!! $data[6] !!}</td>
                </tr>
                <tr>
                    <td>spoken</td>
                    <td>  {!! $data[7] !!}</td>
                </tr>
                <tr>
                    <td>Address</td>
                    <td>  {!! $data[8] !!}</td>
                </tr>
                <tr>
                    <td>Birthday</td>
                    <td>  {!! $data[9] !!}</td>
                </tr>
                <tr>
                    <td>AGE</td>
                    <td>  {!! $data[10] !!}</td>
                </tr>
                <tr>
                    <td>MediaUsage</td>
                    <td>  {!! $data[11] !!}</td>
                </tr>
            </table>
        </div>

        <script>
            var d = new Date();
            document.write(d.toLocaleString('en-US', {timeZone: 'Indian/Reunion'}))
        </script>

    </div>
</div>

@endsection
