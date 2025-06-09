<?php
$pageTitle = "Inscription"; 
?>
<!DOCTYPE html>
<html lang="fr">
<?php require_once 'includes/head.php';?>

<body class="page-inscription">
<?php require_once 'includes/header.php'; ?>
<main class="form-container">
  <h1>Créer un compte</h1>
  <form method="post" action="#">
    <input type="text" name="pseudo" placeholder="Pseudo" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Mot de passe" required>
    <button type="submit">S'inscrire</button>
  </form>
</main>
<?php require_once 'includes/footer.php'; ?>
</body>
</html>