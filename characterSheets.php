<?php
  session_start();
  $username = $_SESSION["username"];

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
  <title>Character Sheets Page</title>
  <link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body style="background-color: #EFF6C1;">
  <?php

  $sql = "SELECT * FROM sheets WHERE username='" . $username . "';";
  $result = $conn->query($sql);

  if (mysqli_num_rows($result) == 0){
    echo 'No Character Sheets Generated.';
  }

  if (mysqli_num_rows($result) != 0){
    echo "Displaying Character Sheets for ", $username, ".<br><br>";
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
      echo "<table>
        <tr>
          <th>Sheet ID</th>
          <th>Character Name</th>
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
        </tr>";
      echo "<tr>
          <td>",$row["sheetID"],"</td>
          <td>",$row["characterName"],"</td>
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
          <td>",$row["wounds"],"</td>
        </tr>
      </table><br>";
    }
  }

  ?>
  <br><br><a href="user_page.php">Back</a>
</body>
</html>
