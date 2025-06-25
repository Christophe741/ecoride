<?php
require_once __DIR__ . '/../vendor/autoload.php';

$mongoUri = getenv('MONGO_URI');
if (!$mongoUri) {
    $mongoUri = 'mongodb://mongo:27017';   
}
try {
    $mongo = new MongoDB\Client($mongoUri);
} catch (Exception $e) {
    die('Erreur de connexion à MongoDB : ' . $e->getMessage());
}
$dbName = 'ecoride';
?>