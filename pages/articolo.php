<?php
session_start();
include("./connessione.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sito</title>
</head>

<body>
    <?php
    $id = $_GET["id"];
    $sql = "SELECT a.nome AS nome, a.descrizioni AS descr, a.foto AS foto, a.datacaricamento AS data, t.nome AS tipo, u.email AS email, u.ID as ID FROM annuncio AS a
        JOIN tipologia AS t ON t.ID = a.ID_tipologia
        JOIN utente AS u ON u.ID = a.ID_utente
        WHERE a.ID = $id";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $n = $row["nome"];
        $d = $row["descr"];
        $f = $row["foto"];
        $data = $row["data"];
        $e = $row["email"];
        $t = $row["tipo"];
        $ID = $row["ID"];
        $imgURL = "../images/" . $f; // DA DECIDERE LA MODIFICA DELL'IMMAGINE
        echo "<h1>$n</h1>";
        echo "<img src=\"$imgURL\" onerror=\"this.src='../images/default.png'\" width=\"200px\" height=\"200px\"><br>";
        echo "<h3>$d</h3>";
        echo "<p>Caricata da:<br><a href=\"./utente.php?id=$ID\">$e<a></p>"; //LINK DIRETTO ALL'UTENTE
        echo "<p>$data / $t</p>";
    }
    ?>
</body>

</html>