<?php
session_start();
require_once 'includes/csrf.php';
$pageTitle = "Connexion"; 
$basePath = '/'; 
require_once 'db/config.php';

$csrf_token = get_csrf_token();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      if (!check_csrf_token($_POST['csrf_token'])) {
        die('Jeton CSRF invalide.');
    }
    $email = $_POST['email'];
    $password = $_POST['password'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['role'] = $user['role'];
        if ($user['role'] === 'admin') {
            header('Location: admin/index.php');
        } else {
            header('Location: index.php');
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
   <?php require_once 'includes/header.php';?> 
      <main class="form-container">
    <h2>Connexion</h2>
    <?php if (!empty($erreur)) echo "<p style='color:red;'>$erreur</p>"; ?>
    <form method="post">
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Mot de passe" required><br>
        <button type="submit">Se connecter</button>
    </form>
</main>

<?php require_once 'includes/footer.php'; ?>
</body>
</html>
