<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== DATABASE CHECK ===\n\n";

$customers = DB::table('customers')->get();
echo "Total Customers: " . count($customers) . "\n";
if (count($customers) > 0) {
    echo "Customer List:\n";
    foreach ($customers as $cust) {
        echo "  - ID: {$cust->id}, Name: {$cust->name}\n";
    }
}

echo "\n";

$sizes = DB::table('sizes')->get();
echo "Total Sizes: " . count($sizes) . "\n";
if (count($sizes) > 0) {
    echo "Size List (first 5):\n";
    foreach (array_slice((array)$sizes, 0, 5) as $size) {
        echo "  - ID: {$size->id}, Customer ID: {$size->customer_id}, Category ID: {$size->category_id}\n";
    }
}

echo "\n";

$orders = DB::table('orders')->get();
echo "Total Orders: " . count($orders) . "\n";

echo "\n=== END CHECK ===\n";
