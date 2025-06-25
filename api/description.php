<?php
require_once '../db/mongo.php';
header('Content-Type: application/json');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) {
    echo json_encode(['success' => false, 'message' => 'Id manquant']);
    exit;
}

$collection = $mongo->selectCollection($dbName, 'descriptions');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $doc = $collection->findOne(['trajet_id' => $id]);
    $description = $doc['description'] ?? null;
    echo json_encode(['success' => true, 'description' => $description]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $desc = $input['description'] ?? ($_POST['description'] ?? '');
    $collection->updateOne(
        ['trajet_id' => $id],
        ['$set' => ['description' => $desc]],
        ['upsert' => true]
    );
    echo json_encode(['success' => true, 'message' => 'Description mise à jour avec succès']);
    exit;
}

http_response_code(405);
?>