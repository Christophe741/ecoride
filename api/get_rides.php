<?php
require_once '../db/config.php';

header('Content-Type: application/json');

$depart = $_GET['departure_city'] ?? '';
$arrivee = $_GET['arrival_city'] ?? '';
$date = $_GET['departure_time'] ?? '';

if ($depart && $arrivee && $date) {
    $stmt = $pdo->prepare("SELECT rides.id, rides.seats, rides.price, rides.departure_city, rides.arrival_city, users.username, users.rating, users.photo
                           FROM rides
                           JOIN users ON rides.driver_id = users.id
                           WHERE users.role = 'conducteur'
                             AND departure_city LIKE ?
                             AND arrival_city LIKE ?
                             AND DATE(departure_time) = ?
                           ORDER BY departure_time ASC");
    $stmt->execute(["%$depart%", "%$arrivee%", $date]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['success' => true, 'rides' => $results]);
} else {
    echo json_encode(['success' => false, 'message' => 'Parametres manquants']);
}