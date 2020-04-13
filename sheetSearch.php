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

  $error = '';
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

  <h1><span style="font-style:italic; font-weight:bold; color: blue; margin-left: 10px;">
  Search</span></h1><br>

  <form method="POST" action="sheetSearch.php" style='margin-left: 10px;'>
    Character Name:
    <input type="text" name="characterName" value="<?php if(isset($characterName)){echo $_SESSION["characterName"];}?>">
    <input type="submit" name="search" value="Search">
  </form>

  <?php

  if(isset($_POST["delete"])){
    $sheetID = $_POST["sheetID2"];

    if($_SESSION["admin"] == false){
      $sql = "DELETE FROM sheets WHERE username='" . $username . "' AND sheetID='" . $sheetID . "';";
      $result = $conn->query($sql);
    } else {
      $sql = "DELETE FROM sheets WHERE sheetID='" . $sheetID . "';";
      $result = $conn->query($sql);
    }

    if(!$result){
      die($conn->error);
      $error = "ERROR: Deletion failed.";
    }else{
      $success = "Deletion Successful.";
    }
  }


  if(isset($_POST["search"])){
    $characterName = $_POST["characterName"];
    $_SESSION["characterName"] = $characterName;
    if($_SESSION["admin"] == false){
      $sql = "SELECT * FROM sheets WHERE username='" . $username . "' AND characterName='" . $characterName . "';";
      $result = $conn->query($sql);
    } else {
      $sql = "SELECT * FROM sheets WHERE characterName='" . $characterName . "';";
      $result = $conn->query($sql);
    }

    if (mysqli_num_rows($result) == 0){
      $error = 'No Character Sheets with that name.';
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
            <th>Edit</th>
            <th>Delete</th>
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

          <?php
        echo "</table><br>";
      }
    }
  }


    ?>


  <br>
  <form method="POST" action="excelExport.php" style='margin-left: 10px;'>
    <input type="number" name="sheetID" value=0 style='width: 50px;'>
    <input type="submit" name="export" value="Export">
  </form>

  <br><br>
  <p1 style="color: red; margin-left: 10px;">
    <?php if(isset($error)){echo $error;} ?>
  <br>
  </p1>
  <p style="font-style:italic; color: blue; text-decoration: underline; margin-left: 10px;">
    <a href="user_page.php">Back</a>
  </p>


</body>
</html>
