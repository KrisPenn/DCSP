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
  <style>
    input {
      margin-bottom: 0.5em;
    }
    .error {
      color: #FF0000;
    }
  </style>
</head>

<body style="background-color: #EFF6C1;">

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

  <h1><span style="font-style:italic; font-weight:bold; color: blue">
  CHARACTER SHEET GENERATOR</span>!</h1>

  <p style="color: red">
    <?php if(isset($error)){echo $error;} ?>
  </p>

  <form method="post" action="login_page.php">
    <label>Username: </label>
    <input type="text" name="username" value="<?php if(isset($username)){echo $username;} ?>"> <br>
    <label>Password: </label>
    <input type="password" name="password" value="<?php if(isset($password)){echo $password;} ?>"> <br>
    <input type="submit" name = "login" value="Log in"><br>
  </form>

  <p style="font-style:italic">
    Placeholder for "create account" link
  </p>

</body>

</html>
