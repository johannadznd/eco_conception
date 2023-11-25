<?php
require_once '../views/layout/header.php';
require_once '../fonctions/pdo.php';

$pdo = getPdo();

//On récupère les infos des clients
$sqlGetClients = "SELECT * FROM clients";

$rstGetClients = $pdo->query($sqlGetClients);
$clients = $rstGetClients->fetchAll(PDO::FETCH_OBJ);


// Construction de la requête de mise à jour
$sqlUpdateClients = "UPDATE clients SET notes = CASE idClient ";


// Pour chaque client on ajout un WHEN avec les infos du clients
foreach ($clients as $client) {
    $notes = "Client : $client->name, Pays : $client->country";
    $sqlUpdateClients .= "WHEN $client->idClient THEN  '" . addslashes($notes) . "'";
}

$sqlUpdateClients .= "END";

// Préparation de la requête de mise à jour
$stmt = $pdo->prepare($sqlUpdateClients);

// Exécution de la requête de mise à jour
$updateResult = $stmt->execute();

if ($updateResult === TRUE) {
    echo "<p class='text_center p15'>Mise à jour de tous les clients effectuée avec succès</p>";
} else {
    echo "<p class='text_center p15'>Erreur de mise à jour des clients : " . $updateResult  . "</p>";
}

require_once '../views/layout/footer.php';
