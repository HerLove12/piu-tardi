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
</head>

<body>
    <?php
        $id = $_POST["id"];
        $p = $_POST["proposta"];
        var_dump($id);
        var_dump($p);
        $sql = "INSERT INTO proposta (prezzo, ID_utente, ID_annuncio, stato)
                VALUES ($p, ".$_SESSION["utente"].", $id, 'in attesa')";
        $result = $conn->query($sql);
        if(!$result){
            $_SESSION["messaggio"] = "ERRORE NELL'INVIO DELLA PROPOSTA";
        } else 
            $_SESSION["messaggio"] = "PROPOSTA INVIATA CON SUCCESSO";
            header("Location: ./articolo.php?id=$id");
    ?>
</body>

</html>