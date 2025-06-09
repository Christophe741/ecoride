<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Contact - EcoRide</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="page-contact">
<?php require_once 'includes/header.php'; ?>
<main class="form-container">
  <h1>Contactez-nous</h1>
  <form method="post" action="#">
    <input type="text" name="nom" placeholder="Votre nom" required>
    <input type="email" name="email" placeholder="Votre email" required>
    <textarea name="message" placeholder="Votre message" required></textarea>
    <button type="submit">Envoyer</button>
  </form>
</main>
<?php require_once 'includes/footer.php'; ?>
</body>
</html>