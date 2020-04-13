<?php
  session_start();
  if(isset($_SESSION["username"])){
    $username = $_SESSION["username"];
  } else {
    header("Location: login_page.php");
  }


  require_once "login.php";

  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error){
      die($conn->connect_error);
  }

  $error='';
  $success='';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Character Sheets Page</title>
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

  $username = $_SESSION["username"];


  if($_SESSION["admin"] == false){
    $sql = "SELECT * FROM sheets WHERE username='" . $username . "';";
    $result = $conn->query($sql);
  } else {
    $sql = "SELECT * FROM sheets";
    $result = $conn->query($sql);
  }

  if (mysqli_num_rows($result) == 0){
    $error = "No Character Sheets Generated for ". $username . ".";
  }

  if (mysqli_num_rows($result) != 0){
    echo "<p3 style='color: blue; margin-left: 10px;'>Displaying Character Sheets for ", $username, ".</p3><br><br>";
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
      echo "<table style='margin-left: 10px; margin-right: 50px;'>
        <tr>
          <th>Sheet ID</th>";
          if($_SESSION["admin"] == true){
            echo "<th>Username</th>";
          }
          echo "<th>Character Name</th>
          <th>Nationality</th>
          <th>Ballistics</th>
          <th>Weapons</th>
          <th>Strength</th>
          <th>Toughness</th>
          <th>Agility</th>
          <th>Intelligence</th>
          <th>Perception</th>
          <th>Willpower</th>
          <th>Fellowship</th>
          <th>Wounds</th>
          <th>Export</th>
          <th>Delete</th>
          <th>Edit</th>
        </tr>";
      echo "<tr>
          <td>",$row["sheetID"],"</td>";
          if($_SESSION["admin"] == true){
            echo "<td>",$row["username"],"</td>";
          }
          echo "<td>",$row["characterName"],"</td>
          <td>",$row["nationality"],"</td>
          <td>",$row["ballistics"],"</td>
          <td>",$row["weapons"],"</td>
          <td>",$row["strength"],"</td>
          <td>",$row["tough"],"</td>
          <td>",$row["agility"],"</td>
          <td>",$row["intel"],"</td>
          <td>",$row["percep"],"</td>
          <td>",$row["willpower"],"</td>
          <td>",$row["fellow"],"</td>
          <td>",$row["wounds"],"</td>";
          ?>
          <td><input type="button" onclick="exportme(<?php echo $row['sheetID']; ?>)" name="export" value="Export"></td>
          <td><input type="button" onclick="deleteme(<?php echo $row['sheetID']; ?>)" name="Delete" value="Delete"></td>
          <td><a href="edit.php?edit_id=<?php echo $row['sheetID']; ?>" alt="edit" style="color: blue; margin-left: 0px;">Edit</a></td>
        </tr>
        <!-- javascript -->
        <script language="javascript">
        function deleteme(id)
        {
          if(confirm("Are you sure you want to delete this?")){
            window.location.href='delete.php?del_id=' +id+'';
            return true;
          }
        }
        </script>

        <script language="javascript">
        function exportme(id)
        {
          if(confirm("Export for Excel?")){
            window.location.href='excelExport.php?exp_id=' +id+'';
            return true;
          }
        }
        </script>

        <script language="javascript">
        function editme(id)
        {
        }
        </script>

        <?php
      echo "</table><br>";
    }
  }
  ?>

  <p1 style="color: red; margin-left: 10px;">
    <?php if(isset($error)){echo $error;} ?>
  </p1><br><br>

  <p style="font-style:italic; color: blue; text-decoration: underline; margin-left: 10px;">
    <a href="user_page.php">Back</a>
  </p>
</body>
</html>
