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



<?php
  if ($_SESSION['admin'] == true){?>
  <div id="home">
    <h1>
    Welcome, <?php echo $_SESSION["username"]; ?>!
    </h1>
    <p>
      <a href="characterSheets.php">Character Sheets</a><br>
      <a href="generate.php">Generate Character Sheets</a><br>
      <a href="sheetSearch.php">Search Character Sheets</a>
    </p>
  </div>
  <?php
  }
  elseif ($_SESSION['admin'] == False){?>
    <div class="menu">
      <h1>
      Welcome, <?php echo $_SESSION["username"]; ?>!
      </h1>
      <p>
        <a href="characterSheets.php">Character Sheets</a><br>
        <a href="generate.php">Generate Character Sheets</a><br>
        <a href="sheetSearch.php">Search Character Sheets</a>
      </p>
    </div>
  <?php
  }

?>

</body>

</html>
