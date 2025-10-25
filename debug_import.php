<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Imports\StudentsImport;
use Maatwebsite\Excel\Facades\Excel;

echo "Testing Excel import...\n";

// Path to test Excel file
$excelFile = 'test_import.xlsx'; // This should be an Excel file

try {
    $import = new StudentsImport();

    // Check if file exists
    if (!file_exists($excelFile)) {
        echo "File $excelFile does not exist\n";
        exit(1);
    }

    echo "Importing from $excelFile...\n";

    // Import the file
    Excel::import($import, $excelFile);

    $count = $import->getRowCount();
    echo "Import completed. Rows processed: $count\n";

} catch (Exception $e) {
    echo "Import failed: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
