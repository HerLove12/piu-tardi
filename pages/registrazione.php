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
    <input type="password" name="password" required>
    <label for="PASSWORD">PASSWORD</label>
    <br><br>
    <input type="password" name="passwordConferma" required>
    <label for="passwordConferma">CONFERMA PASSWORD</label>
    <br><br>
    <script>
      const passwordInput = document.querySelector('input[name="password"]');
      const passwordConfirmInput = document.querySelector('input[name="passwordConferma"]');
      const errorText = document.createElement('p');
      errorText.style.color = 'red';

      passwordInput.addEventListener('input', () => {
        checkPasswords();
      });

      passwordConfirmInput.addEventListener('input', () => {
        checkPasswords();
      });

      function checkPasswords() {
        if (passwordInput.value !== passwordConfirmInput.value && passwordConfirmInput.value != "") {
          passwordConfirmInput.style.border = '1px solid red';
          errorText.textContent = 'Le due password non coincidono';
          passwordConfirmInput.parentNode.appendChild(errorText);
        } else {
          passwordConfirmInput.style.border = '1px solid black';
          passwordConfirmInput.parentNode.removeChild(errorText);
        }
      }
    </script>

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