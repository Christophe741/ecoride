<?php
$pageTitle = "Détail du trajet";
session_start();

$depart = urlencode($_GET['depart'] ?? '');
$arrivee = urlencode($_GET['arrivee'] ?? '');
$date = urlencode($_GET['date'] ?? '');
?>

<!DOCTYPE html>
<html lang="fr">
<?php require_once 'includes/head.php';?>

<body>
<?php require_once 'includes/header.php'; ?>

<main class="detail-container" id="trajet-detail">
  <h1>Détail du trajet</h1>
</main>

<script type="module" src="js/detail.js"></script>
<?php require_once 'includes/footer.php'; ?>
</body>
</html>
