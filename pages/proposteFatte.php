<?php
session_start();
include ("./connessione.php");
if (!isset($_SESSION["utente"]))
    header("Location: ../index.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>negozio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        .bordo {
            /* solo per esempio */
            border: 1px solid black;
            padding: 10px;
            margin: 10px;
        }

        .foto_profilo {
            border-radius: 50%;
            width: 30px;
            height: 30px;
            position: fixed;
            top: 10px;
            right: 10px;
            border: 1px solid black;
        }

        .overlay {
            position: fixed;
            top: 0px;
            left: 0px;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }

        .form-div {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgb(255, 255, 255);
            padding: 20px;
            border-radius: 10px;
            box-shadow: rgba(0, 0, 0, 0.5) 0px 0px 10px;
        }

        .form-div input {
            border: 1px solid black;
            border-radius: 5px;
            padding: 5px;
            margin-bottom: 20px;
        }

        .form-div div {
            display: flex;
            justify-content: space-around;
        }

        .in-attesa {
            background-color: rgba(255, 255, 0, 0.5);
        }

        .rifiutata {
            background-color: rgba(255, 0, 0, 0.5);
        }

        .accettata {
            background-color: rgba(0, 255, 0, 0.5);
        }
    </style>
</head>

<body>
    <a href="./index.php">Torna alla Home </a>
    <?php
    $sql = "SELECT foto FROM utente WHERE utente.ID = {$_SESSION["utente"]}";
    $result = $conn->query($sql);
    $f = $result->fetch_assoc()["foto"];
    echo "<a href=\"./utente.php?id=" . $_SESSION["utente"] . "\"><img class=\"foto_profilo\" src=\"$f\" onerror=\"this.src='../images/default.png'\"></a>";

    //dati relativi alla proposta
    $sql = "SELECT proposta.ID AS prodID, proposta.prezzo AS prezzo, annuncio.ID_utente AS utID, dataproposta, stato, annuncio.ID AS annID FROM proposta
            JOIN annuncio ON annuncio.ID = proposta.ID_annuncio
            JOIN utente ON annuncio.ID_utente = utente.ID
            WHERE proposta.ID_utente = {$_SESSION["utente"]}
            ORDER BY stato";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $prodID = $row['prodID'];
            $prezzo = $row['prezzo'];
            $utID = $row['utID']; //id utente della proposta
            $s = $row["stato"];
            $annID = $row["annID"];

            //ottengo dati annuncio
            $sql = "SELECT annuncio.*, tipologia.nome AS tipologia FROM annuncio
                    JOIN tipologia ON tipologia.ID = annuncio.ID_tipologia
                    WHERE annuncio.ID = $annID";
            $result2 = $conn->query($sql);
            $ann = $result2->fetch_assoc();
            $foto = $ann['foto'];
            $nome = $ann["nome"];
            $ID = $ann["ID"]; // id dell'annuncio
            $tipologia = $ann["tipologia"];

            //ottengo dati utente della proposta
            $sql = "SELECT * FROM utente
                    WHERE utente.ID = $utID";
            $result3 = $conn->query($sql);
            $ut = $result3->fetch_assoc();
            $e = $ut["email"];

            if ($s == "a-in attesa")
                echo "<div class=\"bordo in-attesa\">";
            else if ($s == "b-accettata")
                echo "<div class=\"bordo accettata\">";
            else if ($s == "c-rifiutata")
                echo "<div class=\"bordo rifiutata\">";
            //ricostruisco la data
            $data = explode("-", $row["dataproposta"]);
            $newData = $data[2] . "/" . $data[1] . "/" . $data[0];

            echo "<a href=\"./articolo.php?idArt=$ID\"><img src=\"$foto\" onerror=\"this.src='../images/default.png'\" width=\"200px\" height=\"200px\" \"></a>
                    <h3>$nome</h3>
                    <p>$tipologia</p>
                    <p>Inviata a:<br><a href=\"./utente.php?id=$utID\">$e<a></p>
                    <p>Prezzo Proposto: <b>$prezzo €</b></p>
                    <p>$newData</p>
                </div>";
        }
    } else {
        echo "<h1>NESSUNA PROPOSTA FATTA<h1>";
    }
    ?>

</body>

</html>