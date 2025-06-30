<?php
session_start();
$pageTitle = "EcoRide - Accueil";
?>
<!DOCTYPE html>
<html lang="fr">
<?php require_once 'includes/head.php'; ?>

<body>

  <?php require_once 'includes/header.php'; ?>

  <main class="hero">

    <?php require_once 'includes/search_section.php'; ?>

    <section class="hero__section">
      <div>
        <h2 class="hero__title">Réinventons les trajets du quotidien</h2>
        <p>
          EcoRide est une plateforme de covoiturage pensée pour ceux qui veulent bouger autrement.<br>
          Ensemble, réduisons notre impact environnemental tout en rendant les trajets plus économiques et conviviaux.
        </p>
      </div>
      <div class="hero__illustration">
        <img src="assets/images/car.png" class="hero__image" alt="Illustration d'une voiture écologique">
      </div>
    </section>

  </main>

  <?php require_once 'includes/footer.php'; ?>
</body>
</html>
