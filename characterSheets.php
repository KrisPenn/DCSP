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

  <form class="box" style='width: 1000px;'>
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
      echo "<h1 style='font-size: 30px'>", $username, "'s Character Sheets.</h1><br>";
      while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        echo "<table class='center'>
            <tr>
              <th>Sheet ID</th>
              <td>",$row["sheetID"],"</td>
              <th>Username</th>
              <td>",$row["username"],"</td>
            </tr>
            <tr>
              <th>Character Name</th>
              <td>",$row["characterName"],"</td>
              <th>Nationality</th>
              <td>",$row["nationality"],"</td>
            </tr>
            <tr>
              <th>Ballistics</th>
              <td>",$row["ballistics"],"</td>
              <th>Weapons</th>
              <td>",$row["weapons"],"</td>
            </tr>
            <tr>
              <th>Strength</th>
              <td>",$row["strength"],"</td>
              <th>Toughness</th>
              <td>",$row["tough"],"</td>
            </tr>
            <tr>
              <th>Agility</th>
              <td>",$row["agility"],"</td>
              <th>Intelligence</th>
              <td>",$row["intel"],"</td>
            </tr>
            <tr>
              <th>Perception</th>
              <td>",$row["percep"],"</td>
              <th>Willpower</th>
              <td>",$row["willpower"],"</td>
            </tr>
            <tr>
              <th>Fellowship</th>
              <td>",$row["fellow"],"</td>
              <th>Wounds</th>
              <td>",$row["wounds"],"</td>
            </tr>
            </table>
            <table class='center'>
            <tr>
              <th>Export</th>
              <th>Delete</th>
              <th>Edit</th>
            </tr>
            <tr>";
            ?>
              <td><input type='button' onclick='exportme(<?php echo $row["sheetID"]; ?>)' name='export' value='Export'></td>
              <td><input type='button' onclick='deleteme(<?php echo $row["sheetID"]; ?>)' name='Delete' value='Delete'></td>
              <td><a href='edit.php?edit_id=<?php echo $row["sheetID"]; ?>' alt='edit' style='color: blue; margin-left: 0px;'>Edit</a></td>
            </tr>
          </table>
          <div style='border-bottom: 1px solid #eee;'><br></div>
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

    <p style="text-decoration: underline;">
      <a href="user_page.php">Back</a>
    </p>
</form>
</body>
</html>
