<?php
require_once '../db/config.php';
require_once '../db/mongo.php';
header('Content-Type: application/json');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) {
    echo json_encode(['success'=>false,'message'=>'Id manquant']);
    exit;
}

$stmt = $pdo->prepare("SELECT rides.*, users.username, users.photo, users.rating,
                               prefs.chatty_level, prefs.music_taste, prefs.smoker, prefs.pets,
                              v.brand, v.model, v.fuel_type
                       FROM rides
                       JOIN users ON rides.driver_id = users.id
                       LEFT JOIN user_preferences AS prefs ON prefs.user_id = users.id
                       LEFT JOIN vehicles AS v ON v.id = rides.vehicle_id
                       WHERE rides.id = ? AND users.role = 'conducteur'");
$stmt->execute([$id]);
$trajet = $stmt->fetch(PDO::FETCH_ASSOC);

if ($trajet) {
    $collection = $mongo->selectCollection($dbName, 'trajets');
    $doc = $collection->findOne(['trajet_id' => $id]);
    $trajet['description'] = $doc['description'] ?? null;
    if (is_null($trajet['description'])) {
        unset($trajet['description']);
    }

    $preferences = [];
    foreach ($trajet as $champ => $valeur) {
        if (!empty($valeur) && in_array($champ, ['ambiance', 'musique', 'fumeur', 'animaux'])) {
            $preferences[] = [
                'key' => $champ,
                'value' => $valeur
            ];
            unset($trajet[$champ]);
        }
    }
    $trajet['preferences'] = $preferences;
     $vehicule = [
        'marque' => $trajet['brand'] ?? null,
        'modele' => $trajet['model'] ?? null,
        'type_energie' => $trajet['fuel_type'] ?? null
    ];
    foreach (['brand', 'model', 'fuel_type'] as $champ) {
        unset($trajet[$champ]);
    }
    $trajet['vehicle'] = $vehicule;

    echo json_encode(['success' => true, 'ride' => $trajet]);
} else {
    echo json_encode(['success'=>false,'message'=>'Trajet introuvable']);
}