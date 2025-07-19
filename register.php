<?php
session_start();
$pageTitle = "Inscription";
$basePath = '/'; 
require_once 'db/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = trim($_POST['pseudo'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($pseudo && filter_var($email, FILTER_VALIDATE_EMAIL) && $password) {
        $stmt = $pdo->prepare('SELECT pseudo, email FROM users WHERE pseudo = ? OR email = ?');
        $stmt->execute([$pseudo, $email]);
        $existing = $stmt->fetch(PDO::FETCH_ASSOC);

       if ($existing) {
            if ($existing['email'] === $email) {
                $erreur = "Un compte existe déjà avec cet email.";
            } else {
                $erreur = "Ce pseudo est déjà utilisé.";
            }
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $insert = $pdo->prepare('INSERT INTO users (pseudo, email, password) VALUES (?, ?, ?)');

            if ($insert->execute([$pseudo, $email, $hash])) {
                header('Location: login.php');
                exit;
            } else {
                $erreur = "Erreur lors de l'inscription.";
            }
        }
    } else {
        $erreur = "Veuillez remplir tous les champs correctement.";
    }
} 
?>
<!DOCTYPE html>
<html lang="fr">
<?php require_once 'includes/head.php';?>

<body class="page-inscription">
<?php require_once 'includes/header.php'; ?>
<main class="form-container">
  <h1>Créer un compte</h1>
   <?php if (!empty($erreur)) echo "<p style='color:red;'>$erreur</p>"; ?>
  <form method="post" action="">
    <input type="text" name="pseudo" placeholder="Pseudo" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Mot de passe" required>
    <button type="submit">S'inscrire</button>
  </form>
</main>
<?php require_once 'includes/footer.php'; ?>
</body>
</html>
