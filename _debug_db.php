<?php
header('Content-Type: text/plain; charset=utf-8');
$h = getenv('DB_HOST');
$d = getenv('DB_NAME');
$u = getenv('DB_USER');
$p = getenv('DB_PASS');

echo "Trying mysql:host=$h;dbname=$d;charset=utf8mb4 with user=$u\n";
try {
  $pdo = new PDO("mysql:host=$h;dbname=$d;charset=utf8mb4", $u, $p, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  ]);
  echo "OK: connected!\n";
  $rows = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_NUM);
  echo "Tables:\n";
  foreach ($rows as $r) echo "- ".$r[0]."\n";
} catch (Throwable $e) {
  echo "ERR: ".$e->getMessage()."\n";
}
