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

  <h1><span style="font-style:italic; font-weight:bold; color: blue">
  Welcome, <?php echo $_SESSION["username"]; ?>!</span></h1><br><br>

<?php
  if ($_SESSION['admin'] == true){
    echo "Admin Page.<br><br>";
  }
  elseif ($_SESSION['admin'] == False){
    echo '<p style="font-style:italic; color: blue; text-decoration: underline;"><a href="characterSheets.php">Character Sheets</a><br>';
    echo '<a href="generate.php">Generate Character Sheets</a><br>';
    echo '<a href="sheetSearch.php">Search Character Sheets</a></p>';
  }
  else {
    echo "Not logged in.";
  }

?>

</body>

</html>
