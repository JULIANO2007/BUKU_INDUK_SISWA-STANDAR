<?php

require_once 'vendor/autoload.php';

use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Contracts\Console\Kernel;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

echo "Testing Real Excel Import with actual file...\n";

// Check if there are existing test users to clean up
$testUsers = User::whereIn('nisn', ['1111111111', '2222222222', '9999999999'])->get();
if ($testUsers->count() > 0) {
    echo "Cleaning up existing test users...\n";
    foreach ($testUsers as $user) {
        $user->delete();
    }
    echo "✓ Cleaned up {$testUsers->count()} test users\n";
}

// Create a real Excel file using PhpSpreadsheet
try {
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Set headers
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
    $tempFile = tempnam(sys_get_temp_dir(), 'test_import');
    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    $writer->save($tempFile . '.xlsx');

    echo "✓ Created test Excel file: {$tempFile}.xlsx\n";

    // Now test the import
    $excelContent = file_get_contents($tempFile . '.xlsx');

    // Create uploaded file
    $uploadedFile = new \Illuminate\Http\UploadedFile(
        $tempFile . '.xlsx',
        'test_import.xlsx',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        null,
        true
    );

    // Create request
    $request = new \Illuminate\Http\Request();
    $request->files->set('file', $uploadedFile);

    // Test controller
    $controller = new \App\Http\Controllers\ExcelController();

    echo "Testing import with real Excel file...\n";

    try {
        $response = $controller->import($request);
        echo "✓ Import method executed successfully\n";

        // Check if data was imported
        $importedUsers = User::whereIn('nisn', ['1111111111', '2222222222'])->get();
        echo "✓ Found {$importedUsers->count()} imported users in database\n";

        if ($importedUsers->count() == 0) {
            echo "❌ No users were imported. Checking logs...\n";
            // Check logs for debugging
            $logPath = storage_path('logs/laravel.log');
            if (file_exists($logPath)) {
                $logs = file_get_contents($logPath);
                $lines = explode("\n", $logs);
                $recentLogs = array_slice($lines, -20); // Get last 20 lines
                echo "Recent logs:\n";
                foreach ($recentLogs as $line) {
                    if (!empty(trim($line))) {
                        echo "  $line\n";
                    }
                }
            }
        }

        foreach ($importedUsers as $user) {
            echo "  - {$user->nama_lengkap} (NISN: {$user->nisn})\n";
            if ($user->biodata) echo "    ✓ Biodata created\n";
            if ($user->ayah) echo "    ✓ Father data created\n";
            if ($user->ibu) echo "    ✓ Mother data created\n";
        }

        // Clean up
        foreach ($importedUsers as $user) {
            $user->delete();
        }
        echo "✓ Test data cleaned up\n";

        echo "\n✅ Real Excel import test PASSED!\n";

    } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
        echo "❌ Validation errors:\n";
        $failures = $e->failures();
        foreach ($failures as $failure) {
            echo "  Row {$failure->row()}: " . implode(', ', $failure->errors()) . "\n";
        }
    } catch (Exception $e) {
        echo "❌ Import failed: " . $e->getMessage() . "\n";
        echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
    }

    // Clean up temp file
    unlink($tempFile . '.xlsx');

} catch (Exception $e) {
    echo "❌ Error creating test Excel file: " . $e->getMessage() . "\n";
}
