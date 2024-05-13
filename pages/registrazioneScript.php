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
  <?php

  $us = $_POST["username"];
  $pass = $_POST["password"];
  $n = $_POST["nome"];
  $c = $_POST["cognome"];
  $e = $_POST["email"];
  $sql = "SELECT * FROM utente WHERE Username = '$us'";

  $result = $conn->query($sql);
  if (is_bool($result)) {
    $_SESSION["errore"] = "ERRORE - RISULTATO BOOLEANO";
    header("Location: ./paginaregistrazione.php");
  } else {
    if ($result->num_rows == 0) {
      $sql = "INSERT INTO utente( Username, Passwd, Nome, Cognome, Email) VALUES ( '$us', '$pass', '$n', '$c', '$e')";
      $conn->query($sql);
      if ($conn->affected_rows > 0) {
        $_SESSION["utente"] = $us;
        header("Location: ./benvenuto.php");
      } else {
        $_SESSION["errore"] = "ERRORE - QUERY SQL";
        header("Location: ./paginaregistrazione.php");
      }
    } else {
      $_SESSION["errore"] = "UTENTE GIÀ ESISTENTE";
      header("Location: ./paginaregistrazione.php");
    }
  }

  ?>
</body>

</html>