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
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Log in to Website</title>
  <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Montserrat:wght@600&family=Righteous&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Righteous&display=swap" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="style.css"/>
  <style>
    input {
      margin-bottom: 0.5em;
    }
  </style>
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

  <!-- Put your PHP to log someone in here... Includes forwarding, storing sessions, etc. -->
  <?php
  if (isset($_POST['login'])){

      $username = $_POST['username'];
      $password = $_POST['password'];
      $salted = "no#eat*lad".$password."a!er@kja&o";
      $hashed = hash('ripemd128', $salted);

      if (empty($username) || empty($password)) {
        $error = "Cannot leave fields blank.";
      }

      else{
        $sql = "SELECT * FROM users WHERE username='" . $username . "';";
        $result = $conn->query($sql);

        if (mysqli_num_rows($result) == 0){
          $error = "Invalid username or password.";
        }

        if (mysqli_num_rows($result) != 0) {
          while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            if ($hashed != $row['password']) {
              $error = "Invalid username or password.";
            }

            elseif ($hashed == $row['password']){
              $_SESSION['username'] = $row['username'];
              $_SESSION['admin'] = $row['admin'];

              if ($row['admin'] == true){
                header("Location: user_page.php");
              } else {
                header("Location: user_page.php");
              }
            } else {
            $error = "Invalid username or password.";
          }
        }
      }
    }
  }
  ?>

  <p1 style="color: red">
    <?php if(isset($error)){echo $error;} ?>
  </p1>

  <form class="box" method="post" action="login_page.php">
    <h1>Login</h1>
    <input type="text" name="username" placeholder="Username" value="<?php if(isset($username)){echo $username;}?>"> <br>
    <input type="password" name="password" placeholder="Password" value="<?php if(isset($password)){echo $password;}?>"> <br>
    <input type="submit" name = "login" value="Log in">
    <p1 style="color: red">
      <?php if(isset($error)){echo $error;} ?>
    <br>
    </p1>
    <p>
      <a href="create_account.php">Create Account</a>
    </p>
  </form>

</body>

</html>
