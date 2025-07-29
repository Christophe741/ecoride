<?php
session_start();
require_once 'includes/csrf.php';
require_once 'db/config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
$pageTitle = "Ajouter un véhicule";
$basePath = '/'; 
$csrf_token = get_csrf_token();
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!check_csrf_token($_POST['csrf_token'])) {
        die('Jeton CSRF invalide.');
    }

    $brand = trim($_POST['brand'] ?? '');
    $model = trim($_POST['model'] ?? '');
    $fuel_type = $_POST['fuel_type'] ?? '';

    if ($brand && $model && in_array($fuel_type, ['essence', 'diesel', 'électrique'])) {
        $stmt = $pdo->prepare('INSERT INTO vehicles (user_id, brand, model, fuel_type) VALUES (?, ?, ?, ?)');
        if ($stmt->execute([$_SESSION['user_id'], $brand, $model, $fuel_type])) {
            header('Location: publish_ride.php');
            exit;
        } else {
            $error = "Erreur lors de l'ajout du véhicule.";
        }
    } else {
        $error = "Tous les champs sont obligatoires.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<?php require_once 'includes/head.php'; ?>
<body>
<?php require_once 'includes/header.php'; ?>
<main class="form-container">
  <h1>Ajouter un véhicule</h1>
  <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
  <form method="post">
    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
    <input type="text" name="brand" placeholder="Marque" required>
    <input type="text" name="model" placeholder="Modèle" required>
    <select name="fuel_type" required>
      <option value="" disabled selected>Type de carburant</option>
      <option value="essence">Essence</option>
      <option value="diesel">Diesel</option>
      <option value="électrique">Électrique</option>
    </select>
    <button type="submit">Ajouter le véhicule</button>
  </form>
</main>
<?php require_once 'includes/footer.php'; ?>
</body>
</html>
