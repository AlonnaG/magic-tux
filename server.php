<?php
session_start();

// initializing variables
$firstname = "";
$lastname = "";
$birthdate = "";
$username = "";
$email    = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect("localhost", "mistsj", "0627951585", "mistsj");

if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $firstname = mysqli_real_escape_string($db, $_POST['firstname']);
  $lastname = mysqli_real_escape_string($db, $_POST['lastname']);
  $birthdate = mysqli_real_escape_string($db, $_POST['birthdate']);
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($firstname)) { array_push($errors, "First Name is required"); }
  if (empty($lastname)) { array_push($errors, "Last Name is required"); }
  if (empty($birthdate)) { array_push($errors, "Birthdate is required"); }
  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match");
  }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE Username='$username' OR Email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['Username'] === $username) {
      array_push($errors, "Username already exists");
    }

    if ($user['Email'] === $email) {
      array_push($errors, "Email already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = md5($password_1);//encrypt the password before saving in the database

  	$query = "INSERT INTO users (Firstname, Lastname, Birthdate, Username, Password, Email) 
  			  VALUES('$firstname', '$lastname', '$birthdate', '$username', '$password', '$email')";
  	$test = mysqli_query($db, $query);
  	$_SESSION['username'] = $username;
  	$_SESSION['success'] = "You are now logged in";
    if($test)
    {
      header('location: index.php');
    }
  }
}
if (isset($_POST['login_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  if (empty($username)) {
    array_push($errors, "Username is required");
  }
  if (empty($password)) {
    array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {
    $password = md5($password);
    $query = "SELECT * FROM users WHERE Username='$username' AND Password='$password'";
    $results = mysqli_query($db, $query);
    if (mysqli_num_rows($results) == 1) {
      $_SESSION['username'] = $username;
      $_SESSION['success'] = "You are now logged in";
      header('location: index.php');
    }else {
      header('location: register.php');
    }
  }
}

//reset password
if (isset($_POST['reset_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);

  if (empty($username)) {
    array_push($errors, "Username is required");
  }

  if (count($errors) == 0) {
    $query = "SELECT Email FROM users WHERE username='$username'";
    if ($results = mysqli_query($db, $query)) {
      if ($result->num_rows > 0) {
        // output data of each row
        $row = mysqli_fetch_assoc($result);
        $email = $row['Email'];
        $headers = "From: mistsj@farmingdale.edu" . "\r\n" . "CC: salmistretta32@gmail.com";
        $pwrurl = "farvlu.farmingdale.edu/~mistsj/reset_password.php?q=".$username;
        $msg = "Click this link to reset your password: ".$pwrurl;
        mail($email, "Reset Password", $msg, $headers);
        echo "Your password recovery key has been sent to your e-mail address.";
      }
    }
  }
}

if (isset($_POST['send_attachment'])) {
  $username = mysqli_real_escape_string($db, $_SESSION['username']);

  if (empty($username)) {
    array_push($errors, "Username is required");
  }

  if (count($errors) == 0) {
    $query = "SELECT email FROM users WHERE username='$username'";
    if ($results = mysqli_query($db, $query)) {
      if ($result->num_rows > 0) {
        // output data of each row
        $row = mysqli_fetch_assoc($result);
        $to = $row['Email'];
        $subject = "Attachment test";
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        $message = "<html><head>
        <title>Your email at the time</title>
        </head>
        <body>
        <img src=\"picture.jpg\">
        </body>";
         
        // Send email
         
        $success = mail($to,$subject,$message,$headers);
        if (!$success) {
          echo "Mail to " . $to . " failed .";
        }else {
          echo "Success : Mail was send to " . $to ;
        }
      }
    }
  }
}
?>