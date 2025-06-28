<?php
// Chargement des variables d'environnement depuis le fichier .env s'il existe
$envFile = __DIR__ . '/../.env';
if (file_exists($envFile)) {
    $lines = file($envFile);
    foreach ($lines as $line) {  
        $line = trim($line);
        // Ignore les lignes vides ou les commentaires
        if ($line === '' || str_starts_with($line, '#')) {
            continue;
        }
        // Sépare la clé et la valeur, puis ajoute à l'environnement
        list($name, $value) = explode('=', $line, 2);
        putenv("$name=$value");
    }
}

// Récupération des variables d'environnement pour la connexion MySQL
$host = getenv('DB_HOST');
$dbname = getenv('DB_NAME');
$user = getenv('DB_USER');
$pass = getenv('DB_PASS');
try {
    // Création de la connexion PDO à la base de données
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Affiche une erreur si la connexion échoue
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>
