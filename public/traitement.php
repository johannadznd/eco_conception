<?php
require_once '../views/layout/header.php';
require_once '../fonctions/pdo.php';

$pdo = getPdo();

$sqlGetClients = "SELECT * FROM clients";

$rstGetClients = $pdo->query($sqlGetClients);
$clients = $rstGetClients->fetchAll(PDO::FETCH_OBJ);

foreach ($clients as $key => $client) {

    $notes = addslashes("Client : $client->name, Pays : $client->country");

    $sqlUpdateClients = "UPDATE clients SET notes = :notes WHERE idClient = :idClient";
    $stmt = $pdo->prepare($sqlUpdateClients);
    $reponse = $stmt->execute(
        array(
            ':notes' => $notes,
            ':idClient' => $client->idClient
        )
    );

    if ($reponse === TRUE) {
        echo "Mise à jour du client $client->name <br>";
    } else {
        echo "Erreur de mise à jour du client  $client->name : " . $reponse  . "<br>";
    }
}

require_once '../views/layout/footer.php';
