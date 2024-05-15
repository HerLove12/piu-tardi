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
        $sql = "SELECT a.nome AS nome, a.descrizioni AS descr, a.foto AS foto, a.datacaricamento AS data, t.nome AS tipo, u.email AS email FROM annuncio AS a
        JOIN tipologia AS t ON t.ID = a.ID_tipologia
        JOIN utente AS u ON u.ID = a.ID_utente
        WHERE a.ID = $id";  
        $result = $conn->query($sql);
        while($row = $result->fetch_assoc()){
            $n = $row["nome"];
            $d = $row["descr"];
            $f = $row["foto"];
            $d = $row["data"];
            $e = $row["email"];
            $t = $row["tipo"];  
            $imgURL = "../images/" . $f;
            echo "<h1>$n</h1><br>";
            echo "<img src=\"$imgURL\" alt=\"foto\" width=\"200px\" height=\"200px\"><br><br>";
        }
    ?>
</body>

</html>

