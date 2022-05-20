<?php
// Ne pas oublier de démarrer le système de session sinon la fonction session_destroy() ne fonctionne pas
session_start();

$page="Connexion";
require_once("../system/config.php");

$token = trim(strip_tags($_SESSION["token"]));

    $supToken = $db->prepare("DELETE FROM user_reset WHERE token = :token");
    $supToken->bindParam(":token", $token);
    $supToken->execute();

// Détruire les variables de session pour faire une deconnexion
session_destroy();

// Rediriger vers la page d'accueil
header("Location: ./");
