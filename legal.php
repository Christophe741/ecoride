<?php
session_start();
$pageTitle = "Mentions légales";
?>
<!DOCTYPE html>
<html lang="fr">
<?php require_once 'includes/head.php';?>
<body>
<?php require_once 'includes/header.php'; ?>
<main class="legal-container">
    <h1 class = legal-container__title>Mentions légales</h1>
    <section class="legal-container__content">
        <h2 class="legal-container__subtitle">Éditeur du site</h2>
        <p>Nom du site : EcoRide<br>
        Responsable de la publication : Ecoride<br>
        Adresse : 12 rue du Laurier<br>
        Email : EcoRide@fakemail.com</p>
    </section>
    <section class="legal-container__content">
        <h2 class="legal-container__subtitle">Propriété intellectuelle</h2>
        <p>Tous les contenus présents sur ce site sont protégés par le droit d'auteur. Toute reproduction, même partielle, est interdite sans autorisation préalable.</p>
    </section>
    <section class="legal-container__content">
        <h2 class="legal-container__subtitle">Données personnelles</h2>
        <p>Les informations recueillies via les formulaires sont destinées uniquement à EcoRide et ne seront jamais transmises à des tiers sans consentement.</p>
    </section>
</main>
<?php require_once 'includes/footer.php'; ?>
</body>
</html>
