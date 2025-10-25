<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$export = new App\Exports\StudentsExport(true); // Export data siswa
$collection = $export->collection();

echo "Collection count: " . $collection->count() . "\n";

$first = $collection->first();
echo "First item type: " . gettype($first) . "\n";

if (is_object($first)) {
    echo "First item is User model\n";
    echo "ID: " . $first->id . "\n";
    echo "Name: " . $first->nama_lengkap . "\n";
    echo "Status: " . $first->status . "\n";
    echo "Biodata: " . (isset($first->biodata) ? 'exists' : 'null') . "\n";
    if ($first->biodata) {
        echo "Biodata tanggal_lahir: " . ($first->biodata->tanggal_lahir ? $first->biodata->tanggal_lahir->format('Y-m-d') : 'null') . "\n";
    }
    echo "Ayah: " . (isset($first->ayah) ? 'exists' : 'null') . "\n";
    if ($first->ayah) {
        echo "Ayah tanggal_lahir: " . ($first->ayah->tanggal_lahir ? $first->ayah->tanggal_lahir : 'null') . "\n";
    }
    echo "Ibu: " . (isset($first->ibu) ? 'exists' : 'null') . "\n";
    if ($first->ibu) {
        echo "Ibu tanggal_lahir: " . ($first->ibu->tanggal_lahir ? $first->ibu->tanggal_lahir : 'null') . "\n";
    }
}

// Test the map function
try {
    $mapped = $export->map($first);
    echo "Map function succeeded\n";
    echo "Mapped array count: " . count($mapped) . "\n";
    if (count($mapped) > 0) {
        echo "First 5 fields: " . implode(', ', array_slice($mapped, 0, 5)) . "\n";
    }
} catch (Exception $e) {
    echo "Map function failed: " . $e->getMessage() . "\n";
}
