<?php
require_once __DIR__ . '/../vendor/autoload.php';

$mongoUri = getenv('MONGO_URI') ?: die('Erreur : MONGO_URI non défini.');

try {
    $mongo = new MongoDB\Client($mongoUri);
} catch (Exception $e) {
    die('Erreur de connexion à MongoDB : ' . $e->getMessage());
}
$dbName = 'ecoride';
?>