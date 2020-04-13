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

  $success = '';
  $error = '';
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <title>Character Sheet Generator</title>
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
  /*
  aesthians get +5 to weapons, strength, agility, and -5 to fellowship
  deltans get +5 to strength, toughness, perception, and -5 to intelligence
  goths/imperials get +5 to ballistics, toughness, and willpower, and -5 to fellowship
  kintharians get +5 to agility, intelligence, perception, and -5 to toughness
  mercanans get +5 agility, willpower, and fellowship, -5 ballistics
  porlaqs get +5 to toughness and willpower
  */

  //Generating Stats
  if (isset($_POST["generateStats"]))
  {

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
    $_SESSION["ballistics"] = $ballistics;
    $_SESSION["weapons"] = $weapons;
    $_SESSION["strength"] = $strength;
    $_SESSION["toughness"] = $toughness;
    $_SESSION["agility"] = $agility;
    $_SESSION["intelligence"] = $intelligence;
    $_SESSION["perception"] = $perception;
    $_SESSION["willpower"] = $willpower;
    $_SESSION["fellowship"] = $fellowship;
    $_SESSION["wounds"] = $wounds;

    //Checking Name TODO: add sanitation
    if(isset($_POST["characterName"])){
      $characterName = $_POST["characterName"];
      $_SESSION["characterName"] = $characterName;
    }
    else{
      echo "Please enter a name!";
    }

    //Checking nationality value and adding bonuses
    if(isset($_POST["nationality"]))
    {
      $nationality = $_POST["nationality"];
      $_SESSION["nationality"] = $nationality;

      //Aesthian
      if ($nationality == "aesthian")
      {
        $weapons += 5;
        $_SESSION["weapons"] = $weapons;
        $strength += 5;
        $_SESSION["strength"] = $strength;
        $agility += 5;
        $_SESSION["agility"] = $agility;
        $fellowship -= 5;
        $_SESSION["fellowship"] = $fellowship;
      }
      //Deltan
      elseif ($nationality == "deltan")
      {
        $toughness += 5;
        $_SESSION["toughness"] = $toughness;
        $strength += 5;
        $_SESSION["strength"] = $strength;
        $perception += 5;
        $_SESSION["perception"] = $perception;
        $intelligence -= 5;
        $_SESSION["intelligence"] = $intelligence;
      }
      //Imperial
      elseif ($nationality == "imperial")
      {
        $ballistics += 5;
        $_SESSION["ballistics"] = $ballistics;
        $toughness += 5;
        $_SESSION["toughness"] = $toughness;
        $willpower += 5;
        $_SESSION["willpower"] = $willpower;
        $fellowship -= 5;
        $_SESSION["fellowship"] = $fellowship;
      }
      //Kintharian
      elseif ($nationality == "kintharian")
      {
        $agility += 5;
        $_SESSION["agility"] = $agility;
        $intelligence += 5;
        $_SESSION["intelligence"] = $intelligence;
        $perception += 5;
        $_SESSION["perception"] = $perception;
        $toughness -= 5;
        $_SESSION["toughness"] = $toughness;
      }
      //Mercanan
      elseif ($nationality == "mercanan")
      {
        $agility += 5;
        $_SESSION["agility"] = $agility;
        $willpower += 5;
        $_SESSION["willpower"] = $willpower;
        $fellowship += 5;
        $_SESSION["fellowship"] = $fellowship;
        $ballistics -= 5;
        $_SESSION["ballistics"] = $ballistics;
      }
      //Porlaqi
      else
      {
        $toughness += 5;
        $_SESSION["toughness"] = $toughness;
        $willpower += 5;
        $_SESSION["willpower"] = $willpower;
      }
    }
    else{
      echo "Please select a nationality!";
    }
  }

  //REROLL FUNCTIONALITY
  if(isset($_POST["submit"]))
  {

    //SETTING VARIABLES
    $ballistics = $_SESSION["ballistics"];
    $weapons = $_SESSION["weapons"];
    $strength = $_SESSION["strength"];
    $toughness = $_SESSION["toughness"];
    $agility = $_SESSION["agility"];
    $intelligence = $_SESSION["intelligence"];
    $perception = $_SESSION["perception"];
    $willpower = $_SESSION["willpower"];
    $fellowship = $_SESSION["fellowship"];
    $wounds = $_SESSION["wounds"];
    $nationality = $_SESSION["nationality"];
    $characterName = $_SESSION["characterName"];


    //BALLISTICS REROLL
    if($_POST["reroll"] == "ballistics")
    {
      $ballistics = rand(20,40);

      if ($nationality == "imperial")
      {
        $ballistics += 5;
      }

      elseif ($nationality == "mercanan")
      {
        $ballistics -= 5;
      }

      $_SESSION["ballistics"] = $ballistics;
    }

    //STRENGTH REROLL
    elseif($_POST["reroll"] == "strength")
    {
      $strength = rand(20,40);

      if ($nationality == "aesthian"){
        $strength += 5;
      }

      elseif ($nationality == "deltan")
      {
        $strength += 5;
      }

      $_SESSION["strength"] = $strength;
    }

    //WEAPONS REROLL
    elseif($_POST["reroll"] == "weapons")
    {
      $weapons = rand(20,40);
      if ($nationality == "aesthian")
      {
        $weapons += 5;
      }
      $_SESSION["weapons"] = $weapons;
    }

    //TOUGHNESS REROLL
    elseif($_POST["reroll"] == "toughness")
    {
      $toughness = rand(20,40);
      if ($nationality == "deltan"){
        $toughness += 5;
      }
      elseif ($nationality == "imperial"){
        $toughness += 5;
      }
      elseif ($nationality == "kintharian"){
        $toughness -= 5;
      }
      elseif ($nationality == "porlaqi"){
        $toughness += 5;
      }
      $_SESSION["toughness"] = $toughness;
    }

    //AGILITY REROLL
    elseif($_POST["reroll"] == "agility")
    {
      $agility = rand(20,40);

      if ($nationality == "aesthian"){
        $agility += 5;
      }
      elseif ($nationality == "kintharian"){
        $agility += 5;
      }
      elseif ($nationality == "mercanan"){
        $agility += 5;
      }
      $_SESSION["agility"] = $agility;
    }

    //INTELLIGENCE REROLL
    elseif($_POST["reroll"] == "intelligence")
    {
      $intelligence = rand(20,40);
      if ($nationality == "deltan"){
        $intelligence -= 5;
      }
      elseif ($nationality == "kintharian"){
        $intelligence += 5;
      }
      $_SESSION["intelligence"] = $intelligence;
    }

    //PERCEPTION REROLL
    elseif($_POST["reroll"] == "perception")
    {
      $perception = rand(20,40);
      if ($nationality == "deltan"){
        $perception += 5;
      }
      elseif ($nationality == "kintharian"){
        $perception += 5;
      }
      $_SESSION["perception"] = $perception;
    }

    //WILLPOWER REROLL
    elseif($_POST["reroll"] == "willpower")
    {
      $willpower = rand(20,40);
      if ($nationality == "imperial"){
        $willpower += 5;
      }
      elseif ($nationality == "mercanan"){
        $willpower += 5;
      }
      elseif($nationality == "porlaqi"){
        $willpower += 5;
      }
      $_SESSION["willpower"] = $willpower;
    }

    //FELLOWSHIP REROLL
    elseif($_POST["reroll"] == "fellowship")
    {
      $fellowship = rand(20,40);
      if ($nationality == "aesthian"){
        $fellowship -= 5;
      }
      elseif ($nationality == "imperial"){
        $fellowship -= 5;
      }
      elseif ($nationality == "mercanan"){
        $fellowship += 5;
      }
      $_SESSION["fellowship"] = $fellowship;
    }

    //WOUNDS REROLL
    elseif($_POST["reroll"] == "wounds")
    {
      $wounds = rand(9,13);
      $_SESSION["wounds"] = $wounds;
    }
  }

  if(isset($_POST["create"]))
  {
    $ballistics = $_SESSION["ballistics"];
    $weapons = $_SESSION["weapons"];
    $strength = $_SESSION["strength"];
    $toughness = $_SESSION["toughness"];
    $agility = $_SESSION["agility"];
    $intelligence = $_SESSION["intelligence"];
    $perception = $_SESSION["perception"];
    $willpower = $_SESSION["willpower"];
    $fellowship = $_SESSION["fellowship"];
    $wounds = $_SESSION["wounds"];
    $nationality = $_SESSION["nationality"];
    $characterName = $_SESSION["characterName"];

    $sql = "INSERT INTO sheets (username, characterName, nationality,
      ballistics, weapons, strength, tough, agility, intel, percep, willpower,
      fellow, wounds)
    VALUES ('$username', '$characterName', '$nationality', '$ballistics', '$weapons',
      '$strength', '$toughness', '$agility', '$intelligence', '$perception', '$willpower',
      '$fellowship', '$wounds')";

    $result = $conn->query($sql);

    if(!$result){
      die($conn->error);
      $error = "Creation Failed!";
    }
    else{
      $success = "Creation Successful!";
    }

  }

//FORM FOR PICKING NATIONALITY AND NAME
?>
<br>
<form method="post" action="generate.php" style="margin-left: 10px;">
  Name: <input type="text" id="characterName" name="characterName" value="<?php if(isset($_SESSION["characterName"])){echo $_SESSION["characterName"];} ?>"><br><br>

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

<?php
//GENERATE STATS TABLE
if (isset($_POST["generateStats"])){
  echo "<table>
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
      <td>",$characterName,"</td>
      <td>",$nationality,"</td>
      <td>",$ballistics,"</td>
      <td>",$weapons,"</td>
      <td>",$strength,"</td>
      <td>",$toughness,"</td>
      <td>",$agility,"</td>
      <td>",$intelligence,"</td>
      <td>",$perception,"</td>
      <td>",$willpower,"</td>
      <td>",$fellowship,"</td>
      <td>",$wounds,"</td>
    </tr>
  </table><br>
  ";

  echo '<form method="post" action="generate.php" style="margin-left: 10px;">
    Select a stat to reroll.  If you do not require a reroll, press "Create" below.
    <select id="reroll" name="reroll">
      <option value="none">No Reroll</option>
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
    <input type="submit" name="submit" value="Reroll"><br><br>
  </form><br><br>';
}

//TABLE FOR REROLLED STATS
if (isset($_POST["reroll"])){
  echo "<table style='margin-left:10px;'>
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
      <td>",$characterName,"</td>
      <td>",$nationality,"</td>
      <td>",$ballistics,"</td>
      <td>",$weapons,"</td>
      <td>",$strength,"</td>
      <td>",$toughness,"</td>
      <td>",$agility,"</td>
      <td>",$intelligence,"</td>
      <td>",$perception,"</td>
      <td>",$willpower,"</td>
      <td>",$fellowship,"</td>
      <td>",$wounds,"</td>
    </tr>
  </table><br>
  ";

  echo '<form method="post" action="generate.php" style="margin-left:10px;">
    When you are happy with this character press "Create" to create the sheet!<br>
    <input type="submit" name="create" value="Create">
  </form><br><br>';
  }
?>



<p style="color: red; margin-left: 10px;">
  <?php if(isset($error)){echo $error;} ?>
<br>
</p>
<p1 style="color: Green; margin-left: 10px;">
  <?php if(isset($success)){echo $success;} ?>
<br>
</p1>
<br>
<p2 style="font-style:italic; color: blue; text-decoration: underline; margin-left: 10px;">
  <a href="user_page.php">Back</a>
</p2>

</body>
</html>
