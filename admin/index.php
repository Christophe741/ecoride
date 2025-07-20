<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}
$pageTitle = "Espace Administrateur";
$basePath = '../';
?>
<!DOCTYPE html>
<html lang="fr">
<?php require_once __DIR__ . '/../includes/head.php'; ?>
<?php require_once __DIR__ . '/../includes/header.php'; ?>
<body>
  <main>
    <h1>Espace administrateur</h1>
  </main>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
