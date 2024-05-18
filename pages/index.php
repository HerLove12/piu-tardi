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
    <div>
        <!-- menu a tendina categorie -->
        <form action="shop.php" method="GET">
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
                }
                ?>
                <label for="filtro">Filtro</label>
        </form>
        <div><!-- dashboard articoli -->
            <?php
            $sql = "SELECT annuncio.ID, annuncio.nome, annuncio.foto, tipologia.nome AS tip, utente.ID AS utID, utente.email AS email FROM annuncio
                        JOIN tipologia ON tipologia.ID = annuncio.ID_tipologia
                        JOIN utente ON utente.ID = annuncio.ID_utente
                        WHERE utente.ID != " . $_SESSION["utente"] . "";

            $filtro;
            if (isset($_GET["filtro"]) and $_GET["filtro"] != 0) {
                $filtro = $_GET["filtro"];
                $sql = $sql . " AND tipologia.ID = $filtro";
            }


            $result = $conn->query($sql);
            if ($result) {
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $nome = $row['nome'];
                        $foto = $row['foto'];
                        $tipologia = $row['tip'];
                        $ID = $row['ID'];
                        $utID = $row['utID'];
                        $e = $row['email'];
                        echo "<div class=\"bordo\">
                                <a href=\"./articolo.php?idArt=$ID\"><img src=\"$foto\" onerror=\"this.src='../images/default.png'\" width=\"200px\" height=\"200px\" \"></a>
                                <h3>$nome</h3>
                                <p>$tipologia</p>
                                <p>Caricata da:<br><a href=\"./utente.php?id=$utID\">$e<a></p> 
                            </div>"; //LINK DIRETTO ALL'UTENTE
                    }
                } else {
                    echo "<h1>NON SONO PRESENTI ARTICOLI</h1>";
                }
            } else {
                echo "<h1>errore nella query</h1>";
                echo "<p>$sql</p>";
            }
            ?>
        </div>
    </div>
    <a href="./logout.php"><button>Logout</button></a>
</body>

</html>