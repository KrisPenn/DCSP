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
    userID   VARCHAR(32)
  )";
  $result = $connection->query($query);
  if (!$result)
    die($connection->error);

  $salt1    = "no#eat*lad";
  $salt2    = "a!er@kja&o";

  $userID = 'Admin';
  $username = 'admin';
  $password = 'admin';
  $admin = true;
  $token = hash('ripemd128', "$salt1$password$salt2");

  add_user($connection, $admin, $userID, $username, $token);

  $userID = 'BasicUser';
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

  $connection->close();

  echo "Users database creation successful.";

  // Character Sheets
?>
