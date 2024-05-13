<?php
session_start();
include("../sito/connessione.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sito</title>
</head>

<body>

  <p>Logout Effettuato</p>
  <p><a href="./paginalogin.php">LOGIN</a></p>

  <?php
  session_unset();
  ?>
    
</body>

</html>