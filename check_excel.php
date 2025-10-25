<?php

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Contracts\Console\Kernel;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

echo "Checking Excel file content...\n";

// Create a simple Excel file to check
try {
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Set headers (lowercase as expected by WithHeadingRow)
    $headers = [
        'nama_lengkap', 'nisn', 'nis', 'email', 'kelas', 'tahun_ajaran', 'jenis_kelamin',
        'alamat', 'sekolah_asal', 'kota', 'kecamatan', 'tempat_lahir', 'tanggal_lahir',
        'anak_ke', 'jlh_saudara', 'saudara_tiri', 'saudara_angkat', 'bahasa', 'agama',
        'jarak', 'nomor_hp', 'goldar', 'tinggi', 'berat', 'penyakit', 'hobi', 'kewarganegaraan',
        'nama_ayah', 'tempat_lahir_ayah', 'tanggal_lahir_ayah', 'agama_ayah', 'kewarganegaraan_ayah',
        'pekerjaan_ayah', 'pendidikan_ayah', 'penghasilan_ayah', 'alamat_ayah', 'nomor_hp_ayah', 'status_ayah',
        'nama_ibu', 'tempat_lahir_ibu', 'tanggal_lahir_ibu', 'agama_ibu', 'kewarganegaraan_ibu',
        'pekerjaan_ibu', 'pendidikan_ibu', 'penghasilan_ibu', 'alamat_ibu', 'nomor_hp_ibu', 'status_ibu'
    ];

    foreach ($headers as $col => $header) {
        $sheet->setCellValueByColumnAndRow($col + 1, 1, $header);
    }

    // Add test data
    $testData = [
        ['Test Siswa 1', '1111111111', '2024111', 'test1@example.com', 'X IPA 1', '2024/2025', 'Laki-laki',
         'Jl Test 1', 'SMPN 1', 'Jakarta', 'Menteng', 'Jakarta', '2008-01-01',
         1, 2, 0, 0, 'Indonesia', 'Islam', 5, '081111111111', 'O', 165, 55, '-', 'Membaca', 'Indonesia',
         'Bapak Test', 'Jakarta', '1980-01-01', 'Islam', 'Indonesia', 'PNS', 'S1', 5000000, 'Jl Test 1', '081111111112', 'Kandung',
         'Ibu Test', 'Bandung', '1985-01-01', 'Islam', 'Indonesia', 'IRT', 'SMA', 0, 'Jl Test 1', '081111111113', 'Kandung'],

        ['Test Siswa 2', '2222222222', '2024222', 'test2@example.com', 'X IPA 2', '2024/2025', 'Perempuan',
         'Jl Test 2', 'SMPN 2', 'Bandung', 'Cidadap', 'Bandung', '2008-02-02',
         1, 1, 0, 0, 'Indonesia', 'Islam', 3, '082222222222', 'A', 160, 50, '-', 'Menulis', 'Indonesia',
         'Ayah Test 2', 'Bandung', '1982-02-02', 'Islam', 'Indonesia', 'Wiraswasta', 'SMA', 3000000, 'Jl Test 2', '082222222223', 'Kandung',
         'Ibu Test 2', 'Jakarta', '1987-02-02', 'Islam', 'Indonesia', 'Guru', 'S1', 4000000, 'Jl Test 2', '082222222224', 'Kandung']
    ];

    foreach ($testData as $row => $data) {
        foreach ($data as $col => $value) {
            $sheet->setCellValueByColumnAndRow($col + 1, $row + 2, $value);
        }
    }

    // Save to temporary file
    $tempFile = tempnam(sys_get_temp_dir(), 'check_excel');
    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    $writer->save($tempFile . '.xlsx');

    echo "✓ Created Excel file: {$tempFile}.xlsx\n";

    // Now read it back to check content
    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    $spreadsheet2 = $reader->load($tempFile . '.xlsx');
    $sheet2 = $spreadsheet2->getActiveSheet();

    echo "Checking Excel file content:\n";
    echo "Highest row: " . $sheet2->getHighestRow() . "\n";
    echo "Highest column: " . $sheet2->getHighestColumn() . "\n";

    // Check headers
    echo "\nHeaders (Row 1):\n";
    for ($col = 1; $col <= count($headers); $col++) {
        $value = $sheet2->getCellByColumnAndRow($col, 1)->getValue();
        echo "  Column $col: '$value'\n";
    }

    // Check first data row
    echo "\nFirst data row (Row 2):\n";
    for ($col = 1; $col <= count($headers); $col++) {
        $value = $sheet2->getCellByColumnAndRow($col, 2)->getValue();
        echo "  Column $col: '$value'\n";
    }

    // Now test the import directly
    echo "\nTesting direct import...\n";
    $import = new \App\Imports\StudentsImport();

    // Use Laravel Excel to read the file
    $collection = \Maatwebsite\Excel\Facades\Excel::toCollection($import, $tempFile . '.xlsx');

    echo "Collection count: " . $collection->count() . "\n";
    if ($collection->count() > 0) {
        $sheetData = $collection->first();
        echo "Sheet data count: " . $sheetData->count() . "\n";

        foreach ($sheetData as $index => $row) {
            echo "Row " . ($index + 1) . ": " . json_encode($row) . "\n";
        }
    }

    // Now test the actual import
    echo "\nTesting actual import with StudentsImport...\n";
    $import2 = new \App\Imports\StudentsImport();
    \Maatwebsite\Excel\Facades\Excel::import($import2, $tempFile . '.xlsx');

    echo "Import row count: " . $import2->getRowCount() . "\n";

    // Check database
    $users = \App\Models\User::whereIn('nisn', ['1111111111', '2222222222'])->get();
    echo "Users in database: " . $users->count() . "\n";

    foreach ($users as $user) {
        echo "  - {$user->nama_lengkap} (NISN: {$user->nisn})\n";
    }

    // Clean up
    foreach ($users as $user) {
        $user->delete();
    }

    // Clean up
    unlink($tempFile . '.xlsx');

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
