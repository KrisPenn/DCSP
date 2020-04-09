<?php
  session_start();
  $username = $_SESSION["username"];

  require_once "login.php";

  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error){
      die($conn->connect_error);
  }

  $username = $_SESSION["username"];
  $ballistics = rand(20,40);
  $weapons = rand(20,40);
  $strength = rand(20,40);
  $toughness = rand(20,40);
  $agility = rand(20,40);
  $intelligence = rand(20,40);
  $perception = rand(20,40);
  $willpower = rand(20,40);
  $fellowship = rand(20,40);
  $wounds = rand(9,13);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <style>
    table {
      font-family: arial, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }
    td, th {
      border: 1px solid;
      text-align: center;
      padding: 0.2em;
    }
    tr:nth-child(even) {
      background-color: #80CAE0;
    }
    tr:nth-child(odd) {
      background-color: #4073A7;
    }
  </style>
  <title>Character Sheet Generator</title>
  <link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body style="background-color: #EFF6C1;">


<form method="post" action="generate.php">
  Name: <input type="text" id="characterName" name="characterName"><br><br>

  Nationality:<br>
  <input type="radio" id="aesthian" name="nationality" value="aesthian">
  <label for="aesthian">Aesthian</label><br>

  <input type="radio" id="deltan" name="nationality" value="deltan">
  <label for="deltan">Deltan</label><br>

  <input type="radio" id="imperial" name="nationality" value="imperial">
  <label for="imperial">Imperial</label><br>

  <input type="radio" id="kintharian" name="nationality" value="kintharian">
  <label for="kintharian">Kintharian</label><br>

  <input type="radio" id="mercanan" name="nationality" value="mercanan">
  <label for="mercanan">Mercanan</label><br>

  <input type="radio" id="porlaqi" name="nationality" value="porlaqi">
  <label for="porlaqi">Porlaqi</label><br><br>

  <input type="submit" name = "generateStats" value="Generate Stats">



</form>

</body>
</html>
