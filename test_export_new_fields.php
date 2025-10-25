<?php

require_once 'vendor/autoload.php';

use App\Exports\StudentsExport;

echo "Testing export functionality with new fields\n";

// Test template export (empty)
echo "\n=== Testing Template Export ===\n";
$templateExport = new StudentsExport(false);
$headings = $templateExport->headings();
echo "Template headings count: " . count($headings) . "\n";
echo "First 10 headings:\n";
for ($i = 0; $i < min(10, count($headings)); $i++) {
    echo ($i + 1) . ". " . $headings[$i] . "\n";
}

// Check if new fields are present
$newFields = ['MPSN / MPN / MMT', 'NIK / No. KK', 'RT / RW', 'Kode Pos', 'Tinggal Bersama', 'Moda Kendaraan'];
echo "\n=== Checking New Fields ===\n";
foreach ($newFields as $field) {
    $found = in_array($field, $headings);
    echo "Field '$field': " . ($found ? 'FOUND' : 'NOT FOUND') . "\n";
}

// Test data export (if there are users)
echo "\n=== Testing Data Export ===\n";
$dataExport = new StudentsExport(true);
$collection = $dataExport->collection();
echo "Data collection count: " . $collection->count() . "\n";

if ($collection->count() > 0) {
    $firstUser = $collection->first();
    $mapData = $dataExport->map($firstUser);
    echo "Mapped data count: " . count($mapData) . "\n";
    echo "First 10 mapped values:\n";
    for ($i = 0; $i < min(10, count($mapData)); $i++) {
        echo ($i + 1) . ". " . ($mapData[$i] ?: 'NULL') . "\n";
    }
}

echo "\n=== Test Complete ===\n";
