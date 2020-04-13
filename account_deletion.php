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
  <link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body style="background-color: #EFF6C1;">
  <div class="header" style="text-align: left;">
    <a href="#default">CharGen</a>
    <img src="20_sided.png" alt="20 sided die" style="width:100px;height:100px; vertical-align: middle;" >
  <div class="header-right">
    <button id="myAccountButton" class="submit-button">My Account</button>
    <script type="text/javascript">
    document.getElementById("myAccountButton").onclick = function () {
        location.href = "myAccount.php";
    };
    </script>
    <button id="logOutButton">Log Out</button>
    <script type="text/javascript">
    document.getElementById("logOutButton").onclick = function () {
        location.href = "logout_page.php";
    };
  </script>
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

  <h1><span style="font-style:italic; font-weight:bold; color: blue; margin-left: 10px;">
  Delete Account</span></h1><br>

  <form method="post" action="account_deletion.php" style="margin-left: 10px;">
    <br>Password:
    <input type="password" name="password">
    <br><br>
    <input type="submit" name="submit" value="Delete Account"
    style="font-size: 16px; padding: 5px 15px;">
  </form>

  <br>
  <p style="color: red; margin-left: 10px;">
    <?php if(isset($error)){echo $error;} ?>
  <br>
  </p>
  <p1 style="color: Green; margin-left: 10px;">
    <?php if(isset($success)){echo $success;} ?>
  <br>
  </p1>
  <?php
  if ($tick == true){
    echo '<p2 style="font-style:italic; color: blue; text-decoration: underline; margin-left: 10px;">
      <a href="user_page.php">Home</a>
    </p2>';
  } else {
    echo '<p2 style="font-style:italic; color: blue; text-decoration: underline; margin-left: 10px;">
      <a href="logout_page.php">Back to Login</a>
    </p2>';
  }
  ?>

</body>
</html>
