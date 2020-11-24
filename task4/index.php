<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <title>Survey Form</title>
    <style>
        body {
            background-image: linear-gradient(to right, darkblue, dodgerblue);
        }
        .top {
            margin-top: 5%;
            margin-right: 200px;
            margin-left: 25%;
            margin-bottom: 100px;
        }
        .d {
            background-color: #f8f9fa;
        }
        .d .c {
            color: white;
            font-weight: bold;
            background-color: black;
            border-top-right-radius: 5px;
            border-top-left-radius: 5px;
        }
        .m {
            padding-top: 20px;
            padding-left: 50px;
            padding-right: 50px;
        }
    </style>
    <script>
        $(document).ready(function () {
            $('.js-example-basic-single').select2();
            $('.js-example-basic-multiple').select2();
        });
    </script>
</head>
<body>

<?php



class User{
    public $firstname;
    public $lastname;
    public $mail;
    public $phone_number;
    public $gender;
    public $department;
    public $language;
    public $language1;
    public $birthday;
    public
    function __construct($firstname,$lastname,$mail, $phone_number, $gender, $department, $language, $language1, $birthday) {
      $this.$firstname=$firstname;
      $this.$lastname=$lastname;
      $this.$mail=$mail;
      $this.$phone_number=$phone_number;
      $this.$gender=$gender;
      $this.$department=$department;
      $this.$language=$language;
      $this.$language1=$language1;
      $this.$birthday;
    }
    public function getFirstname()
    {
        return $this->firstname;
    }

    public function getLastname()
    {
        return $this->lastname;
    }
    public function getMail()
    {
        return $this->mail;
    }
    public function getBirthday()
    {
        return $this->birthday;
    }

    public function getDepartment()
    {
        return $this->department;
    }
    public function getGender()
    {
        return $this->gender;
    }
    public function getLanguage()
    {
        return $this->language;
    }
    public function getLanguage1()
    {
        return $this->language1;
    }

    public function getPhoneNumber()
    {
        return $this->phone_number;
    }
}
class Survey{

    private $age;
    private $media;
    public $conn;
    
    public function __construct($age,$media)
    {   $conn =new  mysqli("localhost", "root","sanjeev98" , "survey_form");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "INSERT INTO survey(Age,Media)
 VALUES ($age,'$media')";
        if ($conn->query($sql) === TRUE) {

        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    public function __set($name,$value)
    {   $conn =new  mysqli("localhost", "root","sanjeev98" , "survey_form");
        $sql = "SELECT COUNT(*) FROM survey where Media='$value'";
        $result = $conn->query($sql);
        $tourresult = $result->fetch_array()[0];
       // echo $tourresult;
        $sql = "SELECT COUNT(*) FROM survey;";
        $result = $conn->query($sql);
        $tour = $result->fetch_array()[0];
    echo    $percent=($tourresult[0]/$tour[0])*100;
        $con =new  mysqli("localhost", "root","sanjeev98" , "media_detail");
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }
        $sql = "INSERT INTO media(media,percentage)
 VALUES ('$value','$percent')";
        if ($con->query($sql) === TRUE) {

        } else {
            echo "Error: " . $sql . "<br>" . $con->error;
        }
    }

}

$first = $last = $mail = $phone_number = $gender = $department = $language1 = $language = $address = $birthday = $age = $media= "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ((empty($_POST["first"]) || empty($_POST["last"]) || empty($_POST["mail"]) || empty($_POST["phone_number"]) || empty($_POST["gender"]) ||
        empty($_POST["department"]) || empty($_POST["language1"]) || empty($_POST["language"]) || empty($_POST["address"]) || empty($_POST["birthday"]))) {
        $first = $last = $mail = $phone_number = $gender = $department = $language1 = $language = $address = $birthday = $age = $media= "";
    }
    else {
         $Survey = new Survey(test_input($_POST["Age"]),test_input($_POST["media"]));
         $Survey->media='Skype';
        $first = test_input($_POST["first"]);
        $last = test_input($_POST["last"]);
        $mail = test_input($_POST["mail"]);
        $phone_number = test_input($_POST["phone_number"]);
        $gender = test_input($_POST["gender"]);
        $department = test_input($_POST["department"]);
        $language1 = test_input($_POST["language1"]);
        $language = test_input($_POST["language"]);
        $address = test_input($_POST["address"]);
        $birthday = test_input($_POST["birthday"]);
    }

    if (isset($_FILES["fileToUpload"])) {
        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], 'imgaes/' . $_FILES["fileToUpload"]["name"]);
        print_r($_FILES);
        if ($_FILES["fileToUpload"]["error"]) {
            echo "<br>The uploaded file exceeds the upload_max_filesize directive in php.ini";
        }
    }
}
function test_input($data)
{
    return    htmlspecialchars(stripslashes(trim($data)));
}
?>
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
            <span><?php
                echo "Date:" . date("y.m.d");
                echo "<br>Time:" . date("h:i:sa");
                ?></span>
        </div>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
              enctype="multipart/form-data">
            <div class="m">
                <div class="row p-2">
                    <div class="col-sm-6 form-group">
                        <label>First Name</label>
                        <input type="text" class="form-control" name="first" placeholder="First Name" value="First Name"
                               maxlength="25" required>
                    </div>
                    <div class="col-sm-6 form-group">
                        <label>Last Name</label>
                        <input type="text" class="form-control" name="last" placeholder="Last Name" value="Last Name"
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
                        <select class="js-example-basic-multiple" name="language1" multiple required>
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
                    <div class="col-sm-6 form-group">
                        <label>Age</label>
                        <input type="number" class="form-control" placeholder="TypeMark" name="Age" max="100"
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
            if(!empty($_POST["first"])){
            $img = 'imgaes/' . $_FILES["fileToUpload"]["name"];
            echo '<table><tr><th>UserDetails</th><th>Values</th></tr>';
            echo '<tr><td>FirstName</td><td>', $first, ',</td></tr>';
            echo '<tr><td>LastName</td><td>', $last, ',</td></tr>';
            echo '<tr><td>Phonenumber</td><td>', $phone_number, ',</td></tr>';
            echo '<tr><td>MAIL</td><td>', $mail, ',</td></tr>';
            echo '<tr><td>Gender</td><td>', $gender, ',</td></tr>';
            echo '<tr><td>Department</td><td>', $department, ',</td></tr>';
            echo '<tr><td>Language</td><td>', $language1, ',</td></tr>';
            echo '<tr><td>Languagespoken</td><td>', $language, ',</td></tr>';
            echo '<tr><td>Address</td><td>', $address, ',</td></tr>';
            echo '<tr><td>Birthday</td><td>', $birthday, ',</td></tr>';
            echo '<tr><td>AGE</td><td>',$age, ',</td></tr>';
            echo '<tr><td>MediaUsage</td><td>',$media, ',</td></tr>';
            echo '</table>';
            echo '<img src=' . $img . '>';
            }
            ?>
        </div>
        <script>
            var d = new Date();
            document.write(d.toLocaleString('en-US', {timeZone: 'Indian/Reunion'}))
        </script>
    </div>
</div>
</body>
</html>
