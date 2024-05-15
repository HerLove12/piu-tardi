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
        <!-- menu a tendina categorie, finire il refresh della paginaa -->
        <?php
                $sql = "SELECT nome, ID FROM tipologia";
                $result = $conn->query($sql);
                echo "<select>";
                if($result->num_rows>0){
                    while($row=$result->fetch_assoc()){
                        $nome=$row['nome'];
                        $ID=$row['ID'];
                        echo "<option value=\"$ID\">$nome</option>";
                    }
                    echo "</select>";
                }
            ?>
        <div><!-- dashboard articoli -->
            <?php
                $sql = "SELECT ID,nome, foto, tipologia.nome AS tip FROM annuncio
                JOIN tipologia ON tipologia.ID = annuncio.ID_tipologia";
                $result = $conn->query($sql);
                
                if($result->num_rows>0){
                    while($row=$result->fetch_assoc()){
                        $nome=$row['nome'];
                        $foto=$row['foto'];
                        $tipologia=$row['tip'];
                        $ID=$row['ID'];
                        echo "<div>
                            <img src=\"$foto\" width=\"200px\" height=\"200px\" onClick=\"location.href(\"https://articolo.php?id=$ID\") \">
                            <h3>$nome</h3>
                            <p>$tipologia</p>
                        </div>";
                    }
                }
            ?>
        </div>
    </div>
</body>

</html>