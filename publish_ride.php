<?php
session_start();
require_once 'includes/csrf.php';
require_once 'db/config.php';
require_once 'db/mongo.php';

if (!isset($_SESSION['role']) || !isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$pageTitle = "Publier un trajet";
$basePath = '/';
$csrf_token = get_csrf_token();
$error = '';
$driver_id = $_SESSION['user_id'];

// Récupère tous les véhicules du conducteur
$stmt = $pdo->prepare('SELECT id, brand, model, fuel_type FROM vehicles WHERE user_id = ?');
$stmt->execute([$driver_id]);
$vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($vehicles)) {
    if (!check_csrf_token($_POST['csrf_token'])) {
        die('Jeton CSRF invalide.');
    }

    $departure_city  = trim($_POST['departure_city'] ?? '');
    $arrival_city    = trim($_POST['arrival_city'] ?? '');
    $departure_time  = trim($_POST['departure_time'] ?? '');
    $price           = trim($_POST['price'] ?? '');
    $seats           = trim($_POST['seats'] ?? '');
    $duration        = trim($_POST['duration'] ?? '');
    $vehicle_id      = $_POST['vehicle_id'] ?? '';
    $description     = trim($_POST['description'] ?? '');

    // Vérifie que le véhicule sélectionné appartient bien à l'utilisateur
    $vehCheck = $pdo->prepare('SELECT COUNT(*) FROM vehicles WHERE id = ? AND user_id = ?');
    $vehCheck->execute([$vehicle_id, $driver_id]);
    $isValidVehicle = $vehCheck->fetchColumn() > 0;

    if ($departure_city && $arrival_city && $departure_time && $price && $seats && $duration && $isValidVehicle) {
        $insert = $pdo->prepare('INSERT INTO rides (driver_id, vehicle_id, departure_city, arrival_city, departure_time, price, seats, duration) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
        $success = $insert->execute([
            $driver_id,
            $vehicle_id,
            $departure_city,
            $arrival_city,
            $departure_time,
            $price,
            $seats,
            $duration
        ]);

        if ($success) {
            $ride_id = $pdo->lastInsertId();
            if ($description) {
                $collection = $mongo->selectCollection($dbName, 'rides');
                $collection->insertOne([
                    'ride_id' => (int)$ride_id,
                    'description' => $description
                ]);
            }

            $params = http_build_query([
                'id' => $ride_id,
                'from' => $departure_city,
                'to' => $arrival_city,
                'date' => substr($departure_time, 0, 10)
            ]);
            header('Location: ride.php?' . $params);
            exit;
        } else {
            $error = "Erreur lors de la création du trajet.";
        }
    } else {
        $error = "Veuillez remplir tous les champs obligatoires et choisir un véhicule valide.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<?php require_once 'includes/head.php'; ?>
<body>
<?php require_once 'includes/header.php'; ?>
<main class="form-container">
  <h1>Publier un trajet</h1>

  <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>

  <?php if (empty($vehicles)): ?>
    <p>Vous n'avez pas encore enregistré de véhicule.</p>
    <p><a href="add_vehicle.php">Cliquez ici pour ajouter un véhicule</a> avant de publier un trajet.</p>
  <?php else: ?>
    <form method="post">
      <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
      <input type="text" name="departure_city" placeholder="Ville de départ" required>
      <input type="text" name="arrival_city" placeholder="Ville d'arrivée" required>
      <input type="datetime-local" name="departure_time" required>
      <input type="number" step="0.01" name="price" placeholder="Prix" required>
      <input type="number" name="seats" placeholder="Places disponibles" required>
      <input type="time" name="duration" placeholder="Durée (HH:MM:SS)" required>

      <label for="vehicle_id">Véhicule utilisé :</label>
      <select name="vehicle_id" id="vehicle_id" required>
        <option value="" disabled selected>Choisir un véhicule</option>
        <?php foreach ($vehicles as $v): ?>
          <option value="<?= $v['id'] ?>">
            <?= htmlspecialchars("{$v['brand']} {$v['model']} ({$v['fuel_type']})") ?>
          </option>
        <?php endforeach; ?>
      </select>
      <p style="margin-top: 0.5rem;"><a href="add_vehicle.php">+ Ajouter un nouveau véhicule</a></p>

      <textarea name="description" placeholder="Description"></textarea>
      <button type="submit">Publier</button>
    </form>
  <?php endif; ?>
</main>
<?php require_once 'includes/footer.php'; ?>
</body>
</html>
