<?php
$url = "https://jsonplaceholder.typicode.com/posts/1"; // URL de l'API

$ch = curl_init($url); // Initialiser cURL
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Retourner la réponse en tant que chaîne
$response = curl_exec($ch); // Exécuter la requête
curl_close($ch); // Fermer la connexion

$data = json_decode($response, true); // Convertir JSON en tableau PHP
print_r($data); // Afficher la réponse
?>
