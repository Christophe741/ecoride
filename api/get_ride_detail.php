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
                       WHERE rides.id = ?");
$stmt->execute([$id]);
$ride = $stmt->fetch(PDO::FETCH_ASSOC);

if ($ride) {
    $collection = $mongo->selectCollection($dbName, 'rides');
    $doc = $collection->findOne(['ride_id' => $id]);
    $ride['description'] = $doc['description'] ?? null;
    if (is_null($ride['description'])) {
        unset($ride['description']);
    }

    $labels = [
    'chatty_level' => 'Ambiance',
    'music_taste'  => 'Musique',
    'smoker'       => 'Fumeur',
    'pets'         => 'Animaux',
     ];
    
    $preferences = [];
    foreach ($labels as $field => $label) {
        if (isset($ride[$field]) && !empty($ride[$field])) {
            $preferences[] = [
                'key' => $label,
                'value' => $ride[$field]
            ];
        }
        unset($ride[$field]);
    }
    $ride['preferences'] = $preferences;
    
    $vehicule = [
        'brand' => $ride['brand'] ?? null,
        'model' => $ride['model'] ?? null,
        'fuel_type' => $ride['fuel_type'] ?? null
    ];
    foreach (['brand', 'model', 'fuel_type'] as $field) {
        unset($ride[$field]);
    }
    $ride['vehicle'] = $vehicule;

    echo json_encode(['success' => true, 'ride' => $ride]);
} else {
    echo json_encode(['success'=>false,'message'=>'Trajet introuvable']);
}