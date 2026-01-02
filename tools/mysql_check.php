<?php
$env = file(__DIR__ . '/../.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$config = [];
foreach ($env as $line) {
    if (strpos(trim($line), '#') === 0) continue;
    if (!str_contains($line, '=')) continue;
    [$k,$v] = explode('=', $line, 2);
    $config[trim($k)] = trim($v);
}
$host = $config['DB_HOST'] ?? '127.0.0.1';
$port = $config['DB_PORT'] ?? '3306';
$db = $config['DB_DATABASE'] ?? '';
$user = $config['DB_USERNAME'] ?? '';
$pass = $config['DB_PASSWORD'] ?? '';
$out = "HOST=$host PORT=$port DB=$db USER=$user\n";
try {
    $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $stmt = $pdo->query('SELECT COUNT(*) AS c FROM offres');
    $c = $stmt->fetch(PDO::FETCH_ASSOC)['c'];
    $out .= "MYSQL_OFFRES_COUNT=$c\n";
} catch (Exception $e) {
    $out .= 'ERR: '.$e->getMessage()."\n";
}
file_put_contents(__DIR__.'/mysql_check_out.txt', $out);
echo "WROTE: tools/mysql_check_out.txt\n";
