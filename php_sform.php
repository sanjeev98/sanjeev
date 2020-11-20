<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

    <title>Survey Form</title>
    <style>
        body{

            background-image: linear-gradient(to right, darkblue , dodgerblue);
        }
        .top{

            margin-top: 5%;
            margin-right:200px;
            margin-left:25%;
            margin-bottom:100px;
        }
        .d{
            background-color:#f8f9fa;
        }
        .d .c{
            color:white;
            font-weight: bold;
            background-color: black;
            border-top-right-radius: 5px;
            border-top-left-radius: 5px;
        }
        .m{
            padding-top:20px;
            padding-left:50px;
            padding-right:50px;
        }

    </style>
    <script>

        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });
    </script>
</head>
<body>
<?php
$first = $last = $mail = $Phone_number = $gender = $department=$language1=$language=$address=$birthday="";
if($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!(empty($_POST["first"]) || empty($_POST["last"]) || empty($_POST["$mail"]) || empty($_POST["Phone_number"]) || empty($_POST["gender"]) ||
        empty($_POST["department"]) || empty($_POST["language1"]) || empty($_POST["language"]) || empty($_POST["address"]) || empty($_POST["birthday"]))) {
        $first = $last = $mail = $Phone_number = $gender = $department = $language1 = $language = $address = $birthday = "";
    } else {

        $first = test_input($_POST["first"]);
        $last = test_input($_POST["last"]);
        $mail = test_input($_POST["mail"]);
        $Phone_number = test_input($_POST["Phone_number"]);
        $gender = test_input($_POST["gender"]);
        $department = test_input($_POST["department"]);
        $language1 = test_input($_POST["language1"]);
        $language = test_input($_POST["language"]);
        $address = test_input($_POST["address"]);
        $birthday = test_input($_POST["birthday"]);

    }
}
    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

?>
<div class="top" >
    <div class="d" style="border-radius: 5px">
        <nav class="navbar navabar-expand-sm  justify-content-center c">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link">SURVEY FORM</a>
                </li>
            </ul>
        </nav>

        <form   method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="m">
                <div class="row p-2 ">
                    <div class="col-sm-6 form-group">
                        <label>First Name</label>
                        <input type="text" class="form-control" name="first" placeholder="First Name" value="First Name" maxlength="25" required>
                    </div>
                    <div class="col-sm-6 form-group">
                        <label>Last Name</label>
                        <input type="text" class="form-control"name="last" placeholder="Last Name" value="Last Name" maxlength="25" required>
                    </div>
                </div>
                <div class="row p-2">
                    <div class="col-sm-6 form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" placeholder="Email" name="mail" required>
                    </div>
                    <div class="col-sm-6 form-group">
                        <label>Phone Number</label>
                        <input type="number" class="form-control" placeholder="Number" name="Phone_number" max="1000000000" required>
                    </div>
                </div>
                <div class="row p-2">
                    <div class="col-sm-6 form-group">
                        <label>Gender</label><br>
                        <label class="radio inline" >
                            <input type="radio" name="gender" value="Male" required>
                            <span>Male</span>
                        </label>
                        <label class="radio inline" >
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
                            <option selected >DEVELOPER</option>
                            <option>MARKETING</option>
                            <option>SALES</option>
                            <option>TEAM LEADER</option>
                        </select>
                    </div>
                </div>
                <div class="row p-2">
                    <div class=" col-sm-6 form-group mt-3">
                        <label >Birthday:</label>
                        <input type="date" class="form-control" name="birthday" required>
                    </div>
                    <div class="col-sm-6 form-group">
                        <label style="padding-bottom: 15px">Language</label>
                        <br>
                        <select class="js-example-basic-multiple" name="language1"multiple required>
                            <option >PHP</option>
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
                        <div class=" form-check-inline " >

                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="language" value="ENGLISH">ENGLISH
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="language" value="HINDI">HINDI
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="language" value="TAMIL">TAMIL
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row p-2">
                    <div class="col-sm">
                        <div class="form-group">
                            <label >Address:</label>
                            <textarea class="form-control" name="address" required></textarea>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary p-2 mb-4 pl-1">submit</button>

            </div>
        </form>
        <div class="ap " style="margin:10%;padding-bottom: 10px" >
           <?php

                echo "<h2>DETAILS:</h2>";
                echo $first ;
                echo " <br>";
                echo $last . "<br>";
                echo $Phone_number;
                echo $mail;
                echo $gender . "<br>";
                echo $department;
                echo $language1 . "<br>";
                echo $language;
                echo "<br>";
                echo $address;
                echo "<br>";
                echo $birthday;

            ?>
        </div>
    </div>

</div>

</body>
</html>
