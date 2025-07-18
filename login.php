<?php
session_start();
$pageTitle = "Connexion"; 
?>
<!DOCTYPE html>
<html lang="fr">
<?php require_once 'includes/head.php';?>

<body>
   <?php require_once 'includes/header.php';?> 
      <main class="form-container">
    <h2>Connexion</h2>
    <p id="login-error" style="color:red;"></p>
     <form id="login-form">
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Mot de passe" required><br>
        <button type="submit">Se connecter</button>
    </form>
</main>
<script type="module" src="js/login.js"></script>
<?php require_once 'includes/footer.php'; ?>
</body>
</html>
