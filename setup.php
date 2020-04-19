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
    userID   INT NOT NULL AUTO_INCREMENT,
    PRIMARY KEY(userID)
  )";
  $result = $connection->query($query);
  if (!$result)
    die($connection->error);

  $salt1    = "no#eat*lad";
  $salt2    = "a!er@kja&o";

  $username = 'admin';
  $password = 'admin';
  $admin = 1;
  $token = hash('ripemd128', "$salt1$password$salt2");

  add_user($connection, $admin, $username, $token);

  $username = 'BasicUser';
  $password = 'basic';
  $admin = 0;
  $token = hash('ripemd128', "$salt1$password$salt2");

  add_user($connection, $admin, $username, $token);

  function add_user($connection, $ad, $un, $pw)
  {
    $query  = "INSERT INTO users (admin, username, password)
      VALUES('$ad', '$un', '$pw')";

    $result = $connection->query($query);

    if (!$result)
      die($connection->error);
  }

  echo "Users database creation successful.";

  // Character Sheets
  $query = "CREATE TABLE sheets (
    username VARCHAR(32) NOT NULL,
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
    wounds INT,
    PRIMARY KEY (sheetID)
  )";
  $result = $connection->query($query);
  if (!$result)
    die($connection->error);

echo "Sheets database creation successful.";

$connection->close();
?>
