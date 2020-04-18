<?php
  session_start();
  require_once "login.php";
  if(isset($_SESSION["username"])){
    $username = $_SESSION["username"];
  } else {
    header("Location: login_page.php");
  }


  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error){
      die($conn->connect_error);
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>My Account</title>
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

  <form class="box">
    <p style="text-align: left;">
      Username: <?php echo $_SESSION["username"];?>
      <br><br>
      Password: <a style="text-decoration: underline; margin: 0px" href="password_change.php">Change Password</a>

      <br><br>
    </p>
    <p style="text-decoration: underline;">
      <a href="user_page.php">Home</a>
      <br><br>
      <a href="account_deletion.php">Delete Account</a>
    </p>
  </form>




</body>
</html>
