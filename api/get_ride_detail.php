<?php
require_once '../db/config.php';
require_once '../db/mongo.php';
header('Content-Type: application/json');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) {
    echo json_encode(['success'=>false,'message'=>'Id manquant']);
    exit;
}

$stmt = $pdo->prepare("SELECT trajets.*, users.pseudo, users.photo, users.note,
                               prefs.ambiance, prefs.musique, prefs.fumeur, prefs.animaux,
                              v.marque, v.modele, v.type_energie
                       FROM trajets
                       JOIN users ON trajets.conducteur_id = users.id
                       LEFT JOIN preferences_utilisateur AS prefs ON prefs.utilisateur_id = users.id
                       LEFT JOIN vehicules AS v ON v.id = trajets.vehicule_id
                       WHERE trajets.id = ? AND users.role = 'conducteur'");
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
        'marque' => $trajet['marque'] ?? null,
        'modele' => $trajet['modele'] ?? null,
        'type_energie' => $trajet['type_energie'] ?? null
    ];
    foreach (['marque', 'modele', 'type_energie'] as $champ) {
        unset($trajet[$champ]);
    }
    $trajet['vehicule'] = $vehicule;

    echo json_encode(['success' => true, 'trajet' => $trajet]);
} else {
    echo json_encode(['success'=>false,'message'=>'Trajet introuvable']);
}