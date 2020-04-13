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

  if($_SESSION["admin"] == false){
    $sql = "DELETE FROM sheets WHERE username='" . $username . "' AND sheetID='" . $_GET['del_id'] . "';";
    $result = $conn->query($sql);
    header("Location: characterSheets.php");
  } else {
    $sql = "DELETE FROM sheets WHERE sheetID='" . $_GET['del_id'] . "';";
    $result = $conn->query($sql);
    header("Location: characterSheets.php");
  }
?>
