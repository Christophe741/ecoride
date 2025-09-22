<?php
header('Content-Type: text/plain; charset=utf-8');
$keys = ['DB_HOST','DB_NAME','DB_USER','DB_PASS'];
foreach ($keys as $k) {
  printf("%s=%s\n", $k, var_export(getenv($k), true));
}
