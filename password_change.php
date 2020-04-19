<?php
  session_start();
  if(isset($_SESSION["username"])){
    $username = $_SESSION["username"];
  } else {
    header("Location: login_page.php");
  }


  require_once "login.php";

  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error){
      die($conn->connect_error);
  }

  $success = '';
  $error = '';
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <title>Password Change</title>
  <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Montserrat:wght@600&family=Righteous&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Righteous&display=swap" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>
  <div class="header">
    <div class="inner_header">
      <div class="logo_container">
        <h1>Char<span>Gen</span></h1>
        <img src="20_sided.png" alt="20 sided die">
      </div>
      <ul class="navigation">
        <a href="myAccount.php"><li>My Account</li></a>
        <a href="logout_page.php"><li>Logout</li></a>
    </div>
  </div>

  <?php

  if(isset($_POST['submit'])){
    $username = $_SESSION["username"];
    $currentPass = $_POST["currentPassword"];
    $newPass = $_POST["newPassword"];
    $veripass = $_POST["veripass"];
    /*$salted = "no#eat*lad".."a!er@kja&o";
    $hashed = hash('ripemd128', $salted);*/

    $sql = "SELECT * FROM users WHERE username='" . $username . "';";
    $result = $conn->query($sql);

    if (mysqli_num_rows($result) == 0){
      $error = "ERROR: You are not logged in or your account does not exist.";
    } else {
      $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
      $saltedOld = "no#eat*lad".$currentPass."a!er@kja&o";
      $hashedOld = hash('ripemd128', $saltedOld);

      if($hashedOld == $row['password']){
        if ($newPass == $veripass){
          $salted = "no#eat*lad".$newPass."a!er@kja&o";
          $hashed = hash('ripemd128', $salted);

          $sql = "UPDATE users SET password='$hashed' WHERE username='" . $username . "';";
          $result = $conn->query($sql);

          if(!$result){
            die($conn->error);
            $error = "ERROR: Password change failed!";
          }
          else{
            $success = "Password successfully changed!";
          }
        } else {
          $error = "ERROR: New password does not match!";
        }
      } else {
        $error = "ERROR: Current password does not match.";
      }
    }



  }
  ?>

  <form method="post" action="password_change.php" class="box">
    <p>Change Password</p>
    <input type="password" name="currentPassword" placeholder="Current Password">
    <input type="password" name="newPassword" placeholder="New Password">
    <input type="password" name="veripass" placeholder="Confirm Password">
    <input type="submit" name="submit" value="Create Account"
    style="font-size: 16px; padding: 5px 15px;">


  <br>
  <p style="color: red;">
    <?php if(isset($error)){echo $error;} ?>
  <br>
  </p>
  <p style="color: Green;">
    <?php if(isset($success)){echo $success;} ?>
  <br>
  </p>
  <p style="text-decoration: underline;">
    <a href="user_page.php">Home</a>
  </p>
  </form>

</body>
</html>
