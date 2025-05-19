<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EcoRide - Accueil</title>
  <link rel="stylesheet" href="css/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

</head>
<body class="page-covoiturage">
<?php require_once 'db/config.php'; ?>
<?php require_once 'includes/header.php';?>
<?php require_once 'includes/hero_search.php';?>

<main>
<section class="results">
    <h1>Résultats de recherche</h1>

    <?php
    if (!empty($_GET['depart']) && !empty($_GET['arrivee']) && !empty($_GET['date'])) {
        $depart = $_GET['depart'];
        $arrivee = $_GET['arrivee'];
        $date = $_GET['date'];

        $stmt = $pdo->prepare("SELECT trajets.id, trajets.places, trajets.prix, trajets.ville_depart, trajets.ville_arrivee, users.pseudo, users.note, users.photo 
                                FROM trajets 
                                JOIN users ON trajets.conducteur_id = users.id
                                WHERE ville_depart LIKE ? 
                                  AND ville_arrivee LIKE ? 
                                  AND DATE(date_depart) = ?
                                ORDER BY date_depart ASC");
        $stmt->execute(["%$depart%", "%$arrivee%", $date]);

        if ($stmt->rowCount() > 0) {
            while ($trajet = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<div class='trajet-card'>";
            echo "  <div class='trajet-left'>";
            echo "  <img class='photo-profil' src='assets/profils/" . htmlspecialchars($trajet['photo']) . "' alt='Photo de " . htmlspecialchars($trajet['pseudo']) . "'>";
            echo "  </div>";
            echo "  <div class='trajet-middle'>";
            echo "    <h3>" . htmlspecialchars($trajet['pseudo']) . "</h3>";
            echo "    <p>Note : " . htmlspecialchars($trajet['note']) . " / 5</p>";
            echo "    <p>Places restantes : " . htmlspecialchars($trajet['places']) . "</p>";
            echo "    <p>Prix : " . htmlspecialchars($trajet['prix']) . " €</p>";
            echo "    <p>Départ : " . htmlspecialchars($trajet['ville_depart']) . "</p>";
            echo "    <p>Arrivée : " . htmlspecialchars($trajet['ville_arrivee']) . "</p>";
            echo "  </div>";
            echo "  <div class='trajet-right'>";
            echo "    <span class='badge-green'>✔ Écologique</span>";
            echo "    <a class='detail-btn' href='detail.php?id=" . $trajet['id'] . "'>Détail</a>";
            echo "  </div>";
            echo "</div>";

            }
        } else {
            echo "<p>Aucun trajet trouvé pour cette recherche.</p>";
        }

    } else {
        echo "<p>Veuillez saisir une ville de départ, d'arrivée et une date.</p>";
    }
    ?>
  </section>

  
</main>

<?php require_once 'includes/footer.php'; ?>
  
</body>
</html>