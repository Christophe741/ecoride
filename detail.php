<?php
session_start();
$pageTitle = "Détail du trajet";
?>

<!DOCTYPE html>
<html lang="fr">
<?php require_once 'includes/head.php';?>

<body>
<?php require_once 'includes/header.php'; ?>

<main class="detail-container" id="trajet-detail">
</main>

<script type="module" src="js/detail.js"></script>
<?php require_once 'includes/footer.php'; ?>
</body>
</html>
