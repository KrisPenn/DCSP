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
  <link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>
  <div class="header" style="text-align: left;">
    <a href="#default">CharGen</a>
    <img src="20_sided.png" alt="20 sided die" style="width:100px;height:100px; vertical-align: middle;" >
  </div>

  <?php
  if (isset($_POST['submit'])){

    $username = $_POST['username'];
    $pass = $_POST['pass'];
    $veripass = $_POST['veripass'];
    $admin = false;

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


  <h1><span style="font-style:italic; font-weight:bold; color: blue; margin-left: 10px;">
  Create Account</span></h1><br>

  <form method="post" action="create_account.php" style="margin-left: 10px;">
    <br>Username:
    <input type="text" name="username" value="<?php if(isset($username)){echo $username;} ?>">
    <br><br>Password:
    <input type="password" name="pass" value="<?php if(isset($pass)){echo $pass;} ?>">
    <br><br>Verify Password:
    <input type="password" name="veripass">
    <br><br>
    <input type="submit" name="submit" value="Create Account"
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
  <p2 style="font-style:italic; color: blue; text-decoration: underline; margin-left: 10px;">
    <a href="login_page.php">Back to Login</a>
  </p2>

</body>
</html>
