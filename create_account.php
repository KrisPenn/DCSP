<?php
  session_start();
  require_once "login.php";

  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error){
      die($conn->connect_error);
  }
  $success = '';
  $error = '';
  $salt1 = "no#eat*lad";
  $salt2 = "a!er@kja&o";
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <title>Table Template</title>
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
  if (isset($_POST['submit'])){

    $username = $_POST['username'];
    $pass = $_POST['pass'];
    $veripass = $_POST['veripass'];
    $admin = 0;

    if (empty($username) || empty($pass) || empty($veripass))
    {
      $error = "ERROR: Cannot leave fields blank.";
    }else{
      if(preg_match("/^[a-zA-Z0-9]*$/", $username)){
        if($pass == $veripass){

          $salted = "no#eat*lad".$pass."a!er@kja&o";
          $hashed = hash('ripemd128', $salted);

          $sql = "SELECT * FROM users WHERE username='" . $username . "';";
          $result = $conn->query($sql);

          if (mysqli_num_rows($result) == 0){
            $sql = "INSERT INTO users (admin, username, password)
              VALUES('$admin', '$username', '$hashed')";
            $result = $conn->query($sql);

            if(!$result){
              die($conn->error);
              $error = "ERROR: Creation Failed!";
            }
            else{
              $success = "Account created successfully! Please go back to Login.";
            }

          } else {
            $error = "ERROR: Username already in use.";
          }
        }
      }else{
        $error="ERROR: Username may only contain letters and numbers.";
      }
    }
  }
  ?>


  <form class="box" method="post" action="create_account.php">
    <h1>Create Account</h1>
    <input type="text" name="username" placeholder="Username" value="<?php if(isset($username)){echo $username;} ?>">
    <input type="password" name="pass" placeholder="Password" value="<?php if(isset($pass)){echo $pass;} ?>">
    <input type="password" name="veripass" placeholder="Confirm Password">
    <input type="submit" name="submit" value="Create Account" style="padding: 5px 15px;">
    <p style="color: red;">
      <?php if(isset($error)){echo $error;} ?>
    </p>
    <p style="color: Green;">
      <?php if(isset($success)){echo $success;} ?>
    </p>
    <p>
      <a href="login_page.php">Back to Login</a>
    </p>
  </form>


</body>
</html>
