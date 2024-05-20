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
<!-- Navbar -->
<nav id="navbar">
  <ul class="navbar-items flexbox-col">
    <li class="navbar-logo flexbox-left">
      <a class="navbar-item-inner flexbox">
        <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 1438.88 1819.54">
          <polygon points="925.79 318.48 830.56 0 183.51 1384.12 510.41 1178.46 925.79 318.48"/>
          <polygon points="1438.88 1663.28 1126.35 948.08 111.98 1586.26 0 1819.54 1020.91 1250.57 1123.78 1471.02 783.64 1663.28 1438.88 1663.28"/>
        </svg>
      </a>
    </li>
    <li class="navbar-item flexbox-left">
      <a class="navbar-item-inner flexbox-left">
        <div class="navbar-item-inner-icon-wrapper flexbox">
          <ion-icon name="search-outline"></ion-icon>
        </div>
        <span class="link-text">Search</span>
      </a>
    </li>
    <li class="navbar-item flexbox-left">
      <a class="navbar-item-inner flexbox-left">
        <div class="navbar-item-inner-icon-wrapper flexbox">
          <ion-icon name="home-outline"></ion-icon>
        </div>
        <span class="link-text">Home</span>
      </a>
    </li>
    <li class="navbar-item flexbox-left">
      <a class="navbar-item-inner flexbox-left">
        <div class="navbar-item-inner-icon-wrapper flexbox">
          <ion-icon name="folder-open-outline"></ion-icon>
        </div>
        <span class="link-text">Projects</span>
      </a>
    </li>
    <li class="navbar-item flexbox-left">
      <a class="navbar-item-inner flexbox-left">
        <div class="navbar-item-inner-icon-wrapper flexbox">
          <ion-icon name="pie-chart-outline"></ion-icon>
        </div>
        <span class="link-text">Dashboard</span>
      </a>
    </li>
    <li class="navbar-item flexbox-left">
      <a class="navbar-item-inner flexbox-left">
        <div class="navbar-item-inner-icon-wrapper flexbox">
          <ion-icon name="people-outline"></ion-icon>
        </div>
        <span class="link-text">Team</span>
      </a>
    </li>
    <li class="navbar-item flexbox-left">
      <a class="navbar-item-inner flexbox-left">
        <div class="navbar-item-inner-icon-wrapper flexbox">
          <ion-icon name="chatbubbles-outline"></ion-icon>
        </div>
        <span class="link-text">Support</span>
      </a>
    </li>
    <li class="navbar-item flexbox-left">
      <a class="navbar-item-inner flexbox-left">
        <div class="navbar-item-inner-icon-wrapper flexbox">
          <ion-icon name="settings-outline"></ion-icon>
        </div>
        <span class="link-text">Settings</span>
      </a>
    </li>
  </ul>
</nav>
    <?php
    $sql = "SELECT foto FROM utente WHERE utente.ID = {$_SESSION["utente"]}";
    $result = $conn->query($sql);
    $f = $result->fetch_assoc()["foto"];
    echo "<a href=\"./utente.php?id=" . $_SESSION["utente"] . "\"><img class=\"foto_profilo\" src=\"$f\" onerror=\"this.src='../images/default.png'\"></a>";
    ?>
    <div>
        <!-- menu a tendina categorie -->
        <form action="index.php" method="GET">
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
                        WHERE utente.ID != " . $_SESSION["utente"] . "
                        AND annuncio.ID NOT IN (SELECT annuncio.ID FROM annuncio 
                                                JOIN proposta ON annuncio.ID = proposta.ID_annuncio
                                                WHERE stato LIKE \"b-accettata\")";

            $filtro;
            if (isset($_GET["filtro"]) and $_GET["filtro"] != 0) {
                $filtro = $_GET["filtro"];
                $sql .= " AND tipologia.ID = $filtro";
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
<script src="../js/script.js"></script>

</html>