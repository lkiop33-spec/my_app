<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

$hasTable = Schema::hasTable('working_lists');
echo 'Has working_lists table: ' . ($hasTable ? 'YES' : 'NO') . PHP_EOL;
if ($hasTable) {
    echo 'Remote Count: ' . DB::table('working_lists')->count() . PHP_EOL;
    $latest = DB::table('working_lists')->orderBy('id', 'desc')->first();
    if ($latest) {
        echo 'Latest Datetime: ' . $latest->datetime . PHP_EOL;
    }
}
