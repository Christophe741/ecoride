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
  </section>
</main>

<script type="module" src="js/rideSearch.js"></script>
<?php require_once 'includes/footer.php'; ?>
</body>
</html>
