<?php
session_start();
include("./connessione.php");
if (!isset($_SESSION["utente"]))
    header("Location: ../index.php");

$newStato = $_GET["stato"];
$prodID = $_GET["ID"];
$sql = "UPDATE proposta SET stato = $newStato
        WHERE ID = $prodID";    
$conn->query($sql);
header("Location: ./proposteRicevute.php");
