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
  <form style='margin-left: 10px;' method="post" action="edit.php?edit_id=<?php echo $editID; ?>">
    <table style='margin-left: 10px; margin-right: 50px;'>
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
      </tr>
      <tr>
        <td><?php echo $row["sheetID"]?></td>
        <td><input type="text" name="characterName" value='<?php echo $row["characterName"]?>'</td>
        <td><select name="nationality" value='<?php echo $row["nationality"]?>'>
          <option name="nationality" value="Aesthian" <?php if($row["nationality"] == "Aesthian"){echo "selected='true'";} ?>>Aesthian</option>
          <option name="nationality" value="Deltan" <?php if($row["nationality"] == "Deltan"){echo "selected='true'";} ?>>Deltan</option>
          <option name="nationality" value="Imperial" <?php if($row["nationality"] == "Imperial"){echo "selected='true'";} ?>>Imperial</option>
          <option name="nationality" value="Kintharian" <?php if($row["nationality"] == "Kintharian"){echo "selected='true'";} ?>>Kintharian</option>
          <option name="nationality" value="Mercanan" <?php if($row["nationality"] == "Mercanan"){echo "selected='true'";} ?>>Mercanan</option>
          <option name="nationality" value="Porlaqi" <?php if($row["nationality"] == "Porlaqi"){echo "selected='true'";} ?>>Porlaqi</option>
        </select></td>
        <td><input type="number" style="width:50px;" name="ballistics" value='<?php echo $row["ballistics"]?>'</td>
        <td><input type="number" style="width:50px;" name="weapons" value='<?php echo $row["weapons"]?>'</td>
        <td><input type="number" style="width:50px;" name="strength" value='<?php echo $row["strength"]?>'</td>
        <td><input type="number" style="width:50px;" name="tough" value='<?php echo $row["tough"]?>'</td>
        <td><input type="number" style="width:50px;" name="agility" value='<?php echo $row["agility"]?>'</td>
        <td><input type="number" style="width:50px;" name="intel" value='<?php echo $row["intel"]?>'</td>
        <td><input type="number" style="width:50px;" name="percep" value='<?php echo $row["percep"]?>'</td>
        <td><input type="number" style="width:50px;" name="willpower" value='<?php echo $row["willpower"]?>'</td>
        <td><input type="number" style="width:50px;" name="fellow" value='<?php echo $row["fellow"]?>'</td>
        <td><input type="number" style="width:50px;" name="wounds" value='<?php echo $row["wounds"]?>'</td>
      </tr>
    </table>
  <?php } ?>

    <br>

    <input type='submit' name='save' value='Save'>
    <input type='submit' name='cancel' value='Cancel'>
  </form>
  <br>
  <p1 style="color: Green; margin-left: 10px;">
    <?php if(isset($success)){echo $success;} ?>
  </p1><br>
  <p style="font-style:italic; color: blue; text-decoration: underline;">
    <a href="user_page.php">Home</a>
  </p>

</body>
</html>
