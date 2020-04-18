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
  $tick = true;
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <title>Delete Account</title>
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
    $password = $_POST["password"];
    /*$salted = "no#eat*lad".."a!er@kja&o";
    $hashed = hash('ripemd128', $salted);*/

    $sql = "SELECT * FROM users WHERE username='" . $username . "';";
    $result = $conn->query($sql);

    if (mysqli_num_rows($result) == 0){
      $error = "ERROR: You are not logged in or your account does not exist.";
    } else {
      $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
      $salted = "no#eat*lad".$password."a!er@kja&o";
      $hashed = hash('ripemd128', $salted);

      if($hashed == $row['password']){
        $sql = "DELETE FROM users WHERE username='" . $username . "';";
        $result = $conn->query($sql);

        $sql2 = "DELETE FROM sheets WHERE username='" . $username . "';";
        $result2 = $conn->query($sql2);

        if(!$result){
          die($conn->error);
          $error = "ERROR: Account Deletion failed!";
        } else {
          $success = "Account successfully deleted.";
          $tick = false;
        }

        if(!$result2){
          die($conn->error);
          $error = "ERROR: Character Sheet Deletion failed!";
        } else {
          $success .= " Character Sheets successfully deleted.";
          $tick = false;
          session_unset();
          session_destroy();
        }
      } else {
        $error = "ERROR: Password does not match!";
      }
    }
  }
  ?>

  <form method="post" action="account_deletion.php" class="box">
    <h1>Delete Account</h1>
    <input type="password" name="password" placeholder="Password">
    <input type="submit" name="submit" value="Delete"
    style="font-size: 16px; padding: 5px 15px;">
    <p style="color: red; text-transform: none">
      <?php if(isset($error)){echo $error;} ?>
    </p>
    <p style="color: Green; text-transform: none">
      <?php if(isset($success)){echo $success;} ?>
    </p>
    <?php
    if ($tick == true){
      echo '<p style="text-decoration: underline;">
        <a href="myAccount.php">Back</a>
      </p>';
    } else {
      echo '<p style="text-decoration: underline;">
        <a href="logout_page.php">Back to Login</a>
      </p>';
    }
    ?>
  </form>

</body>
</html>
