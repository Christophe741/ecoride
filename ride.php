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
  </section>
</main>

<script type="module" src="js/rideDetail.js"></script>
<?php require_once 'includes/footer.php'; ?>
</body>
</html>
