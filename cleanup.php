<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// Include the autoloader and bootstrap the app
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

foreach(['incomes', 'expenses', 'savings_transactions'] as $table) {
    if (Schema::hasColumn($table, 'account_id')) {
        Schema::table($table, function($t) {
            $t->dropColumn('account_id');
        });
        echo "Dropped account_id from $table\n";
    }
}

DB::table('migrations')->where('migration', '2026_04_03_091146_add_account_id_to_transactions')->delete();
echo "Deleted migration record\n";
