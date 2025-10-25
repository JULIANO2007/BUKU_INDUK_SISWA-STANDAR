<?php

require_once 'vendor/autoload.php';

use App\Imports\StudentsImport;
use Illuminate\Foundation\Application;
use Illuminate\Contracts\Console\Kernel;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

echo "Testing StudentsImport class...\n";

// Test creating import instance
try {
    $import = new StudentsImport();
    echo "✓ Import class created successfully\n";

    // Test row count method
    $count = $import->getRowCount();
    echo "✓ Row count method works: {$count}\n";

    // Test validation rules
    $rules = $import->rules();
    echo "✓ Validation rules defined: " . count($rules) . " rules\n";

    // Test custom messages
    $messages = $import->customValidationMessages();
    echo "✓ Custom validation messages defined: " . count($messages) . " messages\n";

    echo "\n✅ All basic tests passed!\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
