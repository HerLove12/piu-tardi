<?php 
session_start();
include("../sito/connessione.php");
?>
MIZZIGA
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sito</title>
</head>

<body>
  <?php

  
  $us = $_POST["username"];
  $pass = $_POST["password"];
  $sql = "SELECT * FROM utente WHERE Username = '$us'";

  $result = $conn->query($sql);
  if (is_bool($result)) {
    $_SESSION["errore"] = "ERRORE - RISULTATO BOOLEANO";
    header("Location: ./paginalogin.php");
  } else {
    if ($result->num_rows > 0) {
      $sql = "SELECT * FROM utente WHERE Username = '$us' AND Passwd = '$pass'";
      var_dump($sql);
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
        $_SESSION["utente"] = $us;
        header("Location: ./benvenuto.php");
      } else {
        $_SESSION["errore"] = "PASSWORD ERRATA";
        header("Location: ./paginalogin.php");
      }
    } else {
      $_SESSION["errore"] = "UTENTE NON ESISTENTE";
      header("Location: ./paginalogin.php");
    }
  }
  

  ?>
</body>

</html>