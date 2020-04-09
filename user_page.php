<?php
  session_start();
  require_once "login.php";

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
  <link rel="stylesheet" type="text/css" href="style.css"/>
</head>

<body style="background-color: #EFF6C1;">

<?php
  if ($_SESSION['admin'] == true){
    echo "Admin Page.<br><br>";
    echo '<a href="logout_page.php">Logout</a>';
  }
  elseif ($_SESSION['admin'] == False){
    echo "User Page.<br><br>";

    echo '<a href="characterSheets.php">Character Sheets</a><br>';
    echo '<a href="generate.php">Generate Character Sheets</a>';

    echo '<br><br><br><a href="logout_page.php">Logout</a>';
  }
  else {
    echo "Not logged in.";
  }

?>

</body>

</html>
