<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sito</title>
  <link rel="stylesheet" href="css/styles.css">
</head>

<body>
      <form action="./pages/loginScript.php" method="post">
        <input type="text" name="email" required>
        <label for="USERNAME">EMAIL</label>
        <br><br>
        <input type="password" name="password" id="password" required>
        <label for="PASSWORD">PASSWORD</label>
        <button type="button" id="togglePassword">TOGGLE VISIBILITY</button>
        <br><br>
        <input type="submit" value="SUBMIT">
      </form>
      <p><a href="./pages/registrazione.php">REGISTRATI</a></p>

      <?php
      if (isset($_SESSION["errore"]) or !empty($_SESSION["errore"])) {
        echo "<p>{$_SESSION["errore"]}</p>";
        unset($_SESSION["errore"]);
      }
      ?>
</body>
<script>
  const passwordInput = document.getElementById('password');
  const toggleButton = document.getElementById('togglePassword');

  toggleButton.addEventListener('click', () => {
    if (passwordInput.type === 'password') {
      passwordInput.type = 'text';
      toggleButton.textContent = 'HIDE PASSWORD';
    } else {
      passwordInput.type = 'password';
      toggleButton.textContent = 'TOGGLE VISIBILITY';
    }
  });
</script>

</html>