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

  <h1><span style="font-style:italic; margin-left: 10px; font-weight:bold; color: blue">
  Welcome, <?php echo $_SESSION["username"]; ?>!</span></h1><br><br>

<?php
  if ($_SESSION['admin'] == true){
    echo '<p style="font-style:italic; margin-left: 10px; color: blue; text-decoration: underline;"><a href="characterSheets.php">Character Sheets</a><br>';
    echo '<a href="generate.php">Generate Character Sheets</a><br>';
    echo '<a href="sheetSearch.php">Search Character Sheets</a></p>';
  }
  elseif ($_SESSION['admin'] == False){
    echo '<p style="font-style:italic; margin-left: 10px; color: blue; text-decoration: underline;"><a href="characterSheets.php">Character Sheets</a><br>';
    echo '<a href="generate.php">Generate Character Sheets</a><br>';
    echo '<a href="sheetSearch.php">Search Character Sheets</a></p>';
  }
  else {
    echo "Not logged in.";
  }

?>

</body>

</html>
