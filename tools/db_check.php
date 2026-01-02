<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$out = '';
$out .= 'ENV DB_CONNECTION='.getenv('DB_CONNECTION').PHP_EOL;
$out .= 'CONFIG default='.config('database.default').PHP_EOL;
$default = config('database.default');
$dbname = config("database.connections.$default.database");
$out .= "CONFIG dbname=$dbname".PHP_EOL;
try {
    $count = Illuminate\Support\Facades\DB::table('offres')->count();
    $out .= "OFFRES_COUNT=$count".PHP_EOL;
} catch (Exception $e) {
    $out .= 'ERR: '.$e->getMessage().PHP_EOL;
}
file_put_contents(__DIR__ . '/db_check_out.txt', $out);
// Also echo a tiny marker so the shell shows something
echo "WROTE: tools/db_check_out.txt\n";
