<?php
 session_start();
 $pageTitle = "Résultats covoiturage";
?>

<!DOCTYPE html>
<html lang="fr">
<?php require_once 'includes/head.php';?>

<body class="page-covoiturage">
<?php require_once 'includes/header.php';?>
<?php require_once 'includes/search_section.php';?>

<main>
  <section class="results">
    <h1>Résultats de recherche</h1>
   <div id="results"></div>
  </section>
</main>

<script type="module" src="js/rideSearch.js"></script>
<?php require_once 'includes/footer.php'; ?>
</body>
</html>
