<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Negozio</title>
  <link rel="icon" type="image/png" href="../images/icon.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <style>
    .square {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      width: 100%;
    }

    body {
      background: rgb(61, 82, 160);
      background: linear-gradient(150deg, rgba(61, 82, 160, 0.9559164733178654) 13%, rgba(112, 145, 230, 0.9118329466357309) 37%, rgba(134, 151, 196, 0.8561484918793504) 54%, rgba(173, 187, 218, 1) 68%, rgba(237, 232, 245, 1) 100%);
      background-repeat: no-repeat;
      background-size: cover;
      min-height: 100vh;
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
      text-decoration: none;
    }
  </style>
</head>

<body>
  <div class="square">
    <div>
      <h1 style="text-align: center">Sign-up</h1>
      <br>
      <div class="centered-form">
        <form action="registrazioneScript.php" method="post">
          <div class="p-2">
            <label class="pb-1" for="email">EMAIL</label>
            <input type="email" class="form-control" name="email" id="email" required>
          </div>
          <div class="p-2">
            <label class="pb-1" for="nome">NOME</label>
            <input type="text" class="form-control" name="nome" id="nome" required>
          </div>
          <div class="p-2">
            <label class="pb-1" for="cognome">COGNOME</label>
            <input type="text" class="form-control" name="cognome" id="cognome" required>
          </div>
          <div class="p-2">
            <label class="pb-1" for="eta">ETA</label>
            <input type="number" class="form-control" name="eta" id="eta" required>
          </div>
          <div class="p-2">
            <label class="pb-1" for="classe">CLASSE</label>
            <input type="text" class="form-control" name="classe" id="classe" required>
          </div>
          <div class="p-2">
            <label class="pb-1" for="password">PASSWORD</label>
            <div class="w-100 d-flex align-items-center">
              <input type="password" class="form-control me-2" name="password" id="password" required>
              <button type="button" class="btn btn-default border ml-2" id="togglePassword">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                  <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                  <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                </svg>
              </button>
            </div>
          </div>
          <div class="p-2">
            <label class="pb-1" for="passwordConferma">CONFERMA PASSWORD</label>
            <input type="password" class="form-control" name="passwordConferma" id="passwordConferma" required>
          </div>
          <hr>
          <button type="submit" id="invia" class="btn btn-primary mt-2 border my-3">SUBMIT</button>
          <br>
        </form>
        <a class="text-primary" href="../index.php">Hai gia un account? FAI IL LOGIN</a>
        <?php
        if (isset($_SESSION["errore"]) || !empty($_SESSION["errore"])) {
          echo "<p class=\"p-3 text-danger\">{$_SESSION["errore"]}</p>";
          unset($_SESSION["errore"]);
        }
        ?>
      </div>
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

    const passwordConfirmInput = document.querySelector('input[name="passwordConferma"]');
    const email = document.getElementById("email");
    const errorText = document.createElement('p');
    errorText.style.color = 'red';
    errorText.style.marginTop = '10px';
    errorText.style.marginBottom = '10px';
    errorText.textContent = 'Le due password non coincidono';
    errorText.id = 'errore';
    passwordInput.value = "";
    passwordConfirmInput.value = "";
    const button = document.getElementById("invia");
    button.disabled = true;

    email.addEventListener('input', () => {
      checkPasswords();
    })

    passwordInput.addEventListener('input', () => {
      checkPasswords();
    });

    passwordConfirmInput.addEventListener('input', () => {
      checkPasswords();
    });

    function checkPasswords() {
      if (passwordInput.value !== passwordConfirmInput.value) {
        if (passwordConfirmInput.value !== '')
          button.disabled = false;
        passwordConfirmInput.style.border = '1px solid red';
        passwordConfirmInput.parentNode.appendChild(errorText);
        button.disabled = true;
      } else {
        if (email.value !== "" && email.value.includes("@") && email.value.includes(".") && passwordInput.value != '' && passwordConfirmInput.value != '') {
          button.disabled = false;
          passwordConfirmInput.style.border = '1px solid lightgrey';
          if (document.getElementById("errore"))
            passwordConfirmInput.parentNode.removeChild(errorText);
        } else
          button.disabled = true;
      }
    }
  </script>

</html>