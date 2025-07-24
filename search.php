<?php
 session_start();
 $pageTitle = "Résultats covoiturage";
 $basePath = '/'; 
?>

<!DOCTYPE html>
<html lang="fr">
<?php require_once 'includes/head.php';?>

<body>
<?php require_once 'includes/header.php'; ?>
<?php require_once 'includes/search_section.php'; ?>

<main>
  <section class="ride-results__section">
    <h1 class="ride-results__title">Résultats de recherche</h1>
    <div id="results" class="ride-results__list"></div>
    <template id="ride-card-template">
      <div class="ride-card">
        <div class="ride-card__left">
          <img class="ride-card__photo" src="" alt="" />
        </div>
        <div class="ride-card__middle">
          <h3 class="ride-card__title"></h3>
          <p><strong>Note :</strong> <span class="ride-rating"></span></p>
          <p><strong>Places restantes :</strong> <span class="ride-seats"></span></p>
          <p><strong>Prix :</strong> <span class="ride-price"></span></p>
          <p><strong>Départ :</strong> <span class="ride-departure"></span></p>
          <p><strong>Arrivée :</strong> <span class="ride-arrival"></span></p>
        </div>
        <div class="ride-card__right">
          <span class="ride-card__badge"></span>
          <a class="ride-card__button"></a>
        </div>
      </div>
    </template>
  </section>
</main>

<script type="module" src="js/rideSearch.js"></script>
<?php require_once 'includes/footer.php'; ?>
</body>
</html>
