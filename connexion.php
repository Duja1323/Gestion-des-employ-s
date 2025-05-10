<?php

$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'entreprise';

try {
    $con = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
    
    if (!$con) {
        throw new Exception(mysqli_connect_error());
    }
    
    if (!mysqli_set_charset($con, "utf8mb4")) {
        throw new Exception("Erreur lors du chargement du jeu de caractères utf8mb4");
    }
} catch (Exception $e) {
    die("Erreur de connexion à la base de données : " . htmlspecialchars($e->getMessage()));
}
?>