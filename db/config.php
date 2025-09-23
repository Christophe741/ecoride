<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$root = dirname(__DIR__);
$files = (is_file("$root/.env.local") && filesize("$root/.env.local") > 0)
    ? ['.env.local']
    : ['.env'];

Dotenv::createImmutable($root, $files)->safeLoad();

$env = fn($k, $d=null) => $_ENV[$k] ?? getenv($k) ?? $d;

$host   = $_ENV['DB_HOST'];
$dbname = $_ENV['DB_NAME'];
$user   = $_ENV['DB_USER'];
$pass   = $_ENV['DB_PASS'];

$dsn = "mysql:host={$host};dbname={$dbname};charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

$mongoUser = $_ENV['MONGO_USER'] ?? getenv('MONGO_USER');
$mongoPass = $_ENV['MONGO_PASS'] ?? getenv('MONGO_PASS');
$mongoHost = $_ENV['MONGO_HOST'] ?? getenv('MONGO_HOST');
$mongoDb   = $_ENV['MONGO_DB']   ?? getenv('MONGO_DB');


$mongoUri = "mongodb://{$mongoUser}:{$mongoPass}@{$mongoHost}:27017/{$mongoDb}";

try {
    $mongo = new MongoDB\Client($mongoUri);
} catch (Exception $e) {
    die('Erreur de connexion à MongoDB : ' . $e->getMessage());
}

$dbName = $mongoDb;