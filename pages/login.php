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
  <form action="scriptlogin.php" method="post">
    <input type="text" name="username" required>
    <label for="USERNAME">USERNAME</label>
    <br><br>
    <input type="password" name="password" required>
    <label for="PASSWORD">PASSWORD</label>
    <br><br>
    <input type="submit" value="SUBMIT">
  </form>
  <p><a href="./paginaregistrazione.php">REGISTRATI</a></p>

  <?php
  if (isset($_SESSION["errore"]) || !empty($_SESSION["errore"])){
    echo "<p>{$_SESSION["errore"]}</p>";  
    unset($_SESSION["errore"]);
  }
  ?>
</body>

</html>
