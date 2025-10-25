<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Imports\StudentsImport;
use Maatwebsite\Excel\Facades\Excel;

echo "Testing Excel import with units in numeric fields...\n";

// Create a test Excel file with units in numeric columns
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

    // Add test data with units in numeric fields
    $testData = [
        ['Test Siswa Units', '3333333333', '2024333', 'testunits@example.com', 'X IPA 1', '2024/2025', 'Laki-laki',
         'Jl Test Units', 'SMPN Units', 'Jakarta', 'Menteng', 'Jakarta', '2008-03-03',
         1, 2, 0, 0, 'Indonesia', 'Islam', '5 km', '081333333333', 'O', '170 cm', '65 kg', '-', 'Membaca', 'Indonesia',
         'Ayah Units', 'Jakarta', '1980-03-03', 'Islam', 'Indonesia', 'PNS', 'S1', '6000000', 'Jl Test Units', '081333333334', 'Kandung',
         'Ibu Units', 'Bandung', '1985-03-03', 'Islam', 'Indonesia', 'IRT', 'SMA', '0', 'Jl Test Units', '081333333335', 'Kandung'],
    ];

    foreach ($testData as $rowIndex => $rowData) {
        foreach ($rowData as $colIndex => $value) {
            $sheet->setCellValueByColumnAndRow($colIndex + 1, $rowIndex + 2, $value);
        }
    }

    // Save the file
    $tempFile = tempnam(sys_get_temp_dir(), 'test_units');
    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    $writer->save($tempFile . '.xlsx');

    echo "✓ Created test Excel file with units: {$tempFile}.xlsx\n";

    // Now test the import
    echo "Testing import with units...\n";
    $import = new StudentsImport();
    Excel::import($import, $tempFile . '.xlsx');

    $count = $import->getRowCount();
    echo "✓ Import completed. Rows processed: {$count}\n";

    // Check the imported data
    $user = \App\Models\User::where('nisn', '3333333333')->first();
    if ($user) {
        echo "✓ User imported successfully\n";
        echo "  - Name: {$user->nama_lengkap}\n";

        if ($user->biodata) {
            echo "✓ Biodata imported:\n";
            echo "  - Jarak: {$user->biodata->jarak} (should be 5)\n";
            echo "  - Tinggi: {$user->biodata->tinggi} (should be 170)\n";
            echo "  - Berat: {$user->biodata->berat} (should be 65)\n";
        }

        if ($user->ayah) {
            echo "✓ Father data imported:\n";
            echo "  - Penghasilan: {$user->ayah->penghasilan} (should be 6000000)\n";
        }

        if ($user->ibu) {
            echo "✓ Mother data imported:\n";
            echo "  - Penghasilan: {$user->ibu->penghasilan} (should be null/0)\n";
        }

        // Clean up
        $user->delete();
        echo "✓ Test data cleaned up\n";
    } else {
        echo "❌ User not found in database\n";
    }

    // Clean up file
    unlink($tempFile . '.xlsx');

    echo "\n✅ Import with units test PASSED!\n";

} catch (Exception $e) {
    echo "❌ Error during import test: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
