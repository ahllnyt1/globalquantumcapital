<?php 
require_once __DIR__ . '/config.php';

$dsn = DB_DRIVER .
      ':host=' . DB_HOST .
      ';port=' . DB_PORT .
      ';dbname=' . DB_NAME .
      ';charset=utf8mb4';

$options = [
  PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::ATTR_PERSISTENT         => false, // prevents using dead connections
];

try {
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (Exception $e) {
    die("DB Connection failed: " . $e->getMessage());
}
