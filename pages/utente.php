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
    <?php
    $ut = $_GET["id"];
    if ($ut != $_SESSION["utente"]) {
        $sql = "SELECT foto FROM utente WHERE utente.ID = {$_SESSION["utente"]}";
        $result = $conn->query($sql);
        $f = $result->fetch_assoc()["foto"];
        echo "<a href=\"./utente.php?id=" . $_SESSION["utente"] . "\"><img class=\"foto_profilo\" src=\"$f\" onerror=\"this.src='../images/default.png'\"></a>";
        $sql = "SELECT * FROM utente WHERE ID = $ut";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $e = $row["email"];
        echo "<h1>$e</h1>";
    } else {
        $sql = "SELECT nome, cognome FROM utente WHERE id = " . $_SESSION["utente"] . "";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        echo "<h1>Benvenuto/a " . $row["nome"] . " " . $row["cognome"] . "</h1>";
    }
    ?>
    <a href="index.php">Torna alla Home</a>
    <br>
    <?php
    if ($ut == $_SESSION["utente"]) {
        echo "<a href=\"./creaAnnuncio.php\">Crea un nuovo Annuncio</a>
        <br>
        <a href=\"./proposteRicevute.php\">Controlla Proposte Ricevute</a>
        <br>
        <a href=\"./proposteFatte.php\">Controlla Proposte Fatte</a>
        <br>
        <button id=\"CambiaFoto\">Cambia Foto Profilo</button>
        <br>
        <button id=\"toggleButton\">Elimina Annuncio</button>
        <br>";
    }
    if (isset($_SESSION["mess"])) {
        echo "<p>" . $_SESSION["mess"] . "</p>";
        unset($_SESSION["mess"]);
    }
    ?>
    <br>
    <div>
        <!-- menu a tendina categorie -->
        <form action="utente.php" method="GET">
            <select name="filtro" onchange="this.form.submit()">;
                <option value="0" hidden></option>
                <option value="0">Nessun Filtro</option>
                <?php
                $sql = "SELECT nome, ID FROM tipologia";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $nome = $row['nome'];
                        $ID = $row['ID'];
                        echo "<option value=\"$ID\">$nome</option>";
                    }
                    echo "</select>";
                    echo "<input type=\"hidden\" name=\"id\" value=\"$ut\">"; // input nascosto per passare l'id dell'utente
                }
                ?>
                <label for="filtro">Filtro</label>
        </form>
        <div><!-- dashboard articoli -->
            <?php
            $sql = "SELECT annuncio.ID, annuncio.nome, annuncio.foto, tipologia.nome AS tip FROM annuncio
                        JOIN tipologia ON tipologia.ID = annuncio.ID_tipologia
                        JOIN utente ON utente.ID = annuncio.ID_utente";
            if ($ut != $_SESSION["utente"]) {
                $sql .= " WHERE annuncio.ID NOT IN (SELECT annuncio.ID FROM annuncio 
                                                    JOIN proposta ON annuncio.ID = proposta.ID_annuncio
                                                    WHERE stato LIKE \"b-accettata\")";
                $filtro;
                if (isset($_GET["filtro"]) and $_GET["filtro"] != 0) {
                    $filtro = $_GET["filtro"];
                    $sql .= " AND tipologia.ID = $filtro AND utente.ID = $ut";
                } else
                    $sql .= " AND utente.ID = $ut";
            } else {
                $filtro;
                if (isset($_GET["filtro"]) and $_GET["filtro"] != 0) {
                    $filtro = $_GET["filtro"];
                    $sql .= " WHERE tipologia.ID = $filtro AND utente.ID = $ut";
                } else
                    $sql .= " WHERE utente.ID = $ut";
            }

            $result = $conn->query($sql);
            if ($result) {
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $nome = $row['nome'];
                        $foto = $row['foto'];
                        $tipologia = $row['tip'];
                        $ID = $row['ID'];
                        echo "<div class=\"bordo\">
                                <a href=\"./articolo.php?idArt=$ID\"><img src=\"$foto\" onerror=\"this.src='../images/default.png'\" width=\"200px\" height=\"200px\" \"></a>
                                <h3>$nome</h3>
                                <p>$tipologia</p>
                                <button class=\"buttons-container\"><a href=\"./eliminaAnnuncio.php?idArt=$ID\">Elimina</a></button>
                            </div>";
                    }
                } else {
                    echo "<h1>NESSUN ANNUNCIO PRESENTE<h1>";
                }
            } else {
                echo "<h1>errore nella query</h1>";
                echo "<p>$sql</p>";
            }
            ?>
        </div>
    </div>
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
        form.action = "./CambiaFotoProfilo.php";
        form.method = "post";
        form.enctype = "multipart/form-data";
        formDiv.appendChild(form);

        const input = document.createElement("input");
        input.type = "file";
        input.name = "foto";
        input.required = true;
        form.appendChild(input);

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

    function toggleButtons() {
        const buttonsContainers = document.querySelectorAll('.buttons-container');
        const b = document.getElementById('toggleButton');
        buttonsContainers.forEach((container) => {
            container.classList.toggle('show-buttons');
        });
        if(b.innerHTML == "Elimina Annuncio")
            b.innerHTML = "Annulla";
        else
            b.innerHTML = "Elimina Annuncio";
        
    }

    document.getElementById('toggleButton').addEventListener('click', toggleButtons);

    // Add event listener to the "CambiaFoto" button
    document.getElementById("CambiaFoto").addEventListener("click", showProposalForm);
</script>

</html>