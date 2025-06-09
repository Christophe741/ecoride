<?php
$pageTitle = "Connexion"; 
session_start();
require_once 'db/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($mot_de_passe, $user['password'])) {
        $_SESSION['role'] = $user['role'];

        if ($user['role'] === 'admin') {
            header('Location: admin/index.php');
        } else {
            header('Location: espace_utilisateur.php');
        }
        exit;
    } else {
        $erreur = "Email ou mot de passe incorrect.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<?php require_once 'includes/head.php';?>

<body>
    <main class="form-container">
    <?php require_once 'includes/header.php';?>
    <h2>Connexion</h2>
    <?php if (!empty($erreur)) echo "<p style='color:red;'>$erreur</p>"; ?>
    <form method="post">
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="mot_de_passe" placeholder="Mot de passe" required><br>
        <button type="submit">Se connecter</button>
    </form>
</main>
<?php require_once 'includes/footer.php'; ?>
</body>
</html>
