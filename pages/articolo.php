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
        $sql = "SELECT *, t.nome AS tipo, u.email AS email FROM articolo AS a
                JOIN tipologia AS t ON t.ID = a.ID_tipologia
                JOIN utente AS u ON u.ID = a.ID_utente
                WHERE a.ID = '$id'";
        $result = $conn->query($sql);
        while($row = $result->fetch_assoc()){
            $n = $row["nome"];
            $d = $row["descrizioni"];
            $f = $row["foto"];
            $d = $row["datacaricamento"];
            $e = $row["email"];
            $t = $row["tipo"];
            //../images/+$f --> trovare l'immagine  
            echo "<h1></h1>";
        }
    ?>
</body>

</html>

