<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sito</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <style>
    body,
    html {
      height: 100%;
      margin: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: #f8f9fa;
    }

    .centered-form {
      width: 100%;
      max-width: 400px;
      padding: 30px;
      border: 1px solid #ddd;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      background-color: #fff;
    }

    a {
      color: white;
      text-decoration: none;
    }

    a:hover {
      color: white;
      text-decoration: none;
    }
  </style>
</head>

<body>
  <div>
    <h1 style="text-align: center">Sign-up</h1>
    <br><br>
    <div class="centered-form">
      <form action="registrazioneScript.php" method="post">
        <div class="form-group">
          <label for="email">EMAIL</label>
          <input type="email" class="form-control" name="email" id="email" required>
        </div>
        <div class="form-group">
          <label for="nome">NOME</label>
          <input type="text" class="form-control" name="nome" id="nome" required>
        </div>
        <div class="form-group">
          <label for="cognome">COGNOME</label>
          <input type="text" class="form-control" name="cognome" id="cognome" required>
        </div>
        <div class="form-group">
          <label for="eta">ETA</label>
          <input type="number" class="form-control" name="eta" id="eta" required>
        </div>
        <div class="form-group">
          <label for="classe">CLASSE</label>
          <input type="text" class="form-control" name="classe" id="classe" required>
        </div>
        <div class="form-group">
          <label for="password">PASSWORD</label>
          <input type="password" class="form-control" name="password" id="password" required>
          <button type="button" class="btn btn-default mt-2 border" id="togglePassword">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye"
              viewBox="0 0 16 16">
              <path
                d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
              <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
            </svg>
          </button>
        </div>
        <div class="form-group">
          <label for="passwordConferma">CONFERMA PASSWORD</label>
          <input type="password" class="form-control" name="passwordConferma" id="passwordConferma" required>
        </div>
        <hr>
        <button type="submit" class="btn btn-primary mt-2 border">SUBMIT</button>
        <br>
      </form>
      <p class="mt-3 border rounded px-3 bg-primary"><a href="../index.php">Hai gia un account? -> LOGIN</a></p>
      <?php
      if (isset($_SESSION["errore"]) || !empty($_SESSION["errore"])) {
        echo "<p>{$_SESSION["errore"]}</p>";
        unset($_SESSION["errore"]);
      }
      ?>
    </div>
  </div>
  <script>
    const passwordInput = document.getElementById('password');
    const toggleButton = document.getElementById('togglePassword');

    toggleButton.addEventListener('click', () => {
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleButton.classList.remove('btn-default');
        toggleButton.classList.add('btn-warning');
      } else {
        passwordInput.type = 'password';
        toggleButton.classList.remove('btn-warning');
        toggleButton.classList.add('btn-default');
      }
    });

    const passwordInput2 = document.querySelector('input[name="password"]');
    const passwordConfirmInput = document.querySelector('input[name="passwordConferma"]');
    const errorText = document.createElement('p');
    errorText.style.color = 'red';

    passwordInput2.addEventListener('input', () => {
      checkPasswords();
    });

    passwordConfirmInput.addEventListener('input', () => {
      checkPasswords();
    });

    function checkPasswords() {
      if (passwordInput2.value !== passwordConfirmInput.value && passwordConfirmInput.value != "") {
        passwordConfirmInput.style.border = '1px solid red';
        errorText.textContent = 'Le due password non coincidono';
        passwordConfirmInput.parentNode.appendChild(errorText);
        document.getElementById("invia").disabled = true;
      } else {
        passwordConfirmInput.style.border = '1px solid black';
        passwordConfirmInput.parentNode.removeChild(errorText);
        document.getElementById("invia").disabled = false;
      }
    }
  </script>

</html>