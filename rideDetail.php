<?php
session_start();
$pageTitle = "Ride Detail";
?>

<!DOCTYPE html>
<html lang="en">
<?php require_once 'includes/head.php'; ?>

<body class="page-ride-detail">
<?php require_once 'includes/header.php'; ?>

<main class="ride-detail">
  <h1 class="ride-detail__title">Détail du trajet</h1>
  
  <section class="ride-detail__section" id="ride-detail">
  </section>
</main>

<script type="module" src="js/rideDetail.js"></script>
<?php require_once 'includes/footer.php'; ?>
</body>
</html>
