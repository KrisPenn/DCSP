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
</head>
<body style="background-color: #EFF6C1;">

  <?php
  /*
  aesthians get +5 to weapons, strength, agility, and -5 to fellowship
  deltans get +5 to strength, toughness, perception, and -5 to intelligence
  goths/imperials get +5 to ballistics, toughness, and willpower, and -5 to fellowship
  kintharians get +5 to agility, intelligence, perception, and -5 to toughness
  mercanans get +5 agility, willpower, and fellowship, -5 ballistics
  porlaqs get +5 to toughness and willpower
  */

  if ($_POST["generateStats"]){

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

    if(isset($_POST["characterName"])){
      $characterName = $_POST["characterName"];
    }
    else{
      echo "Please enter a name!";
    }

    if(isset($_POST["nationality"])){
      $nationality = $_POST["nationality"];

      if ($nationality == "aesthian"){
        $weapons += 5;
        $strength += 5;
        $agility += 5;
        $fellowship -= 5;
      }
      elseif ($nationality == "deltan"){
        $toughness += 5;
        $strength += 5;
        $perception += 5;
        $intelligence -= 5;
      }
      elseif ($nationality == "imperial"){
        $ballistics += 5;
        $toughness += 5;
        $willpower += 5;
        $fellowship -= 5;
      }
      elseif ($nationality == "kintharian"){
        $agility += 5;
        $intelligence += 5;
        $perception += 5;
        $toughness -= 5;
      }
      elseif ($nationality == "mercanan"){
        $agility += 5;
        $willpower += 5;
        $fellowship += 5;
        $ballistics -= 5;
      }
      else{//porlaqi
        $toughness += 5;
        $willpower += 5;
      }
    }
    else{
      echo "Please select a nationality!";
    }
  }
?>

<form method="post" action="generate.php">
  Name: <input type="text" id="characterName" name="characterName" value="<?php if(isset($characterName)){echo $characterName;} ?>"><br><br>

  Nationality:<br>
  <input type="radio" id="aesthian" name="nationality" value="Aesthian" <?php if(isset($nationality) && $nationality == "Aesthian"){echo 'checked="True"';} elseif(!isset($nationality)){echo 'checked="True"';} ?>>
  <label for="aesthian"> Aesthian &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [+5 to weapons, strength, agility, and -5 to fellowship]</label><br>

  <input type="radio" id="deltan" name="nationality" value="Deltan" <?php if(isset($nationality) && $nationality == "Deltan"){echo 'checked="True"';}?>>
  <label for="deltan">    Deltan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [+5 to strength, toughness, perception, and -5 to intelligence]</label><br>

  <input type="radio" id="imperial" name="nationality" value="Imperial" <?php if(isset($nationality) && $nationality == "Imperial"){echo 'checked="True"';}?>>
  <label for="imperial">  Imperial &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [+5 to ballistics, toughness, and willpower, and -5 to fellowship]</label><br>

  <input type="radio" id="kintharian" name="nationality" value="Kintharian" <?php if(isset($nationality) && $nationality == "Kintharian"){echo 'checked="True"';}?>>
  <label for="kintharian">Kintharian &nbsp;&nbsp; [+5 to agility, intelligence, perception, and -5 to toughness]</label><br>

  <input type="radio" id="mercanan" name="nationality" value="Mercanan" <?php if(isset($nationality) && $nationality == "Mercanan"){echo 'checked="True"';}?>>
  <label for="mercanan">  Mercanan &nbsp;&nbsp;&nbsp; [+5 agility, willpower, fellowship, and -5 ballistics]</label><br>

  <input type="radio" id="porlaqi" name="nationality" value="Porlaqi" <?php if(isset($nationality) && $nationality == "Porlaqi"){echo 'checked="True"';}?>>
  <label for="porlaqi">   Porlaqi &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [+5 to toughness and willpower]</label><br><br>

  <input type="submit" name="generateStats" value="Generate Stats">

  <br><br>
</form>

<table>
  <tr>
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
    <td><?php echo $characterName ?></td>
    <td><?php echo $nationality ?></td>
    <td><?php echo $ballistics ?></td>
    <td><?php echo $weapons ?></td>
    <td><?php echo $strength ?></td>
    <td><?php echo $toughness ?></td>
    <td><?php echo $agility ?></td>
    <td><?php echo $intelligence ?></td>
    <td><?php echo $perception ?></td>
    <td><?php echo $willpower ?></td>
    <td><?php echo $fellowship ?></td>
    <td><?php echo $wounds ?></td>
  </tr>
</table><br>


<form method="post" action="generate.php">
  Select a stat to reroll.  If you do not require a reroll, press "Create" below.
  <select id="reroll" name="reroll">
    <option value="ballistics">Ballistics</option>
    <option value="weapons">Weapons</option>
    <option value="strength">Strength</option>
    <option value="toughness">Toughness</option>
    <option value="agility">Agility</option>
    <option value="intelligence">Intelligence</option>
    <option value="perception">Perception</option>
    <option value="willpower">Willpower</option>
    <option value="fellowship">Fellowship</option>
    <option value="wounds">Wounds</option>
  </select><br>
  <input type='submit' name='reroll' value='Reroll'><br><br>
  When you are happy with this character press "Create" to create the sheet!<br>
  <input type="submit" name="create" value="Create">
</form><br><br>





<br><br><a href="user_page.php">Back</a>

</body>
</html>
