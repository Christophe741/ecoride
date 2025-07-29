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

        <div class="ride-detail__top">
          <div class="ride-detail__top-left">
            <img class="ride-detail__profile-photo" src="" alt="" />
          </div>

          <div class="ride-detail__top-middle">
            <h2 class="ride-detail__username"></h2>
            <p class="ride-detail__line">
              <strong>Note :</strong>
              <span class="ride-note"></span>
            </p>
            <p class="ride-detail__line ride-detail__vehicle">
              <strong>Véhicule :</strong>
              <span class="ride-vehicle"></span>
            </p>
          </div>

          <div class="ride-detail__top-right">
            <span class="ride-card__badge"></span>
          </div>
        </div>

        <hr>

        <div class="ride-detail__middle1">
          <p class="ride-detail__line">
            <strong><span class="ride-departure"></span></strong>
            ⟶
            <strong><span class="ride-arrival"></span></strong>
          </p>
        </div>

        <hr>

        <div class="ride-detail__middle2">
          <div class="ride-detail__middle2-left">
            <div class="ride-detail__preferences">
              <p class="ride-detail__line ride-detail__preference-item">
                <strong class="ride-detail__preference-key"></strong><br>
                <span class="ride-detail__preference-value"></span>
              </p>
            </div>
          </div>

          <div class="ride-detail__middle2-right">
            <p class="ride-detail__line">
              <strong>Prix :</strong>
              <span class="ride-price"></span>
            </p>
            <p class="ride-detail__line">
              <strong>Places disponibles :</strong>
              <span class="ride-seats"></span>
            </p>
            <p class="ride-detail__line">
              <strong>Date et heure :</strong>
              <span class="ride-date"></span>
            </p>
            <p class="ride-detail__line">
              <strong>Durée :</strong>
              <span class="ride-duration"></span>
            </p>
          </div>
        </div>

        <hr>

        <div class="ride-detail__bottom">
          <p class="ride-detail__line ride-detail__description">
            <strong>Description :</strong><br>
            <span class="ride-description"></span>
          </p>
        </div>

      </div>
    </template>

    <template id="error-template">
      <p class="error"></p>
    </template>
  </section>
</main>
<script type="module" src="js/ride.js"></script>
<?php require_once 'includes/footer.php'; ?>
</body>
</html>
