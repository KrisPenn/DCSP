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

  $error = '';
  $success = '';
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
  $editID = $_GET['edit_id'];

  if(isset($_POST['save'])){
    $ballistics = $_POST["ballistics"];
    $weapons = $_POST["weapons"];
    $strength = $_POST["strength"];
    $tough = $_POST["tough"];
    $agility = $_POST["agility"];
    $intel = $_POST["intel"];
    $percep = $_POST["percep"];
    $willpower = $_POST["willpower"];
    $fellow = $_POST["fellow"];
    $wounds = $_POST["wounds"];
    $nationality = $_POST["nationality"];
    $characterName = $_POST["characterName"];

    $sql = "UPDATE sheets SET characterName='" . $characterName . "',
    nationality='" . $nationality . "',
    ballistics='" . $ballistics . "',
    weapons='" . $weapons . "',
    strength='" . $strength . "',
    tough='" . $tough . "',
    agility='" . $agility . "',
    intel='" . $intel . "',
    percep='" . $percep . "',
    willpower='" . $willpower . "',
    fellow='" . $fellow . "',
    wounds='" . $wounds . "'
    WHERE sheetID='" . $editID . "'
    ;";
    $result = mysqli_query($conn, $sql);

    if(!$result){
      die($conn->error);
      $error="ERROR: Update failed.";
    } else {
      $success = "Saved.";
    }
  } elseif(isset($_POST["cancel"])) {
    header('Location: characterSheets.php');
  }


  $sql = "SELECT * FROM sheets WHERE sheetID='" . $editID . "';";
  $result = mysqli_query($conn, $sql);

  while($row = mysqli_fetch_array($result)){
  ?>
  <form class="box" style="width: 600px" method="post" action="edit.php?edit_id=<?php echo $editID; ?>">
    <table class="center">
      <tr>
        <th>Character Name</th>
        <td><input style="margin: 2px auto; padding: 2px 2px; color: black; width: 75px; border-radius: 0px; border: 1px solid grey; background: white;" type="text" name="characterName" value='<?php echo $row["characterName"]?>'></td>
        <th>Nationality</th>
        <td><select name="nationality" value='<?php echo $row["nationality"]?>'>
          <option name="nationality" value="Aesthian" <?php if($row["nationality"] == "Aesthian"){echo "selected='true'";} ?>>Aesthian</option>
          <option name="nationality" value="Deltan" <?php if($row["nationality"] == "Deltan"){echo "selected='true'";} ?>>Deltan</option>
          <option name="nationality" value="Imperial" <?php if($row["nationality"] == "Imperial"){echo "selected='true'";} ?>>Imperial</option>
          <option name="nationality" value="Kintharian" <?php if($row["nationality"] == "Kintharian"){echo "selected='true'";} ?>>Kintharian</option>
          <option name="nationality" value="Mercanan" <?php if($row["nationality"] == "Mercanan"){echo "selected='true'";} ?>>Mercanan</option>
          <option name="nationality" value="Porlaqi" <?php if($row["nationality"] == "Porlaqi"){echo "selected='true'";} ?>>Porlaqi</option>
        </select></td>
      </tr>
      <tr>
        <th>Ballistics</th>
        <td><input type="number" style="width:50px;" name="ballistics" value='<?php echo $row["ballistics"]?>'></td>
        <th>Weapons</th>
        <td><input type="number" style="width:50px;" name="weapons" value='<?php echo $row["weapons"]?>'></td>
      </tr>
      <tr>
        <th>Strength</th>
        <td><input type="number" style="width:50px;" name="strength" value='<?php echo $row["strength"]?>'></td>
        <th>Toughness</th>
        <td><input type="number" style="width:50px;" name="tough" value='<?php echo $row["tough"]?>'></td>
      </tr>
      <tr>
        <th>Agility</th>
        <td><input type="number" style="width:50px;" name="agility" value='<?php echo $row["agility"]?>'></td>
        <th>Intelligence</th>
        <td><input type="number" style="width:50px;" name="intel" value='<?php echo $row["intel"]?>'></td>
      </tr>
      <tr>
        <th>Perception</th>
        <td><input type="number" style="width:50px;" name="percep" value='<?php echo $row["percep"]?>'></td>
        <th>Willpower</th>
        <td><input type="number" style="width:50px;" name="willpower" value='<?php echo $row["willpower"]?>'></td>
      </tr>
      <tr>
        <th>Fellowship</th>
        <td><input type="number" style="width:50px;" name="fellow" value='<?php echo $row["fellow"]?>'></td>
        <th>Wounds</th>
        <td><input type="number" style="width:50px;" name="wounds" value='<?php echo $row["wounds"]?>'></td>
      </tr>
      <tr>





      </tr>
    </table>
    <?php } ?>

      <br>

      <input type='submit' name='save' value='Save'>
      <input type='submit' name='cancel' value='Cancel'>
    <br>
    <p style="color: Green;">
      <?php if(isset($success)){echo $success;} ?>
    </p>
    <p style="text-decoration: underline;">
      <a href="user_page.php">Back</a>
    </p>
  </form>

</body>
</html>
