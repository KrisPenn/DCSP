<?php
  require_once 'login.php';
  $connection = new mysqli($hn, $un, $pw, $db);

  if ($connection->connect_error)
    die($connection->connect_error);

// USERS
  $query = "CREATE TABLE users (
    admin    BOOLEAN,
    username VARCHAR(32),
    password VARCHAR(32),
    userID   INT
  )";
  $result = $connection->query($query);
  if (!$result)
    die($connection->error);

  $salt1    = "no#eat*lad";
  $salt2    = "a!er@kja&o";

  $userID = 0;
  $username = 'admin';
  $password = 'admin';
  $admin = true;
  $token = hash('ripemd128', "$salt1$password$salt2");

  add_user($connection, $admin, $userID, $username, $token);

  $userID = 1;
  $username = 'BasicUser';
  $password = 'basic';
  $admin = false;
  $token = hash('ripemd128', "$salt1$password$salt2");

  add_user($connection, $admin, $userID, $username, $token);

  function add_user($connection, $ad, $uID, $un, $pw)
  {
    $query  = "INSERT INTO users (admin, userID, username, password)
      VALUES('$ad', '$uID', '$un', '$pw')";

    $result = $connection->query($query);

    if (!$result)
      die($connection->error);
  }

  echo "Users database creation successful.";

  // Character Sheets
  $query = "CREATE TABLE sheets (
    username NOT NULL VARCHAR(32),
    sheetID INT NOT NULL AUTO_INCREMENT,
    characterName VARCHAR(32),
    nationality VARCHAR(32),
    ballistics INT,
    weapons INT,
    strength INT,
    tough INT,
    agility INT,
    intel INT,
    percep INT,
    willpower INT,
    fellow INT,
    wounds INT
  )";
  $result = $connection->query($query);
  if (!$result)
    die($connection->error);

echo "Sheets database creation successful.";

$connection->close();
?>
