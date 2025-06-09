<?php
$pageTitle = "Résultats covoiturage"; 

require_once 'db/config.php';


$hasTrajet = false;

if (!empty($_GET['depart']) && !empty($_GET['arrivee']) && !empty($_GET['date'])) {
    $depart = $_GET['depart'];
    $arrivee = $_GET['arrivee'];
    $date = $_GET['date'];

    $stmt = $pdo->prepare("SELECT trajets.id, trajets.places, trajets.prix, trajets.ville_depart, trajets.ville_arrivee, users.pseudo, users.note, users.photo 
                           FROM trajets 
                           JOIN users ON trajets.conducteur_id = users.id
                           WHERE users.role = 'conducteur'
                             AND ville_depart LIKE ?
                             AND ville_arrivee LIKE ?
                             AND DATE(date_depart) = ?
                           ORDER BY date_depart ASC");
    $stmt->execute(["%$depart%", "%$arrivee%", $date]);
}
?>

<!DOCTYPE html>
<html lang="fr">
<?php require_once 'includes/head.php';?>

<body class="page-covoiturage">
<?php require_once 'includes/header.php';?>
<?php require_once 'includes/hero_search.php';?>

<main>
  <section class="results">
    <h1>Résultats de recherche</h1>
    <?php if (!empty($depart) && !empty($arrivee) && !empty($date)) : ?>
      <?php while ($trajet = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>
        <?php if (!$hasTrajet) : ?>
          <?php $hasTrajet = true; ?>
        <?php endif; ?>
        <div class="trajet-card">
          <div class="trajet-left">
            <img class="photo-profil" src="assets/profils/<?= htmlspecialchars($trajet['photo']) ?>" alt="Photo de <?= htmlspecialchars($trajet['pseudo']) ?>">
          </div>
          <div class="trajet-middle">
            <h3><?= htmlspecialchars($trajet['pseudo']) ?></h3>
            <p>Note : <?= htmlspecialchars($trajet['note']) ?> / 5</p>
            <p>Places restantes : <?= htmlspecialchars($trajet['places']) ?></p>
            <p>Prix : <?= htmlspecialchars($trajet['prix']) ?> €</p>
            <p>Départ : <?= htmlspecialchars($trajet['ville_depart']) ?></p>
            <p>Arrivée : <?= htmlspecialchars($trajet['ville_arrivee']) ?></p>
          </div>
          <div class="trajet-right">
            <span class="badge-green">✔ Écologique</span>
            <a class="detail-btn" href="detail.php?id=<?= $trajet['id'] ?>&depart=<?= urlencode($depart) ?>&arrivee=<?= urlencode($arrivee) ?>&date=<?= urlencode($date) ?>">Détail</a>
          </div>
        </div>
      <?php endwhile; ?>
      <?php if (!$hasTrajet) : ?>
        <p>Aucun trajet trouvé pour cette recherche.</p>
      <?php endif; ?>
    <?php else : ?>
      <p>Veuillez saisir une ville de départ, d'arrivée et une date.</p>
    <?php endif; ?>
  </section>
</main>
<?php require_once 'includes/footer.php'; ?>

</body>
</html>
