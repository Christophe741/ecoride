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
    <h1 id="results-title" class="ride-results__title" hidden>Résultats de recherche</h1>
    <div id="results" class="ride-results__list"></div>
    <template id="ride-card-template">
      <div class="ride-card">
        <div class="ride-card__left">
          <img class="ride-card__photo" src="" alt="" />
        </div>
        <div class="ride-card__middle">
          <h3 class="ride-card__title"></h3>
          <p><strong>Note :</strong> <span class="ride-card__rating"></span></p>
          <p><strong>Places restantes :</strong> <span class="ride-card__seats"></span></p>
          <p><strong>Prix :</strong> <span class="ride-card__price"></span></p>
          <p><strong>Départ :</strong> <span class="ride-card__departure"></span></p>
          <p><strong>Arrivée :</strong> <span class="ride-card__arrival"></span></p>
        </div>
        <div class="ride-card__right">
          <span class="ride-card__badge"></span>
          <a class="ride-card__button"></a>
        </div>
      </div>
    </template>
    <template id="message-template">
      <p class="message"></p>
    </template>
  </section>
</main>

<script type="module" src="js/search.js"></script>
<?php require_once 'includes/footer.php'; ?>
</body>
</html>
