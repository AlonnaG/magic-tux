<?php 
include('server.php'); 
?>
<!DOCTYPE html>
<html>
<head>
  <title>Forgot Password</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="header">
    <h2>Forgot Password</h2>
  </div>
   
  <form method="post">
    <?php include('error.php'); ?>
    <div class="input-group">
      <label>Username</label>
      <input type="text" name="username" >
    </div>
    <div class="input-group">
      <button type="submit" class="btn" name="reset_user">Proceed</button>
    </div>
  </form>
</body>
</html>