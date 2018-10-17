<?php 
include('server.php'); 
$username = "";
$db = mysqli_connect("localhost", "mistsj", "0627951585", "mistsj");
if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

if (isset($_POST['reset_user'])) {
  $username = mysqli_real_escape_string($db, $_GET['q']);

  if (count($errors) == 0) {
    $password = $_POST['password'];
    $password = md5($password);
    $query = "UPDATE users SET password='$password' WHERE username='$username'";
    if ($results = mysqli_query($db, $query)) {
      echo "Password reset";
    }
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Reset Password</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="header">
  	<h2>Reset</h2>
  </div>
	
  <form method="post">
    <?php include('error.php'); ?>
  	<div class="input-group">
  	  <label>New Password</label>
  	  <input type="password" name="password">
  	</div>
  	<div class="input-group">
  	  <button type="submit" class="btn" name="reset_user">Update</button>
  	</div>
  </form>
</body>
</html>