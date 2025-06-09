<?php
$pageTitle = "Détail du trajet"; 
?>
<?php
session_start();
require_once 'db/config.php';

if (!isset($_GET['id'])) {
    echo "<p style='color:red;'>Erreur : aucun trajet sélectionné.</p>";
    echo "<a href='index.php'>Retour à l'accueil</a>";
    exit;
}
$trajet_id = (int) $_GET['id'];

$depart = urlencode($_GET['depart'] ?? '');
$arrivee = urlencode($_GET['arrivee'] ?? '');
$date = urlencode($_GET['date'] ?? '');
$urlRetour = "covoiturage.php?depart=$depart&arrivee=$arrivee&date=$date";

$stmt = $pdo->prepare("SELECT trajets.*, users.pseudo, users.photo, users.note
    FROM trajets
    JOIN users ON trajets.conducteur_id = users.id
    WHERE trajets.id = ?
    AND users.role = 'conducteur'
");
$stmt->execute([$trajet_id]);
$trajet = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$trajet) {
    echo "Trajet introuvable.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<?php require_once 'includes/head.php';?>

<body>
<?php require_once 'includes/header.php'; ?>

<main class="detail-container">
  <h1>Détail du trajet</h1>
  <div class="trajet-detail-card">
    <div class="conducteur-info">
      <img src="assets/profils/<?= htmlspecialchars($trajet['photo']) ?>" alt="Photo de <?= htmlspecialchars($trajet['pseudo']) ?>" class="photo-profil">
      <h2><?= htmlspecialchars($trajet['pseudo']) ?></h2>
      <p>Note : <?= htmlspecialchars($trajet['note']) ?>/5</p>
    </div>

    <div class="trajet-info">
      <p><strong>Départ :</strong> <?= htmlspecialchars($trajet['ville_depart']) ?></p>
      <p><strong>Arrivée :</strong> <?= htmlspecialchars($trajet['ville_arrivee']) ?></p>
      <p><strong>Date et heure :</strong> <?= date('d/m/Y H:i', strtotime($trajet['date_depart'])) ?></p>
      <p><strong>Prix :</strong> <?= htmlspecialchars($trajet['prix']) ?> €</p>
      <p><strong>Places disponibles :</strong> <?= htmlspecialchars($trajet['places']) ?></p>
    </div>
  </div>

  <a href="<?= $urlRetour ?>" class="btn-retour">← Retour aux résultats</a>
</main>

<?php require_once 'includes/footer.php'; ?>
</body>
</html>
