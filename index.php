<?php
session_start();
$pageTitle = "EcoRide - Accueil";
?>
<!DOCTYPE html>
<html lang="fr">
<?php require_once 'includes/head.php';?>

<body class="page-index">
  
<?php require_once 'includes/header.php';?>
<?php require_once 'includes/hero_search.php';?>

<main>
  <section class="hero-presentation">
    <h2>Réinventons les trajets du quotidien</h2>
    <p>
      EcoRide est une plateforme de covoiturage pensée pour ceux qui veulent bouger autrement.<br>
      Ensemble, réduisons notre impact environnemental tout en rendant les trajets plus économiques et conviviaux.
    </p>
    <img src="assets/images/voiture.png" class="car-image" alt="Illustration d'une voiture écologique">
  </section>
</main>

<?php require_once 'includes/footer.php'; ?>
</body>
</html>