<?php
session_start();
$pageTitle = "Contact"; 
?>
<!DOCTYPE html>
<html lang="fr">
<?php require_once 'includes/head.php';?>

<body class="page-contact">
<?php require_once 'includes/header.php'; ?>
<main class="form-container">
  <h1>Contactez-nous</h1>
  <form method="post" action="#">
    <input type="text" name="nom" placeholder="Votre nom" required><br>
    <input type="email" name="email" placeholder="Votre email" required><br>
    <textarea name="message" placeholder="Votre message" required></textarea><br>
    <button type="submit">Envoyer</button>
  </form>
</main>
<?php require_once 'includes/footer.php'; ?>
</body>
</html>