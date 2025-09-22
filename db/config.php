<?php
$envLocalPath = __DIR__ . '/../.env.local';
$envPath      = __DIR__ . '/../.env';

if (file_exists($envLocalPath) || file_exists($envPath)) {
    $envFile = (file_exists($envLocalPath) && filesize($envLocalPath) > 0)
        ? $envLocalPath
        : $envPath;

    $lines = file($envFile);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#')) {
            continue;
        }
        list($name, $value) = explode('=', $line, 2);
        putenv("$name=$value");
    }
}

$host   = getenv('DB_HOST');
$dbname = getenv('DB_NAME');
$user   = getenv('DB_USER');
$pass   = getenv('DB_PASS');

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
