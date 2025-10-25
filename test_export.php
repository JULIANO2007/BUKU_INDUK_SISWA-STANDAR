<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$export = new App\Exports\StudentsExport();
$collection = $export->collection();

echo "Collection type: " . get_class($collection) . "\n";
echo "Collection count: " . $collection->count() . "\n";

$first = $collection->first();
echo "First item type: " . gettype($first) . "\n";

if (is_array($first)) {
    echo "First item is array\n";
    echo "Keys: " . implode(', ', array_keys($first)) . "\n";
} elseif (is_object($first)) {
    echo "First item is object\n";
    echo "Class: " . get_class($first) . "\n";
    if (isset($first->id)) {
        echo "Has ID: " . $first->id . "\n";
    }
}
