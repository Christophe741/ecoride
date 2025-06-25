<?php
require_once '../db/config.php';
require_once '../db/mongo.php';
header('Content-Type: application/json');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) {
    echo json_encode(['success'=>false,'message'=>'Id manquant']);
    exit;
}
$stmt = $pdo->prepare("SELECT trajets.*, users.pseudo, users.photo, users.note
                       FROM trajets
                       JOIN users ON trajets.conducteur_id = users.id
                       WHERE trajets.id = ? AND users.role = 'conducteur'");
$stmt->execute([$id]);
$trajet = $stmt->fetch(PDO::FETCH_ASSOC);
if ($trajet) {
    $collection = $mongo->selectCollection($dbName, 'descriptions');
    $doc = $collection->findOne(['trajet_id' => $id]);
    $trajet['description'] = $doc['description'] ?? null;
    echo json_encode(['success'=>true,'trajet'=>$trajet]);
} else {
    echo json_encode(['success'=>false,'message'=>'Trajet introuvable']);
}