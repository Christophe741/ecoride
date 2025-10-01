<?php
session_start();
require_once 'includes/csrf.php';
require_once 'db/config.php';

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

    if ($departure_city && $arrival_city && $departure_time && $price && $seats && $duration) {
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
        $error = "Veuillez remplir tous les champs obligatoires.";
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

  <?php if (!empty($error)): ?>
    <div class="message error"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <?php if (empty($vehicles)): ?>
    <div class="publish-empty">
      <p>Vous n'avez pas encore enregistré de véhicule.</p>
      <a href="add_vehicle.php" class="publish-empty__link">Ajouter un véhicule</a>
    </div>
  <?php else: ?>
    <form method="post" class="publish-form">
      <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
      
      <div class="publish-form__group">
        <label for="departure_city" class="publish-form__label">Ville de départ *</label>
        <input 
          type="text" 
          name="departure_city" 
          id="departure_city"
          class="publish-form__input"
          placeholder="Ex: Paris" 
          required>
      </div>

      <div class="publish-form__group">
        <label for="arrival_city" class="publish-form__label">Ville d'arrivée *</label>
        <input 
          type="text" 
          name="arrival_city" 
          id="arrival_city"
          class="publish-form__input"
          placeholder="Ex: Lyon" 
          required>
      </div>

      <div class="publish-form__group">
        <label for="departure_time" class="publish-form__label">Date et heure de départ *</label>
        <input 
          type="datetime-local" 
          name="departure_time" 
          id="departure_time"
          class="publish-form__input"
          required>
      </div>

      <div class="publish-form__row">
        <div class="publish-form__group publish-form__group--half">
          <label for="price" class="publish-form__label">Prix par place (€) *</label>
          <input 
            type="number" 
            step="0.01" 
            name="price" 
            id="price"
            class="publish-form__input"
            placeholder="Ex: 15.00" 
            required>
        </div>

        <div class="publish-form__group publish-form__group--half">
          <label for="seats" class="publish-form__label">Places disponibles *</label>
          <input 
            type="number" 
            name="seats" 
            id="seats"
            class="publish-form__input"
            placeholder="Ex: 3"
            min="1"
            max="8"
            required>
        </div>
      </div>

      <div class="publish-form__group">
        <label for="duration" class="publish-form__label">Durée estimée *</label>
        <input 
          type="time" 
          name="duration" 
          id="duration"
          class="publish-form__input"
          required>
        <small class="publish-form__help">Format: HH:MM</small>
      </div>

      <div class="publish-form__group">
        <label for="vehicle_id" class="publish-form__label">Véhicule utilisé *</label>
        <select name="vehicle_id" id="vehicle_id" class="publish-form__select" required>
          <option value="" disabled selected>Choisir un véhicule</option>
          <?php foreach ($vehicles as $v): ?>
            <option value="<?= $v['id'] ?>">
              <?= htmlspecialchars("{$v['brand']} {$v['model']} ({$v['fuel_type']})") ?>
            </option>
          <?php endforeach; ?>
        </select>
        <a href="add_vehicle.php" class="publish-form__add-link">+ Ajouter un nouveau véhicule</a>
      </div>

      <div class="publish-form__group">
        <label for="description" class="publish-form__label">Description (optionnel)</label>
        <textarea 
          name="description" 
          id="description"
          class="publish-form__textarea"
          placeholder="Ajoutez des informations complémentaires sur votre trajet..."
          ></textarea>
      </div>

      <button type="submit" class="publish-form__submit">Publier le trajet</button>
    </form>
  <?php endif; ?>
</main>
<?php require_once 'includes/footer.php'; ?>
</body>
</html>