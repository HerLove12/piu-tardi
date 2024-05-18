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
    $sql = "SELECT foto FROM utente WHERE utente.ID = {$_SESSION["utente"]}";
    $result = $conn->query($sql);
    $f = $result->fetch_assoc()["foto"];
    echo "<a href=\"./utente.php?id=" . $_SESSION["utente"] . "\"><img class=\"foto_profilo\" src=\"$f\" onerror=\"this.src='../images/default.png'\"></a>";
    ?>
    <a href="./index.php">Torna alla Home</a>
    <form action="./creaAnnuncioScript.php" method="post" enctype="multipart/form-data">
        <label for="nome">Nome Articolo</label><br>
        <input type="text" name="nome" required>
        <br><br>
        <label for="descrizione">Descrizione Oggetto</label><br>
        <textarea name="descrizione" cols="50" rows="10" maxlength="250" placeholder="Max. 250 Caratteri" style="max-width: 300px; max-height: 150px;"></textarea>
        <br><br>
        <label for="file">Foto dell'Articolo</label><br>
        <input type="file" name="file" required>
        <br><br>
        <label for="tipologia">Tipologia dell'Articolo</label><br>
        <select name="tipologia" required>
            <option value="0" hidden></option>
            <?php
            $sql = "SELECT * FROM tipologia";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc())
                echo "<option value='" . $row["ID"] . "'>" . $row["nome"] . "</option>";
            ?>
        </select>
        <br><br>
        <input type="submit" value="INVIA">
    </form>
    <?php
    if (isset($_SESSION["mess"])) {
        echo "<br><br>";
        echo "<p>" . $_SESSION["mess"] . "</p>";
        unset($_SESSION["mess"]);
    }
    ?>
</body>

</html>