<?php

require_once 'vendor/autoload.php';

use App\Imports\StudentsImport;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Contracts\Console\Kernel;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

echo "Testing StudentsImport with sample data...\n";

// Create sample data array (simulating Excel row)
$sampleRow = [
    'nama_lengkap' => 'Ahmad Surya',
    'nisn' => '9999999999', // Use unique NISN for testing
    'nis' => '2024999', // Use unique NIS
    'email' => 'ahmad.surya.test@example.com', // Use unique email
    'kelas' => 'X IPA 1',
    'tahun_ajaran' => '2024/2025',
    'jenis_kelamin' => 'Laki-laki',
    'alamat' => 'Jl. Contoh No. 123',
    'sekolah_asal' => 'SMP Negeri 1 Jakarta',
    'kota' => 'Jakarta',
    'kecamatan' => 'Menteng',
    'tempat_lahir' => 'Jakarta',
    'tanggal_lahir' => '2008-05-15',
    'anak_ke' => 1,
    'jlh_saudara' => 2,
    'saudara_tiri' => 0,
    'saudara_angkat' => 0,
    'bahasa' => 'Indonesia',
    'agama' => 'Islam',
    'jarak' => 5,
    'nomor_hp' => '081234567890',
    'goldar' => 'O',
    'tinggi' => 165,
    'berat' => 55,
    'penyakit' => '-',
    'hobi' => 'Membaca, Olahraga',
    'kewarganegaraan' => 'Indonesia',
    'nama_ayah' => 'Budi Surya',
    'tempat_lahir_ayah' => 'Jakarta',
    'tanggal_lahir_ayah' => '1980-03-10',
    'agama_ayah' => 'Islam',
    'kewarganegaraan_ayah' => 'Indonesia',
    'pekerjaan_ayah' => 'Pegawai Swasta',
    'pendidikan_ayah' => 'S1 Teknik Informatika',
    'penghasilan_ayah' => 5000000,
    'alamat_ayah' => 'Jl. Contoh No. 123',
    'nomor_hp_ayah' => '081234567891',
    'status_ayah' => 'Kandung',
    'nama_ibu' => 'Siti Aminah',
    'tempat_lahir_ibu' => 'Bandung',
    'tanggal_lahir_ibu' => '1985-07-20',
    'agama_ibu' => 'Islam',
    'kewarganegaraan_ibu' => 'Indonesia',
    'pekerjaan_ibu' => 'Ibu Rumah Tangga',
    'pendidikan_ibu' => 'SMA',
    'penghasilan_ibu' => 0,
    'alamat_ibu' => 'Jl. Contoh No. 123',
    'nomor_hp_ibu' => '081234567892',
    'status_ibu' => 'Kandung',
];

try {
    $import = new StudentsImport();

    // Test model method with sample data
    echo "Testing model() method with sample data...\n";
    $result = $import->model($sampleRow);

    if ($result instanceof User) {
        echo "✓ Model method returned User instance\n";
        echo "✓ User created with ID: {$result->id}\n";
        echo "✓ NISN: {$result->nisn}\n";
        echo "✓ Name: {$result->nama_lengkap}\n";

        // Check if related data was created
        if ($result->biodata) {
            echo "✓ Biodata created\n";
        }
        if ($result->ayah) {
            echo "✓ Father data created\n";
        }
        if ($result->ibu) {
            echo "✓ Mother data created\n";
        }

        // Check row count
        $count = $import->getRowCount();
        echo "✓ Row count after import: {$count}\n";

        // Clean up test data
        $result->delete(); // This will cascade delete related data
        echo "✓ Test data cleaned up\n";
    } else {
        echo "❌ Model method did not return User instance\n";
    }

    echo "\n✅ Import functionality test passed!\n";

} catch (Exception $e) {
    echo "❌ Error during import test: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
