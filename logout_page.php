<!DOCTYPE html>
<html lang="en">

<head>
  <title>Logged Out</title>
  <link rel="stylesheet" type="text/css" href="style.css"/>
</head>

<body>
  <!-- php to handle logging out -->
  <?php
  session_start();
  session_unset();
  session_destroy();
  header("Location: login_page.php");
  ?>
</body>

</html>
