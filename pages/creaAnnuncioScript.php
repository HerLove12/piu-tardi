<?php
session_start();
include("./connessione.php");

// controllo se il nome è stato inserito
if ($_POST["nome"])
    $n = $_POST["nome"];
else {
    $_SESSION["mess"] = "Errore durante il caricamento - Inserire La tipologia";
    header("Location: ./creaAnnuncio.php");
    exit;
}

// controllo se la tipologia è stata inserita
if ($_POST["tipologia"] != 0) {
    $t = $_POST["tipologia"];
} else {
    $_SESSION["mess"] = "Errore durante il caricamento - Inserire La tipologia";
    header("Location: ./creaAnnuncio.php");
    exit;
}

$d = $_POST["descrizione"];

$sql = "SELECT MAX(ID) AS ID FROM annuncio";
$result = $conn->query($sql);
$max = $result->fetch_assoc()["ID"];

$target_dir = "../images/" . $_SESSION["utente"] . "/" . $max + 1 . "/";
$target_name = basename($_FILES["file"]["name"]);
$target_file = $target_dir . $target_name;
$target_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
var_dump($_FILES["file"]);
echo "<br>";
var_dump($target_dir);
echo "<br>";
var_dump($target_name);
echo "<br>";
var_dump($target_file);
echo "<br>";
var_dump($target_type);
echo "<br>";

if ($target_type != "jpg" && $target_type != "jpeg" && $target_type != "png") {
    echo "Dentro l'if dell'estensione<br>";
    $_SESSION["mess"] = "Errore: sono ammessi solo i formati JPG, JPEG e PNG";
    header("Location: ./creaAnnuncio.php");
    exit;
}

if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
}

if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
    if ($d != "")
        $sql = "INSERT INTO annuncio (ID, nome, descrizione, ID_utente, ID_tipologia, foto) 
                VALUES (" . $max + 1 . ", '$n', '$d', {$_SESSION["utente"]}, $t, '$target_file')";
    else
        $sql = "INSERT INTO annuncio (ID, nome, ID_utente, ID_tipologia, foto) 
                VALUES (" . $max + 1 . ", '$n', {$_SESSION["utente"]}, $t, '$target_file')";
    var_dump($sql);
    echo "<br>";
    $result = $conn->query($sql);
    var_dump($result);
    echo "<br>";
    $_SESSION["mess"] = "Il file è stato caricato correttamente";
    header("Location: ./creaAnnuncio.php");
} else {
    $_SESSION["mess"] = "Errore durante il caricamento";
    header("Location: ./creaAnnuncio.php");
}
