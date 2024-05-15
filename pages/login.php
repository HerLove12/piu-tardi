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
  <form action="loginScript.php" method="post">
    <input type="text" name="email" required>
    <label for="USERNAME">EMAIL</label>
    <br><br>
    <input type="password" name="password" required>
    <label for="PASSWORD">PASSWORD</label>
    <br><br>
    <input type="submit" value="SUBMIT">
  </form>
  <p><a href="./registrazione.php">REGISTRATI</a></p>

  <?php
  if (isset($_SESSION["errore"]) or !empty($_SESSION["errore"])){
    echo "<p>{$_SESSION["errore"]}</p>";  
    unset($_SESSION["errore"]);
  }
  ?>
</body>

</html>

