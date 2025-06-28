<?php
require_once '../db/config.php';

header('Content-Type: application/json');

$depart = $_GET['depart'] ?? '';
$arrivee = $_GET['arrivee'] ?? '';
$date = $_GET['date'] ?? '';

if ($depart && $arrivee && $date) {
    $stmt = $pdo->prepare("SELECT trajets.id, trajets.places, trajets.prix, trajets.ville_depart, trajets.ville_arrivee, users.pseudo, users.note, users.photo
                           FROM trajets
                           JOIN users ON trajets.conducteur_id = users.id
                           WHERE users.role = 'conducteur'
                             AND ville_depart LIKE ?
                             AND ville_arrivee LIKE ?
                             AND DATE(date_depart) = ?
                           ORDER BY date_depart ASC");
    $stmt->execute(["%$depart%", "%$arrivee%", $date]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['success' => true, 'trajets' => $results]);
} else {
    echo json_encode(['success' => false, 'message' => 'Parametres manquants']);
}