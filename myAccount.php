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
  <title>User Page</title>
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

  <h1><span style="font-style:italic; font-weight:bold; color: blue">
  <?php echo $_SESSION["username"]; ?>'s Account</span></h1><br><br>

  <table style="width:70%; height:150px">
    <tr>
      <th>Username</th>
      <td><?php echo $_SESSION["username"];?></td>
    </tr>
    <tr>
      <th>Password</th>
      <td>
        <button id="passChangeButton" class="submit-button"
        style="font-style:italic; color: blue; text-decoration: underline;">
        Reset Password</button>

        <script type="text/javascript">
        document.getElementById("passChangeButton").onclick = function () {
            location.href = "password_change.php";
        };
        </script>
      </td>
    </tr>
  </table>

  <br><br>

  <p style="font-style:italic; color: blue; text-decoration: underline;">
    <a href="user_page.php">Home</a>
  </p>
  <br>
  <p style="font-style:italic; color: blue; text-decoration: underline;">
    <a href="account_deletion.php">Delete Account</a>
  </p>




</body>
</html>
