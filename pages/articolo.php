<?php
session_start();
include("./connessione.php");
if (!isset($_SESSION["utente"]))
    header("Location: ../index.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>negozio</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <a href="shop.php">Torna alla Home</a>
    <?php
    $art = $_GET["idArt"];
    $sql = "SELECT a.id, a.nome AS nome, a.descrizioni AS descr, a.foto AS foto, a.datacaricamento AS data, t.nome AS tipo, u.email AS email, u.ID as utID FROM annuncio AS a
        JOIN tipologia AS t ON t.ID = a.ID_tipologia
        JOIN utente AS u ON u.ID = a.ID_utente
        WHERE a.ID = $art";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $id = $row["id"];
        $n = $row["nome"];
        $d = $row["descr"];
        $f = $row["foto"];
        $data = explode("-", $row["data"]);
        $newData = $data[2] . "/" . $data[1] . "/" . $data[0];
        $e = $row["email"];
        $t = $row["tipo"];
        $utID = $row["utID"];
        $imgURL = "../images/" . $f; // DA DECIDERE LA MODIFICA DELL'IMMAGINE
        echo "<h1>$n</h1>";
        echo "<img src=\"$imgURL\" onerror=\"this.src='../images/default.png'\" width=\"200px\" height=\"200px\"><br>";
        echo "<h3>$d</h3>";
        echo "<p>Caricata da:<br><a href=\"./utente.php?id=$utID\">$e<a></p>"; //LINK DIRETTO ALL'UTENTE
        echo "<p>$t - $newData</p>";
        if ($utID != $_SESSION["utente"]) {
            echo "<button id=\"proposta\">Fai una Proposta</button>";
            echo "<script>var id = '" . $id . "';</script>";
        }
    }
    if (isset($_SESSION["messaggio"]) or !empty($_SESSION["messaggio"])) {
        echo "<p>{$_SESSION["messaggio"]}</p>";
        unset($_SESSION["messaggio"]);
    }
    ?>
</body>
<script>
    function showProposalForm() {
        // Create the overlay div
        const overlay = document.createElement("div");
        overlay.classList.add("overlay");
        document.body.appendChild(overlay);

        // Create the form div
        const formDiv = document.createElement("div");
        formDiv.classList.add("form-div");
        overlay.appendChild(formDiv);

        // Create the form elements
        const form = document.createElement("form");
        form.action = "creaProposta.php";
        form.method = "post";
        formDiv.appendChild(form);

        const input = document.createElement("input");
        input.type = "number";
        input.name = "proposta";
        input.placeholder = "Inserisci la tua proposta";
        input.min = 0;
        input.required = true;
        form.appendChild(input);

        const hiddenInput = document.createElement("input");
        hiddenInput.type = "hidden";
        hiddenInput.name = "id";
        hiddenInput.value = id;
        form.appendChild(hiddenInput);

        const buttons = document.createElement("div");
        form.appendChild(buttons);

        const submitButton = document.createElement("button");
        submitButton.type = "submit";
        submitButton.textContent = "Invia";
        buttons.appendChild(submitButton);

        const cancelButton = document.createElement("button");
        cancelButton.type = "button";
        cancelButton.textContent = "Annulla";
        cancelButton.onclick = () => {
            overlay.remove();
        };
        buttons.appendChild(cancelButton);
    }

    // Add event listener to the "proposta" button
    document.getElementById("proposta").addEventListener("click", showProposalForm);
</script>

</html>