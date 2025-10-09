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
    $stmt = $pdo->prepare("
            SELECT id, password, role, is_active
            FROM users
            WHERE email = ?
            LIMIT 1
        ");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password'])) {
         if (!$user['is_active']) {
        $erreur = "Votre compte est désactivé. Contactez un administrateur.";
    } else {
        $_SESSION['role'] = $user['role'];
        $_SESSION['user_id'] = $user['id'];
        if ($user['role'] === 'admin') {
            header('Location: admin/index.php');
        } else {
            header('Location: index.php');
        }
        exit;
     }
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

        <label for="email" class="sr-only">Adresse e-mail</label>
        <input
            type="email"
            id="email"
            name="email"
            placeholder="Email"
            required
        ><br>

        <label for="password" class="sr-only">Mot de passe</label>
        <input
            type="password"
            id="password"
            name="password"
            placeholder="Mot de passe"
            required
        ><br>

        <button type="submit">Se connecter</button>
        </form>
</main>

<?php require_once 'includes/footer.php'; ?>
</body>
</html>
