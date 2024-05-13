<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sito</title>
</head>

<body>
  <form action="registrazioneScript.php" method="post">
    <input type="email" name="email" required>
    <label for="EMAIL">EMAIL</label>
    <br><br>
    <input type="password" name="password" required>
    <label for="PASSWORD">PASSWORD</label>
    <br><br>
    <input type="text" name="nome" required>
    <label for="NOME">NOME</label>
    <br><br>
    <input type="text" name="cognome" required>
    <label for="COGNOME">COGNOME</label>
    <br><br>
    <input type="number" name="eta" required>
    <label for="COGNOME">ETA</label>
    <br><br>
    <input type="text" name="classe" required>
    <label for="COGNOME">CLASSE</label>
    <br><br>

    <input type="submit" value="SUBMIT">
  </form>
  <p><a href="./login.php">LOGIN</a></p>
  <?php
  if (isset($_SESSION["errore"]) || !empty($_SESSION["errore"])) {
    echo "<p>{$_SESSION["errore"]}</p>";
    unset($_SESSION["errore"]);
  }
  ?>
</body>

</html>