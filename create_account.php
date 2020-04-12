<?php
  session_start();
  require_once "login.php";

  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error){
      die($conn->connect_error);
  }


  $salt1 = "no#eat*lad";
  $salt2 = "a!er@kja&o";
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <title>Table Template</title>
  <link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>
  <div class="header" style="text-align: left;">
    <a href="#default">CharGen</a>
  </div><br>
  <p>Create Account Page</p><br>
  <form>
    <br>
    <input type="text" name="username" label="Username">
    <br><br>
    <input type="password" name="pass" label="Password">
    <br><br>
    <input type="submit" name="submit" label="Create Account">
  </form>



</body>
</html>
