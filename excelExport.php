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

  $sql = "SELECT * FROM sheets WHERE  sheetID='" . $_GET['exp_id'] . "';";
  $result = mysqli_query($conn, $sql);



  $output = '';
  $output.= '
    <table class="table" bordered="1">
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
  ';
  while($row = mysqli_fetch_array($result))
  {
    $output .= '
        <tr>
          <td>'.$row["sheetID"].'</td>
          <td>'.$row["characterName"].'</td>
          <td>'.$row["nationality"].'</td>
          <td>'.$row["ballistics"].'</td>
          <td>'.$row["weapons"].'</td>
          <td>'.$row["strength"].'</td>
          <td>'.$row["tough"].'</td>
          <td>'.$row["agility"].'</td>
          <td>'.$row["intel"].'</td>
          <td>'.$row["percep"].'</td>
          <td>'.$row["willpower"].'</td>
          <td>'.$row["fellow"].'</td>
          <td>'.$row["wounds"].'</td>
    ';
  }
  $output .= '</table>';
  header("Content-Type: application/xls");
  header("Content-Disposition: attachment; filename=character_sheet.xls");
  echo $output;
?>
