<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Imports\StudentsImport;

echo "Testing numeric cleaning functionality...\n";

// Create sample data with units
$testData = [
    'berat' => '55kg',
    'tinggi' => '165 cm',
    'jarak' => '5 km',
    'penghasilan_ayah' => '5000000',
    'penghasilan_ibu' => '0',
    'empty_field' => '',
    'text_only' => 'tidak ada',
];

try {
    $import = new StudentsImport();

    // Test the extractNumeric method using reflection
    $reflection = new ReflectionClass($import);
    $method = $reflection->getMethod('extractNumeric');
    $method->setAccessible(true);

    echo "Testing extractNumeric method:\n";
    foreach ($testData as $field => $value) {
        $result = $method->invoke($import, $value);
        echo "  {$field}: '{$value}' -> " . ($result === null ? 'null' : $result) . "\n";
    }

    echo "\n✅ Numeric cleaning test completed!\n";

} catch (Exception $e) {
    echo "❌ Error during testing: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
