<?php 
session_start();
include("./connessione.php");
  
  $e = $_POST["email"];
  $pass = hash("sha256", $_POST["password"]);
  $sql = "SELECT * FROM utente WHERE email = '$e'";
  
  $result = $conn->query($sql);
  if (is_bool($result)) {
    $_SESSION["errore"] = "ERRORE - RISULTATO BOOLEANO";
    header("Location: ./login.php");
  } else {
    if ($result->num_rows > 0) {
      $sql = "SELECT * FROM utente WHERE email = '$e' AND password = '$pass'";
      var_dump($sql);
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
        $_SESSION["utente"] = $e;
        header("Location: ./benvenuto.php");
      } else {
        $_SESSION["errore"] = "PASSWORD ERRATA";
        header("Location: ./login.php");
      }
    } else {
      $_SESSION["errore"] = "UTENTE NON ESISTENTE";
      header("Location: ./login.php");
    }
  }
  

