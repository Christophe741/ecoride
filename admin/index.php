<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../connexion.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - EcoRide</title>
</head>
<body>
    <h1>Espace administrateur</h1>
    <p><a href="../logout.php">Se déconnecter</a></p>
</body>
</html>
