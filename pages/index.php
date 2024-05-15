<?php
session_start();
include("./connessione.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>negozio</title>
</head>

<body>
    <div> 
        <!-- menu a tendina categorie -->
        <?php
                $sql = "SELECT nome, ID FROM tipologia";
                $result = $conn->query($sql);
                echo "<form action=\"index.php\" method=\"GET\">
                <select name=\"filtro\">";
                echo "<option value=\"0\">-nessun filtro-</option>";

                if($result->num_rows>0){
                    while($row=$result->fetch_assoc()){
                        $nome=$row['nome'];
                        $ID=$row['ID'];
                        echo "<option value=\"$ID\">$nome</option>";
                    }
                    echo "</select>";
                }
                echo "<input type=\"submit\">";
                echo "</form>";
            ?>
        <div><!-- dashboard articoli -->
            <?php
                $sql = "SELECT annuncio.ID, annuncio.nome, annuncio.foto, tipologia.nome AS tip, utente.ID AS utID, utente.email AS email FROM annuncio
                        JOIN tipologia ON tipologia.ID = annuncio.ID_tipologia
                        JOIN utente ON utente.ID = annuncio.ID_utente";

                $filtro;
                if(isset($_GET["filtro"]) and $_GET["filtro"]!=0){
                    $filtro=$_GET["filtro"];
                    $sql=$sql." WHERE tipologia.ID=$filtro";
                }
                
                
                $result = $conn->query($sql);
                if($result){
                    if($result->num_rows>0){
                        while($row = $result->fetch_assoc()){
                            $nome = $row['nome'];
                            $foto = $row['foto'];
                            $tipologia = $row['tip'];
                            $ID = $row['ID'];
                            $utID = $row['utID'];
                            $e = $row['email'];
                            echo "<div>
                                <a href=\"./articolo.php?id=$ID\"><img src=\"$foto\" onerror=\"this.src='../images/default.png'\" width=\"200px\" height=\"200px\" \"></a>
                                <h3>$nome</h3>
                                <p>$tipologia</p>
                                <p>Caricata da:<br><a href=\"./utente.php?id=$utID\">$e<a></p> 
                            </div>";//LINK DIRETTO ALL'UTENTE
                        }
                    }
                } else{
                    echo "<h1>errore nella query</h1>";
                    echo "<p>$sql</p>";
                }
            ?>
        </div>
    </div>
</body>

</html>