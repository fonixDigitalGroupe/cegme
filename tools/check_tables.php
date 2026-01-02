<?php
// Vérifie l'existence des tables ciblées en se connectant via PDO avec les infos du .env
$env = file(__DIR__ . '/../.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$config = [];
foreach ($env as $line) {
    if (trim($line) === '' || strpos(trim($line), '#') === 0) continue;
    if (!str_contains($line, '=')) continue;
    [$k,$v] = explode('=', $line, 2);
    $config[trim($k)] = trim($v);
}
$host = $config['DB_HOST'] ?? '127.0.0.1';
$port = $config['DB_PORT'] ?? '3306';
$db = $config['DB_DATABASE'] ?? '';
$user = $config['DB_USERNAME'] ?? '';
$pass = $config['DB_PASSWORD'] ?? '';
$out = "DSN=mysql:host=$host;port=$port;dbname=$db\n";
try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4", $user, $pass, [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
    $tables = ['filtering_rules','activity_poles','offres'];
    foreach ($tables as $t) {
        $stmt = $pdo->prepare("SELECT COUNT(*) AS c FROM information_schema.tables WHERE table_schema = :db AND table_name = :t");
        $stmt->execute([':db'=>$db, ':t'=>$t]);
        $c = $stmt->fetch(PDO::FETCH_ASSOC)['c'] ?? 0;
        $out .= "$t: $c\n";
    }
    // Also count offres rows if table exists
    $stmt = $pdo->prepare("SELECT COUNT(*) AS c FROM offres");
    try {
        $stmt->execute(); $count = $stmt->fetch(PDO::FETCH_ASSOC)['c'];
        $out .= "offres_rows: $count\n";
    } catch (Exception $e) {
        $out .= "offres_rows: ERR: " . $e->getMessage() . "\n";
    }
} catch (Exception $e) {
    $out .= 'ERR_CONNECT: '.$e->getMessage()."\n";
}
file_put_contents(__DIR__.'/tables_out.txt', $out);
echo "WROTE: tools/tables_out.txt\n";
