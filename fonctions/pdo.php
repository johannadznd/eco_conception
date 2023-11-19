<?php

function getPdo(): PDO
{
  try {
    $pdo = new PDO(
      "mysql:host=localhost;dbname=eco-conception",
      "root",
      ""
    );
    return $pdo;
  } catch(PDOException $ex) {
    exit("Erreur lors de la connexion à la base de données");
  }
}

