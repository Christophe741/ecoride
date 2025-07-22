<?php
session_start();
$pageTitle = "Détail du trajet";
$basePath = '/'; 
?>

<!DOCTYPE html>
<html lang="fr">
<?php require_once 'includes/head.php'; ?>

<body>
<?php require_once 'includes/header.php'; ?>

<main class="ride-detail">
  <h1 class="ride-detail__title">Détail du trajet</h1>
  
  <section class="ride-detail__content" id="ride-detail">
  <template id="ride-detail-template">
      <div class="ride-detail__card">
        <div class="ride-detail__driver-info">
          <img class="ride-detail__profile-photo" src="" alt="" />
          <h2 class="ride-detail__username"></h2>
          <p class="ride-detail__line ride-note"></p>
          <div class="ride-detail__preferences">
            <p class="ride-detail__line pref-item">
            <strong class="pref-key"></strong> <span class="pref-value"></span>
            </p>
          </div>

        </div>
        <div class="ride-detail__info">
          <span class="ride-card__badge"></span>
          <p class="ride-detail__line"><strong>Départ :</strong> <span class="ride-departure"></span></p>
          <p class="ride-detail__line"><strong>Arrivée :</strong> <span class="ride-arrival"></span></p>
          <p class="ride-detail__line"><strong>Date et heure :</strong> <span class="ride-date"></span></p>
          <p class="ride-detail__line"><strong>Durée :</strong> <span class="ride-duration"></span></p>
          <p class="ride-detail__line"><strong>Prix :</strong> <span class="ride-price"></span></p>
          <p class="ride-detail__line"><strong>Places disponibles :</strong> <span class="ride-seats"></span></p>
          <p class="ride-detail__line ride-vehicle-container"><strong>Véhicule :</strong> <span class="ride-vehicle"></span></p>
          <p class="ride-detail__line ride-description-container"><strong>Description :</strong> <span class="ride-description"></span></p>
        </div>
      </div>
    </template>
</section>
</main>

<script type="module" src="js/rideDetail.js"></script>
<?php require_once 'includes/footer.php'; ?>
</body>
</html>
