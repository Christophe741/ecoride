<?php
session_start();
$pageTitle = "Détail du trajet";
?>

<!DOCTYPE html>
<html lang="fr">
<?php require_once 'includes/head.php';?>

<body class="page-detail">
<?php require_once 'includes/header.php'; ?>

<main>
  <h1>Détail du trajet</h1>
<section class="detail-container" id="trajet-detail">
 </section>
</main>

<script type="module" src="js/detail.js"></script>
<?php require_once 'includes/footer.php'; ?>
</body>
</html>
